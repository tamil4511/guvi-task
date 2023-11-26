<?php
require_once("../vendor/predis/predis/autoload.php");
require_once("../vendor/autoload.php");
$mongoDB = 'mongoDB';
try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    if ($mongoClient) {
        $database = $mongoClient->$mongoDB;
        $collection = $database->profile;
    } else {
        echo "Error connecting to MongoDB";
        exit();
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Error connecting to MongoDB: " . $e->getMessage();
    exit();
}
$redis = new Predis\Client();
$redisKey = "user";
$userEmail = $redis->hget($redisKey, 'email');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "socialmedia") {
       
        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $linkedin = $_POST['linkedin'];

        $filter = ['email' => $userEmail];


        $existingData = $collection->findOne($filter);


        $updateData = ['$set' => []];

        if (!empty($facebook)) {
            $updateData['$set']['facebook'] = $facebook;
        } else {

            $updateData['$set']['facebook'] = $existingData['facebook'];
        }

        if (!empty($twitter)) {
            $updateData['$set']['twitter'] = $twitter;
        } else {
            $updateData['$set']['twitter'] = $existingData['twitter'];
        }

        if (!empty($linkedin)) {
            $updateData['$set']['linkedin'] = $linkedin;
        } else {
            $updateData['$set']['linkedin'] = $existingData['linkedin'];
        }

        $result = $collection->updateOne($filter, $updateData);

        if ($result->getModifiedCount() > 0) {
            echo 'Data updated successfully';
        } else {
            echo 'No changes';
        }
    } elseif ($_POST["action"] == "profile") {
       
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mobileno = $_POST['mobileno'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];

        $filter = ['email' => $userEmail];


        $existingData = $collection->findOne($filter);

        $updateData = ['$set' => []];


        if (!empty($firstname)) {
            $updateData['$set']['firstname'] = $firstname;
        } else {

            $updateData['$set']['firstname'] = $existingData['firstname'];
        }

        if (!empty($lastname)) {
            $updateData['$set']['lastname'] = $lastname;
        } else {
            $updateData['$set']['lastname'] = $existingData['lastname'];
        }

        if (!empty($mobileno)) {
            $updateData['$set']['mobileno'] = $mobileno;
        } else {
            $updateData['$set']['mobileno'] = $existingData['mobileno'];
        }

        if (!empty($dob)) {
            $updateData['$set']['dob'] = $dob;
        } else {
            $updateData['$set']['dob'] = $existingData['dob'];
        }

        if (!empty($address) && $address!=='                           ') {
            $updateData['$set']['address'] = $address;
        } else {
            $updateData['$set']['address'] = $existingData['address'];
        }

        if (!empty($district)) {
            $updateData['$set']['district'] = $district;
        } else {
            $updateData['$set']['district'] = $existingData['district'];
        }

        if (!empty($pincode)) {
            $updateData['$set']['pincode'] = $pincode;
        } else {
            $updateData['$set']['pincode'] = $existingData['pincode'];
        }


        $result = $collection->updateOne($filter, $updateData);

        if ($result->getModifiedCount() > 0) {
            echo 'Data updated successfully';
        } else {
            echo 'No changes';
        }
    } else {

        echo "Invalid action";
    }
} else {

    echo "Invalid request";
}
?>
