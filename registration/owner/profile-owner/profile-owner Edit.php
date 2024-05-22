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

            <form class="account" form action="editOwner.php" method="post" enctype="multipart/form-data">
                <div class="account-header">
                    <h1 class="account-title">Account Setting</h1>
                    <div class="btn-container">
                         <a href="profile-owner.php" class="btn-cancel">Cancel</a>
                        <button class="btn-save">Save</button>
                    </div>

                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Full Name</label>
                        <input 
                            type="text"
                            placeholder="<?php echo $ownerName?>" 
                            value="<?php echo $ownerName?>" 
                            class="form-control"
                            id="ownerName" 
                            name="ownerName" 
                            >
                    </div>

                    <div class="input-container">
                        <label>Birthday</label>
                        <input 
                            type="date"
                            placeholder="<?php echo $ownerBday?>"
                            value="<?php echo $ownerBday?>"
                            class="form-control" 
                            id="ownerBday" 
                            name="ownerBday" 
                            >
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Gender</label>
                        <div class="gender-details">
                        <input type="radio" name="ownerGender" value="m" id="dot-1" <?php if ($ownerGender === 'm') echo 'checked'; ?>>
                        <input type="radio" name="ownerGender" value="f" id="dot-2" <?php if ($ownerGender === 'f') echo 'checked'; ?>>
                        <input type="radio" name="ownerGender" value="o" id="dot-3" <?php if ($ownerGender === 'o') echo 'checked'; ?>>
                            <div class="category">
                                <label for="dot-1">
                                <span class="dot one"></span>
                                <span class="gender">Male</span>
                            </label>
                            <label for="dot-2">
                                <span class="dot two"></span>
                                <span class="gender">Female</span>
                            </label>
                            <label for="dot-3">
                                <span class="dot three"></span>
                                <span class="gender">Prefer not to say</span>
                                </label>
                            </div>
                            </div>
                    </div>

                    <div class="input-container">
                        <label>Age</label>
                        <input 
                            type="number" 
                            placeholder="<?php echo $ownerAge?>"
                            value="<?php echo $ownerAge?>"
                            class="form-control"
                            id="ownerAge" 
                            name="ownerAge" 
                            >
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Address</label>
                        <input 
                            type="text" 
                            placeholder="<?php echo $ownerAddress?>"
                            value="<?php echo $ownerAddress?>"
                            class="form-control"
                            id="ownerAddress" 
                            name="ownerAddress" 
                            >
                    </div>

                    <div class="input-container">
                        <label>Phone Number</label>
                        <input 
                            type="number" 
                            placeholder="<?php echo $ownerCPNum?>"
                            value="<?php echo $ownerCPNum?>"
                            class="form-control"
                            id="ownerCPNum" 
                            name="ownerCPNum" 
                            >
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Civil Status</label>
                        <div class="civil-status-details">
                            <input type="radio" name="ownerCStatus" value="s" id="civil-dot-1" <?php if ($ownerCStatus === 's') echo 'checked'; ?>>
                            <input type="radio" name="ownerCStatus" value="m" id="civil-dot-2" <?php if ($ownerCStatus === 'm') echo 'checked'; ?>>
                            <input type="radio" name="ownerCStatus" value="w" id="civil-dot-3" <?php if ($ownerCStatus === 'w') echo 'checked'; ?>>
                            <input type="radio" name="ownerCStatus" value="ls" id="civil-dot-4" <?php if ($ownerCStatus === 'ls') echo 'checked'; ?>>
                                <div class="category">
                                    <label for="civil-dot-1">
                                    <span class="dot one"></span>
                                    <span class="civil-status">Single</span>
                                    </label>
                                    <label for="civil-dot-2">
                                    <span class="dot two"></span>
                                    <span class="civil-status">Married</span>
                                    </label>
                                    <label for="civil-dot-3">
                                    <span class="dot three"></span>
                                    <span class="civil-status">Widowed</span>
                                    </label>
                                    <label for="civil-dot-4">
                                        <span class="dot four"></span>
                                        <span class="civil-status">LegallySeparated</span>
                                        </label>
                                </div>
                            </div>
                    </div>

                    <div class="input-container">
                        <label for="file">Choose Image</label>
                        <input 
                            type="file" 
                            id="file" 
                            name="ownerImg" 
                            class="inputfile" />
                    </div>

                   
                </div>

                
            </form>
        </div>
    </body>
</html>