<?php
    session_start();
    $tempuserId= $_SESSION['userId'];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }

    $temp2sql = "SELECT userName, userEmail FROM userdetails WHERE userId = ?";

    $temp2stmt = $temp1conn->prepare($temp2sql);
    $userId = $tempuserId; 
    $temp2stmt->bind_param("i", $userId); 
    $temp2stmt->execute();

    $temp2stmt->bind_result($userName, $userEmail);
    $temp2stmt->fetch();
    $temp2stmt->close();
        

?>




<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <link rel="stylesheet" href="profile-owner.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>

    <body>

        <header class="header">
            <a href="index.html" class="logo">Boarding House Finder</a>

            <nav class="navbar">
                <a href="visit.html">Home</a>
            </nav>
        </header>
        
        <div class="container">
            <div class="profile">
                <div class="profile-header">

                    <img src="displayProfilePic.php" alt="Image from Database" class="profile-img">

                    <div class="profile-text-container">
                        <h1 class="profile-title"><?php echo $userName?></h1>
                        <br></br>
                        <p class="profile-status">User ID: <?php echo $userId?></p>
                        <br></br>
                        <p class="profile-status">Residing: <input class="input" type="text" placeholder="Estiller Bh" /></p>
                        
                        <p class="profile-email"><?php echo $userEmail?></p>
                    </div>
                </div>

                <div class="menu">
                    <a href="#" class="menu-link"><i class="ri-account-circle-fill menu-icon"></i>Account</a>
                </div>
             </div>
            
            <form class="account" form action="editOwner.php" method="post" enctype="multipart/form-data">
                <div class="account-header">
                    <h1 class="account-title">DELETE CONFIRMATION</h1>
                    <div class="btn-container">
                        <a href="profile-owner Edit.php" class="btn-cancel">NO</a>
                        <a href="delete.php" class="btn-save">YES</a>
                    </div>

                </div>

               
                
            </form>
        </div>
    </body>
</html>