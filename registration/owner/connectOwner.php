<?php
    session_start();
    $bhId;
    $userId= $_SESSION['userId'];

    
   

    $ownerName = $_POST['ownerName'];
    $ownerBday = $_POST['ownerBday'];
    $ownerGender = $_POST['ownerGender'];
    $ownerAge = $_POST['ownerAge'];
    $ownerAddress = $_POST['ownerAddress'];
    $ownerCPNum = $_POST['ownerCPNum'];
    $ownerCStatus = $_POST['ownerCStatus'];
    $tmp_owner = $_FILES['ownerImg']['tmp_name'];
    $ownerImg = file_get_contents($tmp_owner);

   
    $bhName = $_POST['bhName'];
    $bhAddress = $_POST['bhAddress'];
    $bhCPNum = $_POST['bhCPNum'];
    $bhPrice = $_POST['bhPrice'];
    $bhOccupants = $_POST['bhOccupants'];
    $bhAmmenities = $_POST['bhAmmenities'];
    $tmp_bh = $_FILES['bhPic']['tmp_name'];
    $bhPic = file_get_contents($tmp_bh);



    // if ((isset($_POST['bhName'], $_POST['bhAddress'], $_POST['bhCPNum'], $_POST['bhPrice']
    // , $_POST['bhOccupants'], $_POST['bhAmmenities'])) && (isset($_FILES['bhPic']) && $_FILES['bhPic']['error'] === UPLOAD_ERR_OK))
    // {
    //     
    // }
    // else {
    //     echo "Error2 uploading file.";
    // }

	$ownerConn = new mysqli('localhost','root','','bhfinder_registration');
    if($ownerConn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $ownerConn->connect_error);
	} else 
    {
        $ownerSql = "INSERT INTO ownerdetails (ownerName, ownerBday, ownerGender, ownerAge, ownerAddress, ownerCPNum
        , ownerCStatus, ownerImg, userId) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $ownerStmt = $ownerConn->prepare($ownerSql);
        $ownerStmt->bind_param("sssisissi", $ownerName, $ownerBday, $ownerGender, $ownerAge, $ownerAddress
        , $ownerCPNum, $ownerCStatus, $ownerImg, $userId);
        if ($ownerStmt->execute()) {
            echo "Registration successfully for Owner Registration...";
        } else {
            echo "Error1: " . $ownerConn->error;
        }

        $usersql = "UPDATE userdetails SET userType ='owner' WHERE userId = $userId ";      
        if ($ownerConn->query($usersql)=== TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $conn->error;
        }

    
        $ownerConn->close();
	}

    $bhConn = new mysqli('localhost','root','','bhfinder_boardinghouse');
    if($bhConn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $bhConn->connect_error);
	} else 
    {
        $ownerId = $ownerStmt->insert_id;
        $bhSql = "INSERT INTO bhdetails (bhName, bhAddress, bhCPNum, bhPrice, bhOccupants
        , bhPic, ownerId, userId)    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $bhStmt = $bhConn->prepare($bhSql);
        $bhStmt->bind_param("ssiissii", $bhName, $bhAddress, $bhCPNum, $bhPrice, $bhOccupants
        , $bhPic, $ownerId, $userId);
        if ($bhStmt->execute()) {
            echo "Processing...";
            $ownerStmt->close();
        } else {
            echo "Error1: " . $bhConn->error;
        }
        // $bhStmt->close();

        // FOR AMMENITIES
        $i = 1;
        $bhId = $bhStmt->insert_id;

        foreach($bhAmmenities as $bhAmmenity){
            $ammenityId = $bhAmmenity == "WiFi" ? 1 : ($bhAmmenity == "Laundry" ? 2 : 3);
            echo $ammenityId . " ";
            $bhSql = "INSERT INTO bhammenities (ammenityId, bhAmmenity, bhId, userId)
                        VALUES (?, ?, ?, ?)";
            $bhStmt = $bhConn->prepare($bhSql);
            $bhStmt->bind_param("isii", $ammenityId, $bhAmmenity, $bhId, $userId);

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
    
    $url = 'profile-owner/profile-owner.php';
	header('Location: ' . $url);

?>