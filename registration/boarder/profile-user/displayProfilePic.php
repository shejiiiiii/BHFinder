<?php
session_start();
$tempuserId= $_SESSION['userId'];

// Establish database connection
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

    // Fetch documents for each bhId
    $sql = "SELECT boarderImg FROM boarderdetails WHERE userId = ?";
    $stmt = $bhConn->prepare($sql);
    $userId = $tempuserId; 
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($boarderImg);
        $stmt->fetch();

        $imageType = false;
        $firstBytes = substr($boarderImg, 0, 2);
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
        echo $boarderImg;
    } else {
        echo "Image not found.";
    }

$stmt->close();
$bhConn->close();
?>

<!-- if (isset($_GET['image']) && is_numeric($_GET['image'])) {
            $imageIndex = $_GET['image'] - 1;
        
            if ($stmt->num_rows > 0) {
                   
                $stmt->bind_result($bhFire, $bhMayor, $bhHealth);
                $stmt->fetch();
        
                $docs = [$bhFire, $bhMayor, $bhHealth];
        
                if ($imageIndex >= 0 && $imageIndex < count($docs)) {
                    $imageType = getImageType($docs[$imageIndex]);
                    if ($imageType === "jpeg") {
                        header("Content-Type: image/jpeg");
                    } elseif ($imageType === "png") {
                        header("Content-Type: image/png");
                    } else {
                        echo "Unsupported image type.";
                        exit;
                    }
        
                    echo $docs[$imageIndex];
                } else {
                    echo "Image not found.";
                }


                
            } else {
                echo "No images found.";
            }
        } 
        else {
            echo "Invalid image psarameter.";
        } -->



        <!-- if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) {
            $docs = [$bhFire, $bhMayor, $bhHealth];

            foreach ($docs as $doc) {
                $imageType = getImageType($doc);
                if ($imageType === "jpeg") {
                    header("Content-Type: image/jpeg");
                } elseif ($imageType === "png") {
                    header("Content-Type: image/png");
                } else {
                    echo "Unsupported image type.";
                    continue; // Skip to the next image
                }

                echo $doc;
                echo "<br>"; // Add a line break for clarity between images
            }
        }
    } else {
        echo "No images found for bhId: $bhId";
    } -->