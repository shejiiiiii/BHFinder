<?php
    session_start();
    $tempuserId= $_SESSION['userId'];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT boarderName, boarderBday, boarderGender, boarderAge, boarderAddress
        , boarderCPNum, boarderCStatus, boarderImg, bhId FROM boarderdetails WHERE userId = ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId = $tempuserId; 
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($boarderName, $boarderBday, $boarderGender, $boarderAge, $boarderAddress
        , $boarderCPNum, $boarderCStatus, $boarderImg, $bhId);
        $temp1stmt->fetch();
        $temp1stmt->close();

        $temp2sql = "SELECT userName, userEmail FROM userdetails WHERE userId = ?";

        $temp2stmt = $temp1conn->prepare($temp2sql);
        $userId = $tempuserId; 
        $temp2stmt->bind_param("i", $userId); 
        $temp2stmt->execute();

        $temp2stmt->bind_result($userName, $userEmail);
        $temp2stmt->fetch();
        $temp2stmt->close();

        $temp1conn->close();
        
        $temp2conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if ($temp2conn->connect_error) {
        die("Connection Failed: " . $temp2conn->connect_error);
    }
        $temp1sql = "SELECT bhName FROM bhdetails WHERE bhId= ?";

        $temp1stmt = $temp2conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $bhId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($bhName);
        $temp1stmt->fetch();
        $temp1stmt->close();

        $temp2conn->close();

?>





<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <link rel="stylesheet" href="profile-user.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>

    <body>

        <header class="header">
            <a href="index.html" class="logo">Boarding House Finder</a>

            <nav class="navbar">
                <a href="../../../visit/visit.php">Home</a>
            </nav>
        </header>
        
        <div class="container">
            <div class="profile">
                <div class="profile-header">

                    <img src="displayProfilePic.php" alt="Image from Database" class="profile-img">

                    <div class="profile-text-container">
                        <h1 class="profile-title"><?php echo $userName?></h1>
                        <p class="profile-status">User ID: <?php echo $userId?></p>
                        <p class="profile-status">Residing: </p>
                        <input class="input" type="text" placeholder="<?php echo $bhName?>" />
                        <p class="profile-email"><?php echo $userEmail?></p>
                    </div>
                </div>

                <div class="menu">
                    <a href="#" class="menu-link"><i class="ri-account-circle-fill menu-icon"></i>Account</a>
                    <a href="logout.php" class="menu-link"><i class="ri-logout-box-r-fill menu-icon"></i>Logout</a>
                </div>
            </div>

            <form class="account">
                <div class="account-header">
                    <h1 class="account-title">Account Setting</h1>
                    <div class="btn-container">
                        <a href="profile-user Edit.php" class="btn-save">Edit</a>
                    </div>

                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Full Name</label>
                        <label><?php echo $boarderName?></label>
                    </div>

                    <div class="input-container">
                        <label>Birthday</label>
                        <label><?php echo $boarderBday?></label>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Gender</label>
                        <label><?php echo $boarderGender?></label>
                    </div>

                    <div class="input-container">
                        <label>Age</label>
                        <label><?php echo $boarderAge?></label>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Address</label>
                        <label><?php echo $boarderAddress?></label>
                    </div>

                    <div class="input-container">
                        <label>Phone Number</label>
                        <label><?php echo $boarderCPNum?></label>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Civil Status</label>
                        <label><?php echo $boarderCStatus?></label>
                    </div>

                   
                </div>

                
            </form>
        </div>
    </body>
</html>