<?php
     session_start();

     if (isset($_FILES['ownerImg']) && $_FILES['ownerImg']['error'] === UPLOAD_ERR_OK) {
        $tmp_boarder = $_FILES['ownerImg']['tmp_name'];
        $ownerImg = file_get_contents($tmp_boarder);
     }else{
        $tempuserId= $_SESSION['userId'];

        $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
        if ($temp1conn->connect_error) {
            die("Connection Failed: " . $temp1conn->connect_error);
        }
        $temp1sql = "SELECT ownerImg FROM ownerdetails WHERE userId = ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId = $tempuserId; 
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($ownerImg);
        $temp1stmt->fetch();
        $temp1stmt->close();
     }


     $ownerName = $_POST['ownerName'];
     $ownerBday = $_POST['ownerBday'];
     $ownerGender = $_POST['ownerGender'];
     $ownerAge = $_POST['ownerAge'];
     $ownerAddress = $_POST['ownerAddress'];
     $ownerCPNum = $_POST['ownerCPNum'];
     $ownerCStatus = $_POST['ownerCStatus'];
    
    $userId= $_SESSION['userId'];
        

	$ownerConn = new mysqli('localhost','root','','bhfinder_registration');
	if ($ownerConn->connect_error) {
        die("Connection failed: " . $ownerConn->connect_error);
    }
    $ownerSql = "UPDATE ownerdetails SET ownerName=?, ownerBday=?, ownerGender=?, ownerAge=?, ownerAddress=?, ownerCPNum=?
        , ownerCStatus=?, ownerImg=? WHERE userId =  $userId";    
    $ownerStmt = $ownerConn->prepare($ownerSql);
    $ownerStmt->bind_param("sssisiss", $ownerName, $ownerBday, $ownerGender, $ownerAge, $ownerAddress
    , $ownerCPNum, $ownerCStatus, $ownerImg);
    if ($ownerStmt->execute()) {
        echo "Owner information updated successfully.";
    } else {
        echo "Error1: " . $ownerConn->error;
    }
    

    $ownerStmt->close();
    $ownerConn->close();

    $url = 'profile-owner.php';
	header('Location: ' . $url);

