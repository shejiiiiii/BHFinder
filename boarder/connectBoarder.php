<?php
     session_start();
	if ((isset($_POST['boarderName'], $_POST['boarderBday'], $_POST['boarderGender']
        , $_POST['boarderAge'], $_POST['boarderAddress'], $_POST['boarderCPNum']
        , $_POST['boarderCS'])) && (isset($_FILES['boarderImg']) && $_FILES['boarderImg']['error'] === UPLOAD_ERR_OK))
        {
            $boarderName = $_POST['boarderName'];
            $boarderBday = $_POST['boarderBday'];
            $boarderGender = $_POST['boarderGender'];
            $boarderAge = $_POST['boarderAge'];
            $boarderAddress = $_POST['boarderAddress'];
            $boarderCPNum = $_POST['boarderCPNum'];
            $boarderCStatus = $_POST['boarderCS'];
            $tmp_boarder = $_FILES['boarderImg']['tmp_name'];
            $boarderImg = file_get_contents($tmp_boarder);
            $userId= $_SESSION['userId'];
        }

	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO boarderdetails (boarderName, boarderBday, boarderGender, boarderAge, boarderAddress
    , boarderCPNum, boarderCStatus, boarderImg, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";       
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisissi", $boarderName, $boarderBday, $boarderGender, $boarderAge, $boarderAddress
    , $boarderCPNum, $boarderCStatus, $boarderImg, $userId);
    if ($stmt->execute()) {
        echo "Registration successfully for Boarder Registration...";
    } else {
        echo "Error: " . $conn->error;
    }
    $usersql = "UPDATE userdetails SET userType ='boarder' WHERE userId =  $userId ";      
    if ($conn->query($usersql)=== TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }


    $stmt->close();
    $conn->close();

    $url = 'profile-user/profile-user View.php';
	header('Location: ' . $url);

