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



	if (((isset($_FILES['bhPermit']) && $_FILES['bhPermit']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhFire']) && $_FILES['bhFire']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhSanitary']) && $_FILES['bhSanitary']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhPolice']) && $_FILES['bhPolice']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhMembership']) && $_FILES['bhMembership']['error'] === UPLOAD_ERR_OK))
    && ((isset($_FILES['bhBusiness']) && $_FILES['bhBusiness']['error'] === UPLOAD_ERR_OK)))
    {

        $tmp_permit = $_FILES['bhPermit']['tmp_name'];
        $bhPermit = file_get_contents($tmp_permit);

        $tmp_fire = $_FILES['bhFire']['tmp_name'];
        $bhFire = file_get_contents($tmp_fire);

        $tmp_sanitary = $_FILES['bhSanitary']['tmp_name'];
        $bhSanitary = file_get_contents($tmp_sanitary);

        $tmp_police = $_FILES['bhPolice']['tmp_name'];
        $bhPolice = file_get_contents($tmp_police);

        $tmp_membership= $_FILES['bhMembership']['tmp_name'];
        $bhMembership = file_get_contents($tmp_membership);

        $tmp_business = $_FILES['bhBusiness']['tmp_name'];
        $bhBusiness = file_get_contents($tmp_business);

    }

	$conn = new mysqli('localhost','root','','bhfinder_boardinghouse');
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO bhdocuments (bhId, bhPermit, bhFire, bhSanitary, bhPolice, bhMembership, bhBusiness) VALUES (?, ?, ?, ?, ?, ?, ?)";       
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $bhId, $bhPermit, $bhFire, $bhSanitary, $bhPolice, $bhMembership, $bhBusiness);
    if ($stmt->execute()) {
        echo "Application successfully for your Accreditation...";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
?>