<?php

    $boarderName= $_GET['name'];
        

	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT boarderName FROM boarderdetails";
    $result = $conn->query($sql);
    $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach($info as $row){
        $boarderName_temp = $row['boarderName'];

        if($boarderName_temp==$boarderName){
            $bhId=0;

            $removesql = "UPDATE boarderdetails SET bhId=? WHERE boarderName= ?";       
            $removestmt = $conn->prepare($removesql);
            $removestmt->bind_param("is", $bhId, $boarderName);
            if ($removestmt->execute()) {
                echo "Boarder information updated successfully.";
            } else {    
                echo "Error: " . $conn->error;
            }

            $removestmt->close();

            $url = 'profile-owner-boarders.php';
            header('Location: ' . $url);



            $result->close();
            $conn->close();
            exit;
        }
        

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

    $url = 'profile-owner-boarders.php';
	header('Location: ' . $url);

