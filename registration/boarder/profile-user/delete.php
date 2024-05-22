<?php
    session_start();
    $userId= $_SESSION['userId'];


    $conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM boarderdetails WHERE userId =  $userId";   
    $stmt = $conn->prepare($sql);    
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();

    $conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM userdetails WHERE userId =  $userId";   
    $stmt = $conn->prepare($sql);    
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();

    session_abort();
    session_destroy();
    $url = '../../../index.html';
	header('Location: ' . $url);


?>