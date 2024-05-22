<?php
     session_start();

     if (isset($_FILES['bhPic']) && $_FILES['bhPic']['error'] === UPLOAD_ERR_OK) {
        $tmp_boarder = $_FILES['bhPic']['tmp_name'];
        $bhPic = file_get_contents($tmp_boarder);
     }else{
        $tempuserId= $_SESSION['userId'];

        $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
        if ($temp1conn->connect_error) {
            die("Connection Failed: " . $temp1conn->connect_error);
        }
        $temp1sql = "SELECT bhPic FROM bhdetails WHERE userId = ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId = $tempuserId; 
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($bhPic);
        $temp1stmt->fetch();
        $temp1stmt->close();
     }


     $bhName = $_POST['bhName'];
     $bhAddress = $_POST['bhAddress'];
     $bhCPNum = $_POST['bhCPNum'];
     $bhPrice = $_POST['bhPrice'];
     $bhOccupants = $_POST['bhOccupants'];
     $bhAmmenities = $_POST['bhAmmenities'];
    
     $userId= $_SESSION['userId'];
     $ownerSql = "UPDATE ownerdetails SET ownerName=?, ownerBday=?, ownerGender=?, ownerAge=?, ownerAddress=?, ownerCPNum=?
        , ownerCStatus=?, ownerImg=? WHERE userId =  $userId";  
        

        $bhConn = new mysqli('localhost','root','','bhfinder_boardinghouse');
        if($bhConn->connect_error){
            echo "$conn->connect_error";
            die("Connection Failed : ". $bhConn->connect_error);
        } else 
        {
            $bhSql = "UPDATE bhdetails SET bhName=?, bhAddress=?, bhCPNum=?, bhPrice=?, bhOccupants=?
            , bhPic=? WHERE userId =  $userId";
            $bhStmt = $bhConn->prepare($bhSql);
            $bhStmt->bind_param("ssiiss", $bhName, $bhAddress, $bhCPNum, $bhPrice, $bhOccupants
            , $bhPic);
            if ($bhStmt->execute()) {
                echo "Processing...";
            } else {
                echo "Error1: " . $bhConn->error;
            }
    
            // FOR AMMENITIES
            $i = 1;
            $bhId = $bhStmt->insert_id;

            $sql = "DELETE FROM bhammenities WHERE userId =  $userId";   
            $stmt = $bhConn->prepare($sql);    
            if ($stmt->execute()) {
                echo "Record deleted successfully";
            } else {
                echo "Error: " . $conn->error;
            }
            $stmt->close();
        
    
            foreach($bhAmmenities as $bhAmmenity){
                $ammenityId = $bhAmmenity == "WiFi" ? 1 : ($bhAmmenity == "Laundry" ? 2 : 3);
                echo $ammenityId . " ";
                $bhSql = "INSERT INTO bhammenities (ammenityId, bhAmmenity, userId)
                            VALUES (?, ?, ?)";
                $bhStmt = $bhConn->prepare($bhSql);
                $bhStmt->bind_param("isi", $ammenityId, $bhAmmenity, $userId);
    
                if($bhStmt->execute()){
                    echo count($bhAmmenities) == $i ? "Registration successfully for Boarding House Registration..." : "Processing...";
                    $i++;
                } else {
                    echo "Error1: " . $bhConn->error;
                }
    
                $bhStmt->close();
            }
            $bhConn->close();
        }

    $url = 'profile-owner-bh.php';
	header('Location: ' . $url);

