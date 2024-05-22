<?php
    session_start();
    $tempuserId= $_SESSION['userId'];

    $temp2conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp2conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp2sql = "SELECT userName, userEmail FROM userdetails WHERE userId = ?";

        $temp2stmt = $temp2conn->prepare($temp2sql);
        $userId = $tempuserId; 
        $temp2stmt->bind_param("i", $userId); 
        $temp2stmt->execute();

        $temp2stmt->bind_result($userName, $userEmail);
        $temp2stmt->fetch();
        $temp2stmt->close();

        $temp3sql = "SELECT ownerId FROM ownerdetails WHERE userId = ?";
        $temp3stmt = $temp2conn->prepare($temp3sql);
        $temp3stmt->bind_param("i", $userId);
        $temp3stmt->execute();
        $temp3stmt->store_result();
        $temp3stmt->bind_result($ownerId);
        $temp3stmt->fetch();
        $temp3stmt->close();

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT bhName, bhAddress,bhStatus, bhCPNum, bhPrice, bhOccupants, bhPic FROM bhdetails WHERE ownerId= ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $ownerId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($bhName,$bhAddress, $bhStatus, $bhCPNum, $bhPrice, $bhOccupants
        , $bhPic);
        $temp1stmt->fetch();
        $temp1stmt->close();

        $temp1sql = "SELECT bhAmmenity FROM bhammenities WHERE userId= ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $userId); 
        $temp1stmt->execute();

        $result = $temp1stmt->get_result();
        $info = $result->fetch_all(MYSQLI_ASSOC);
        $bhAmmenity = array();
        foreach ($info as $row) {
            $bhAmmenity[] = $row['bhAmmenity'];
        }
        $temp1stmt->close();
        

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== REMIXICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="profile-owner-bh.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>

    <body>

        <header class="header">
            <a href="index.html" class="logo">Boarding House Finder</a>

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
                        <img src="displayBHPic.php" alt="Image from Database" class="profile-img">  
                    </div>
                </div>

                <div class="menu">
                    <a href="profile-owner-bh.php" class="menu-link"><i class="ri-hotel-bed-fill menu-icon"></i></i>Boarding House</a>
                </div>
            </div>

            <form class="account" form action="editBh.php" method="post" enctype="multipart/form-data">
            <div class="account-header">
                    <h1 class="account-title">Account Setting</h1>
                    <div class="btn-container">
                        <a href="profile-owner-bh.php" class="btn-cancel">Cancel</a>
                        <button class="btn-save">Save</button>
                    </div>

                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Boarding House Name</label>
                        <input 
                            type="text"
                            placeholder="<?php echo $bhName?>" 
                            value="<?php echo $bhName?>" 
                            class="form-control"
                            id="bhName" 
                            name="bhName" 
                            >
                    </div>

                    <div class="input-container">
                        <label>Status</label>
                        <label><?php echo $bhStatus?></label>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Address</label>
                        <input 
                            type="text"
                            placeholder="<?php echo $bhAddress?>" 
                            value="<?php echo $bhAddress?>" 
                            class="form-control"
                            id="bhAddress" 
                            name="bhAddress" 
                            >
                    </div>

                    <div class="input-container">
                        <label>Phone Number</label>
                        <input 
                            type="number"
                            placeholder="<?php echo $bhCPNum?>" 
                            value="<?php echo $bhCPNum?>" 
                            class="form-control"
                            id="bhCPNum" 
                            name="bhCPNum" 
                            >
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Price</label>
                        <input 
                            type="number"
                            placeholder="<?php echo $bhPrice?>" 
                            value="<?php echo $bhPrice?>" 
                            class="form-control"
                            id="bhPrice" 
                            name="bhPrice" 
                            >
                    </div>

                    <div class="input-container">
                        <label>Occupants</label>
                        <div class="bh-occupants-details">
                            <input type="radio" name="bhOccupants" value="Solo" id="occupants-dot-1"<?php if ($bhOccupants === 'Solo') echo 'checked'; ?>>
                            <input type="radio" name="bhOccupants" value="Pair" id="occupants-dot-2"<?php if ($bhOccupants === 'Pair') echo 'checked'; ?>>
                            <input type="radio" name="bhOccupants" value="Group" id="occupants-dot-3"<?php if ($bhOccupants === 'Group') echo 'checked'; ?>>
                            <div class="category">
                                <label for="occupants-dot-1">
                                <span class="dot one"></span>
                                <span class="bh-occupants">Solo</span>
                                </label>
                                <label for="occupants-dot-2">
                                <span class="dot two"></span>
                                <span class="bh-occupants">Pair</span>
                                </label>
                                <label for="occupants-dot-3">
                                <span class="dot three"></span>
                                <span class="bh-occupants">Group</span>
                                </label>
                            </div>
                            </div>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Ammnenities</label>
                        <div class="bh-ammenities-details">
                        <input type="checkbox" name="bhAmmenities[]" value="WiFi" id="ammenities-dot-1"<?php if (!empty($bhAmmenity[0]) && $bhAmmenity[0] === 'WiFi') echo 'checked'; ?>>
                        <input type="checkbox" name="bhAmmenities[]" value="Laundry" id="ammenities-dot-2"<?php if (!empty($bhAmmenity[1]) && $bhAmmenity[1] === 'Laundry') echo 'checked'; ?>>
                        <input type="checkbox" name="bhAmmenities[]" value="Kitchen" id="ammenities-dot-3"<?php if (!empty($bhAmmenity[2]) && $bhAmmenity[2] === 'Kitchen') echo 'checked'; ?>>
                        <div class="category">
                            <label for="ammenities-dot-1">
                            <span class="dot one"></span>
                            <span class="bh-ammenities">WiFi</span>
                            </label>
                            <label for="ammenities-dot-2">
                            <span class="dot two"></span>
                            <span class="bh-ammenities">Laundry</span>
                            </label>
                            <label for="ammenities-dot-3">
                            <span class="dot three"></span>
                            <span class="bh-ammenities">Kitchen</span>
                            </label>
                        </div>
                        </div>
                    </div>

                    <div class="input-container">
                        <label for="file">Choose Image</label>
                        <input 
                            type="file" 
                            id="file" 
                            name="bhPic" 
                            class="inputfile" />
                    </div>

                    
                </div>

                

            </form>
        </div>
    </body>
</html>