<?php
$filename = $_GET['id'];
try {
    // open connection to MongoDB server
    $m = new MongoClient(); // connect
    $db = $m->selectDB("example");
    $client = $db->getGridFS();

    // retrieve file from collection
    header('Content-type: image/png');
    $file = $client->findOne(array('filename' => $filename ));

    // send headers and file data

    echo $file->getBytes();
    exit;

    // disconnect from server
    //$conn->close();
} catch (MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
} catch (MongoException $e) {
    die('Error: ' . $e->getMessage());
}
?>