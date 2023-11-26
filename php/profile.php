<?php
require_once("../vendor/predis/predis/autoload.php");
require_once("../vendor/autoload.php");

use MongoDB\Client as MongoClient;
$redis = new Predis\Client();
$redisKey = "user";
$userEmail = $redis->hget($redisKey, 'email');
$mongoDB = 'mongoDB'; 
$mongoClient = new MongoClient("mongodb://localhost:27017");
$database = $mongoClient->$mongoDB;
$collection = $database->profile; 


if ($userEmail !== null) {
    try {
  
        $existingDocument = $collection->findOne(['email' => $userEmail]);

        if (!$existingDocument) {
            $newDocument = [
                'email' => $userEmail,
                'firstname' => "NA",
                'lastname' => "NA", // Corrected typo here
                'mobileno' => "NA",
                'dob' => "NA",
                'address' => "NA",
                'district' => "NA",
                'pincode' => "NA",
                'facebook' => 'NA',
                'twitter' => 'NA',
                'linkedin' => 'NA'
            ];

            $result = $collection->insertOne($newDocument);

            if ($result->getInsertedCount() > 0) {
                echo 'Document inserted in MongoDB successfully.';
            } else {
                echo 'Failed to insert document in MongoDB.';
            }
        }

        $userData = $collection->findOne(['email' => $userEmail]);

        if ($userData) {
        } else {
            echo 'User data not found in MongoDB.';
        }

    } catch (\Exception $e) {
        echo 'Error connecting to MongoDB: ' . $e->getMessage();
    }
} else {
    echo "User email not found in Redis.";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $document = $collection->findOne(['email' => $userEmail]);

    $document = $collection->findOne(['email' => $userEmail]);

if ($document !== null) {
    $response = [
        'firstname' => $document['firstname'],
        'lastname' => $document['lastname'],
        'mobileno' => $document['mobileno'],
        'dob' => $document['dob'],
        'address' => $document['address'],
        'district' => $document['district'],
        'pincode' => $document['pincode']
    ];

    echo json_encode($response);
} else {
    echo json_encode([
        'error' => 'Document not found'
    ]);
}

}


if (isset($_POST['logout'])) {
   
    $redis = new Predis\Client();
    $redisKey = "user";
    $redis->del($redisKey);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

?>
