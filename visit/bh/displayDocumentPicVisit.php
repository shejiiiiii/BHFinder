<?php

// Establish database connection
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

    // Fetch documents for each bhId
    $documentType = array("bhPermit", "bhFire", "bhSanitary", "bhPolice", "bhMembership", "bhBusiness");
    $i = $_GET['i'];

    $sql = "SELECT ? FROM bhdocuments WHERE bhId = ?";
    $stmt = $bhConn->prepare($sql);
    $bhId = $_GET['bhId'];
    $stmt->bind_param("si", $documentType[$i], $bhId);
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

