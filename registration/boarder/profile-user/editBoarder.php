<?php
     session_start();

     if (isset($_FILES['boarderImg']) && $_FILES['boarderImg']['error'] === UPLOAD_ERR_OK) {
        $tmp_boarder = $_FILES['boarderImg']['tmp_name'];
        $boarderImg = file_get_contents($tmp_boarder);
     }else{
        $tempuserId= $_SESSION['userId'];

        $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
        if ($temp1conn->connect_error) {
            die("Connection Failed: " . $temp1conn->connect_error);
        }
        $temp1sql = "SELECT boarderImg FROM boarderdetails WHERE userId = ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId = $tempuserId; 
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($boarderImg);
        $temp1stmt->fetch();
        $temp1stmt->close();
     }


    $boarderName = $_POST['boarderName'];
    $boarderBday = $_POST['boarderBday'];
    $boarderGender = $_POST['boarderGender'];
    $boarderAge = $_POST['boarderAge'];
    $boarderAddress = $_POST['boarderAddress'];
    $boarderCPNum = $_POST['boarderCPNum'];
    $boarderCStatus = $_POST['boarderCS'];
    
    $userId= $_SESSION['userId'];
        

	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE boarderdetails SET boarderName=?, boarderBday=?, boarderGender=?, boarderAge=?, boarderAddress=?
    , boarderCPNum=?, boarderCStatus=?, boarderImg=? WHERE userId =  $userId";       
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisiss", $boarderName, $boarderBday, $boarderGender, $boarderAge, $boarderAddress
    , $boarderCPNum, $boarderCStatus, $boarderImg);
    if ($stmt->execute()) {
        echo "Boarder information updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    $url = 'profile-user View.php';
	header('Location: ' . $url);

