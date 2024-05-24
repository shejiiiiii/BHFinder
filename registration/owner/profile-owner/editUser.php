<?php
    session_start();

    $userName = $_POST['userName'];
    $userPassword = $_POST['userPassword'];
    
    $userId= $_SESSION['userId'];
        
	$userConn = new mysqli('localhost','root','','bhfinder_registration');
	if ($userConn->connect_error) {
        die("Connection failed: " . $userConn->connect_error);
    }
    $userSql = "UPDATE userdetails SET userName=?, userPassword=? WHERE userId =  $userId";    
    $userStmt = $userConn->prepare($userSql);
    $userStmt->bind_param("ss", $userName, $userPassword);
    if ($userStmt->execute()) {
        echo "Owner information updated successfully.";
    } else {
        echo "Error1: " . $userConn->error;
    }

    $userStmt->close();
    $userConn->close();

    $url = 'profile-owner.php';
	header('Location: ' . $url);

