<?php

return [
    'credentials' => storage_path('firebase/firebase_credentials.json'),
    'database_url' => env('FIREBASE_DATABASE_URL', 'https://noctivent-web-default-rtdb.asia-southeast1.firebasedatabase.app/'),
];
