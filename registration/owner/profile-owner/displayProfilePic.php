<?php
session_start();
$tempuserId= $_SESSION['userId'];

// Establish database connection
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

    // Fetch documents for each bhId
    $sql = "SELECT ownerImg FROM ownerdetails WHERE userId = ?";
    $stmt = $bhConn->prepare($sql);
    $userId = $tempuserId; 
    $stmt->bind_param("i", $userId);
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

