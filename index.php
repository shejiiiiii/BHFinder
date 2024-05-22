<?php
    session_start();

    $_SESSION["userId"] = "";

    $conn = new mysqli('localhost','root','','bhfinder_registration');
    $sql = "SELECT userId FROM userdetails";
    $result = $conn->query($sql);  
    $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($info as $row) {
        $_SESSION["userId"] = $row["userId"];
    }

    if (!isset($_SESSION["userId"])){
        echo "YOU ARE NOT LOGGED IN";
    } else{
        header("Location: testmoe.php");
    }
?>