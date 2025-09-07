config

-   copy & paste .env.example and rename it to .env
-   create rtdb firebase
-   change code in /.env, line FIREBASE_DATABASE_URL= {to rtdb url}
-   generate private key firebase firebase setting -> service account -> generate private key
-   change name generated_private_key to firebase_credentials.json
-   move firebase_credentials.json to /storage/firebase/firebase_credentials.json
