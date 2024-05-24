<?php
    session_start();
    $tempuserId= $_SESSION['userId'];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT ownerName, ownerBday, ownerGender, ownerAge, ownerAddress, ownerCPNum
        , ownerCStatus, ownerImg FROM ownerdetails WHERE userId = ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId = $tempuserId; 
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($ownerName, $ownerBday, $ownerGender, $ownerAge, $ownerAddress
        , $ownerCPNum, $ownerCStatus, $ownerImg);
        $temp1stmt->fetch();
        $temp1stmt->close();

        $temp2sql = "SELECT userName, userEmail, userPassword FROM userdetails WHERE userId = ?";

        $temp2stmt = $temp1conn->prepare($temp2sql);
        $userId = $tempuserId; 
        $temp2stmt->bind_param("i", $userId); 
        $temp2stmt->execute();

        $temp2stmt->bind_result($userName, $userEmail, $userPassword);
        $temp2stmt->fetch();
        $temp2stmt->close();
        

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== REMIXICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="profile-owner.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>

    <body>

        <header class="header">
            <a href="index.html" class="logo">Boarding House Finder</a>
            <a href="accreditation/accredit.html" class="accre">Accreditation</a>
            <nav class="navbar">
                <a href="#"><i class="ri-eye-line"></i>  View As</a>
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
                        <p class="profile-email"><?php echo $userEmail?></p>
                    </div>
                </div>

                <div class="menu">
                    <a href="profile-owner.php" class="menu-link"><i class="ri-account-circle-fill menu-icon"></i>Account</a>
                    <a href="deleteConfirmation.php" class="menu-link"><i class="ri-logout-box-r-fill menu-icon"></i>Delete Account</a>
                </div>
            </div>

            <form class="account" form action="editUser.php" method="post" enctype="multipart/form-data">
                <div class="account-header">
                    <h1 class="account-title">Account Setting</h1>
                    <div class="btn-container">
                         <a href="profile-owner.php" class="btn-cancel">Cancel</a>
                        <button class="btn-save">Save</button>
                    </div>

                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Username</label>
                        <input 
                            type="text"
                            placeholder="<?php echo $userName?>" 
                            value="<?php echo $userName?>" 
                            class="form-control"
                            id="userName" 
                            name="userName" 
                            >
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Password</label>
                        <input 
                            type="text" 
                            placeholder="<?php
                        for( $i = 0; $i < strlen($userPassword); $i++ ) {
                            echo "*";
                        }
                        ?>"
                            value=""
                            class="form-control"
                            id="userPassword" 
                            name="userPassword" 
                            >
                    </div>
                </div>
                
            </form>
        </div>
    </body>
</html>