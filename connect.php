<?php
	session_start();
    $_SESSION['userId'] = '';

	$userName = $_POST['userName'];
	$userEmail = $_POST['userEmail'];
	$userPassword = $_POST['userPassword'];

	// Database connection
	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$sql = "INSERT INTO userdetails (userName, userEmail, userPassword) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $userName, $userEmail, $userPassword);
		
		$execval = $stmt->execute();
		echo $execval;

		$_SESSION['userId'] = $stmt->insert_id;

		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
		$url = 'registration/registration.html';
		header('Location: ' . $url);
	}
?>

