<?php
    session_start();

    // echo $_SESSION["userId"];

    if (isset($_SESSION["userId"])){
        
        $conn = new mysqli('localhost','root','','bhfinder_registration');
        $sql = "SELECT userId, userEmail, userPassword FROM userdetails";
        $result = $conn->query($sql);
        $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($info as $row){
            $userId_temp = $row['userId'];
            if($userId_temp === $_SESSION["userId"]){
                echo "Your email is " . $row['userEmail'] . " and password is " . $row['userPassword'];
                $result->close();
		        $conn->close();
                exit;
            }
        }
    }
?>