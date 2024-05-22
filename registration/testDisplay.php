<?php
// Establish database connection
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

// Retrieve image data from the database
$sql = "SELECT ownerImg FROM ownerdetails WHERE ownerId = ?"; // Change 'id' to the appropriate column name
$stmt = $bhConn->prepare($sql);
$id = 13; // Change '1' to the ID of the record you want to retrieve
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($ownerImg);
    $stmt->fetch();

    $imageType = false;
    $firstBytes = substr($ownerImg, 0, 2);
    if ($firstBytes === "\xFF\xD8") {
        $imageType = "jpeg";
    } elseif ($firstBytes === "\x89\x50") {
        $imageType = "png";
    }

    if ($imageType === "jpeg") {
        header("Content-Type: image/jpeg");
    } elseif ($imageType === "png") {
        header("Content-Type: image/png");
    } else {
        echo "Unsupported image type.";
        exit;
    }
    echo $ownerImg;
} else {
    echo "Image not found.";
}

$stmt->close();
$bhConn->close();
?>
