<?php
    session_start();
    $_SESSION['userId'] = '';
    if(isset($_POST['userEmail'], $_POST['userPassword'])){
        $userEmail = $_POST['userEmail'];
        $userPassword = $_POST['userPassword'];}

    // Database connection
	$conn = new mysqli('localhost','root','','bhfinder_registration');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
        $sql = "SELECT userId, userEmail, userPassword FROM userdetails";
        $result = $conn->query($sql);
        $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($info as $row){
            $userEmail_temp = $row['userEmail'];
            $userPassword_temp = $row['userPassword'];
            if($userEmail_temp==$userEmail && $userPassword_temp==$userPassword){
                $_SESSION['userId'] = $row['userId'];
                $tempNum= $_SESSION['userId'];

                $temp2sql = "SELECT userType FROM userdetails WHERE userId = ?";
                $temp2stmt = $conn->prepare($temp2sql);
                $temp2stmt->bind_param("i", $tempNum);
                $temp2stmt->execute();
                $temp2stmt->store_result();
                $temp2stmt->bind_result($userType);
                $temp2stmt->fetch();
                $temp2stmt->close();

                if($userType === 'owner'){
                    header('Location: registration/owner/profile-owner/profile-owner.php');
                }
                else if($userType === 'boarder'){
                    header('Location: registration/boarder/profile-user/profile-user View.php');
                }
                else echo 'error';

                $result->close();
		        $conn->close();
                exit;
            }
            
        }

	}
?>