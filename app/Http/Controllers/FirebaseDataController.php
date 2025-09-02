<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Log;
use Exception;

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

    /**
     * Get all dummy data from Firebase RTDB (from root)
     */
    public function getDummyData(): JsonResponse
    {
        try {
            // Data ada di root, bukan di node 'dummy-data'
            $reference = $this->database->getReference('/');
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

    /**
     * Get data by specific date (from root)
     */
    public function getDataByDate($date): JsonResponse
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

            // Filter by date
            $filteredData = array_filter($data, function ($item) use ($date) {
                return isset($item['date']) && $item['date'] === $date;
            });

            return response()->json([
                'success' => true,
                'data' => array_values($filteredData),
                'count' => count($filteredData)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Firebase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new data to Firebase (to root)
     */
    public function addData(): JsonResponse
    {
        try {
            $reference = $this->database->getReference('/');

            // Sample data - ganti dengan data dari request
            $newData = [
                'date' => now()->format('D, j/n/y'),
                'hour' => now()->format('H.i'),
                'Tin' => rand(20, 30),
                'Hin' => rand(70, 90),
                'Tout' => rand(20, 35),
                'Hout' => rand(65, 85)
            ];

            // Push data baru ke array
            $reference->push($newData);

            return response()->json([
                'success' => true,
                'message' => 'Data added successfully',
                'data' => $newData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add data to Firebase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest data (last record from root)
     */
    public function getLatestData(): JsonResponse
    {
        try {
            $reference = $this->database->getReference('/');
            $snapshot = $reference->orderByKey()->limitToLast(1)->getSnapshot();
            $data = $snapshot->getValue();

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found'
                ], 404);
            }

            // Get the last item
            $latestData = end($data);

            return response()->json([
                'success' => true,
                'data' => $latestData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch latest data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete all data (be careful!) from root
     */
    public function clearData(): JsonResponse
    {
        try {
            $reference = $this->database->getReference('/');
            $reference->remove();

            return response()->json([
                'success' => true,
                'message' => 'All data cleared successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test connection to Firebase
     */
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

    /**
     * Debug: See all data structure in Firebase
     */
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

    /**
     * Get data from any path
     */
    public function getDataFromPath($path): JsonResponse
    {
        try {
            $reference = $this->database->getReference($path);
            $snapshot = $reference->getSnapshot();
            $data = $snapshot->getValue();

            return response()->json([
                'success' => true,
                'path' => $path,
                'data' => $data,
                'data_type' => gettype($data),
                'is_array' => is_array($data),
                'count' => is_array($data) ? count($data) : 0
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Failed to fetch data from path: {$path}",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data by specific hour
     */
    public function getDataByHour($hour): JsonResponse
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

            // Filter by hour
            $filteredData = array_filter($data, function ($item) use ($hour) {
                return isset($item['hour']) && $item['hour'] === $hour;
            });

            return response()->json([
                'success' => true,
                'data' => array_values($filteredData),
                'count' => count($filteredData)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Firebase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get temperature summary (min, max, average)
     */
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
}
