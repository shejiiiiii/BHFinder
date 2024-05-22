<?php

// Establish database connection
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

    // Fetch documents for each bhId
    $sql = "SELECT bhPic FROM bhdetails WHERE ownerId = ?";
    $stmt = $bhConn->prepare($sql);
    $ownerId = $_GET['ownerId'];
    $stmt->bind_param("i", $ownerId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($bhPic);
        $stmt->fetch();

        $imageType = false;
        $firstBytes = substr($bhPic, 0, 2);
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
        echo $bhPic;
    } else {
        echo "Image not found.";
    }

$stmt->close();
$bhConn->close();
?>

