<?php
     session_start();

    
    $userId= $_SESSION['userId'];
    $bhId= $_GET['bhId'];
        

	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE boarderdetails SET bhId=? WHERE userId =  $userId";       
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bhId);
    if ($stmt->execute()) {
        echo "Boarder information updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    $url = '../../registration/boarder/profile-user/profile-user View.php';
	header('Location: ' . $url);

