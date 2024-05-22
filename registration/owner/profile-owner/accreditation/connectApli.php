<?php
    session_start();
    $userId= $_SESSION['userId'];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT ownerId FROM ownerdetails WHERE userId = ?";
        $temp1stmt = $temp1conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $userId);
        $temp1stmt->execute();
        $temp1stmt->store_result();
        $temp1stmt->bind_result($ownerId);
        $temp1stmt->fetch();
        $temp1stmt->close();

    $temp2conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if ($temp2conn->connect_error) {
        die("Connection Failed: " . $temp2conn->connect_error);
    }
        $temp2sql = "SELECT bhId FROM bhdetails WHERE ownerId = ?";
        $temp2stmt = $temp2conn->prepare($temp2sql);
        $temp2stmt->bind_param("i", $ownerId);
        $temp2stmt->execute();
        $temp2stmt->store_result();
        $temp2stmt->bind_result($bhId);
        $temp2stmt->fetch();
        $temp2stmt->close();



	if (((isset($_FILES['bhFire']) && $_FILES['bhFire']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhMayor']) && $_FILES['bhMayor']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhHealth']) && $_FILES['bhHealth']['error'] === UPLOAD_ERR_OK)))
    {

        $tmp_fire = $_FILES['bhFire']['tmp_name'];
        $bhFire = file_get_contents($tmp_fire);

        $tmp_mayor = $_FILES['bhMayor']['tmp_name'];
        $bhMayor = file_get_contents($tmp_mayor);

        $tmp_health = $_FILES['bhHealth']['tmp_name'];
        $bhHealth = file_get_contents($tmp_health);

    }

	$conn = new mysqli('localhost','root','','bhfinder_boardinghouse');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO bhdocuments (bhId,bhFire, bhMayor, bhHealth,userId) VALUES (?, ?, ?, ?, ?)";       
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $bhId, $bhFire, $bhMayor, $bhHealth, $userId);
    if ($stmt->execute()) {
        echo "Application successfully for your Accreditation...";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
?>