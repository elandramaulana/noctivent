<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FirebaseDataController extends Controller
{
    protected $database;

    public function __construct()
    {
        try {
            $factory = (new Factory)
                ->withServiceAccount(storage_path('firebase/firebase_credentials.json'))
                ->withDatabaseUri(config('firebase.database_url'));

            $this->database = $factory->createDatabase();
        } catch (Exception $e) {
            Log::error('Firebase connection failed: ' . $e->getMessage());
            throw new Exception('Firebase connection failed');
        }
    }

    
    //  Get all dummy summary data from Firebase
     
    public function getDummyData(): JsonResponse
    {
        try {
            $reference = $this->database->getReference('/data');
            $snapshot = $reference->getSnapshot();
            $data = $snapshot->getValue();

            return response()->json([
                'success' => true,
                'data' => $data ?? [],
                'count' => is_array($data) ? count($data) : 0
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Firebase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    //  Test connection to Firebase
    public function testConnection(): JsonResponse
    {
        try {
            // Simple test - get root reference
            $reference = $this->database->getReference('/');
            $snapshot = $reference->getSnapshot();

            return response()->json([
                'success' => true,
                'message' => 'Firebase connection successful',
                'timestamp' => now()->toISOString()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase connection failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    //  Debug: See all data structure in Firebase
     
    public function debugAllData(): JsonResponse
    {
        try {
            // Get root data
            $reference = $this->database->getReference('/');
            $snapshot = $reference->getSnapshot();
            $rootData = $snapshot->getValue();

            return response()->json([
                'success' => true,
                'message' => 'All Firebase data',
                'root_data' => $rootData,
                'root_keys' => $rootData ? array_keys($rootData) : []
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch debug data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    //  Get temperature summary (min, max, average)
     
    public function getTemperatureSummary(): JsonResponse
    {
        try {
            $reference = $this->database->getReference('/');
            $snapshot = $reference->getSnapshot();
            $data = $snapshot->getValue();

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found'
                ], 404);
            }

            $tinValues = array_column($data, 'Tin');
            $toutValues = array_column($data, 'Tout');
            $hinValues = array_column($data, 'Hin');
            $houtValues = array_column($data, 'Hout');

            return response()->json([
                'success' => true,
                'summary' => [
                    'temperature_indoor' => [
                        'min' => min($tinValues),
                        'max' => max($tinValues),
                        'avg' => round(array_sum($tinValues) / count($tinValues), 2)
                    ],
                    'temperature_outdoor' => [
                        'min' => min($toutValues),
                        'max' => max($toutValues),
                        'avg' => round(array_sum($toutValues) / count($toutValues), 2)
                    ],
                    'humidity_indoor' => [
                        'min' => min($hinValues),
                        'max' => max($hinValues),
                        'avg' => round(array_sum($hinValues) / count($hinValues), 2)
                    ],
                    'humidity_outdoor' => [
                        'min' => min($houtValues),
                        'max' => max($houtValues),
                        'avg' => round(array_sum($houtValues) / count($houtValues), 2)
                    ]
                ],
                'total_records' => count($data)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update vent status (open/close) 

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:open,close'
        ]);
        
        try {
            $newStatus = $request->input('status');
            $currentTime = now();
            
            $this->database
                ->getReference('vent/status')
                ->set($newStatus);

            $this->database
                ->getReference('vent/last_update')
                ->set($currentTime->format('Y-m-d H:i:s'));

            Log::info('Vent status updated to: ' . $newStatus . ' at ' . $currentTime->format('Y-m-d H:i:s'));

            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => 'Status berhasil diubah ke ' . $newStatus,
                'updated_at' => $currentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating vent status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get current vent status 
    public function getStatus()
    {
        try {
            $currentTime = now();
            $autoUpdated = false;
            
            $todayStart = $currentTime->copy()->setTime(4, 0, 0);
            $todayEnd = $currentTime->copy()->setTime(6, 0, 0);
            
            if ($currentTime->between($todayStart, $todayEnd)) {
                $lastUpdate = $this->database
                    ->getReference('vent/last_update')
                    ->getValue();

                $needsAutoUpdate = false;
                
                if ($lastUpdate) {
                    $lastUpdateTime = \Carbon\Carbon::parse($lastUpdate);
        
                    if (!$lastUpdateTime->isToday() || 
                        !$lastUpdateTime->between($todayStart, $todayEnd)) {
                        $needsAutoUpdate = true;
                    }
                } else {
                    $needsAutoUpdate = true;
                }

                if ($needsAutoUpdate) {
                    $autoStatus = 'open'; 
                    
                    $this->database
                        ->getReference('vent/status')
                        ->set($autoStatus);
                        
                    $this->database
                        ->getReference('vent/last_update')
                        ->set($currentTime->format('Y-m-d H:i:s'));

                    Log::info('Auto vent status updated to: ' . $autoStatus . ' at ' . $currentTime->format('Y-m-d H:i:s'));
                    
                    $autoUpdated = true;
                }
            }

            $reference = $this->database->getReference('vent/status');
            $status = $reference->getValue();

            return response()->json([
                'success' => true,
                'status' => $status ?? 'close',
                'message' => 'Status berhasil diambil',
                'auto_updated' => $autoUpdated
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting vent status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

}
