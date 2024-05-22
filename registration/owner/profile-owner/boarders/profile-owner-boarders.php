<?php
    session_start();
    $tempuserId= $_SESSION['userId'];
   

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT ownerId FROM ownerdetails WHERE userId = ?";
        $temp1stmt = $temp1conn->prepare($temp1sql);
        $userId= $tempuserId;
        $temp1stmt->bind_param("i", $userId);
        $temp1stmt->execute();
        $temp1stmt->store_result();
        $temp1stmt->bind_result($ownerId);
        $temp1stmt->fetch();
        $temp1stmt->close();
       
        $temp3conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
        if ($temp3conn->connect_error) {
            die("Connection Failed: " . $temp3conn->connect_error);
        }
            $temp1sql = "SELECT bhId FROM bhdetails WHERE ownerId= ?";
    
            $temp1stmt = $temp3conn->prepare($temp1sql);
            $temp1stmt->bind_param("i", $ownerId); 
            $temp1stmt->execute();
    
            $temp1stmt->bind_result($bhId);
            $temp1stmt->fetch();
            $temp1stmt->close();
            $temp3conn->close();

        $temp2sql = "SELECT userName, userEmail FROM userdetails WHERE userId = ?";

        $temp2stmt = $temp1conn->prepare($temp2sql);
        $userId = $tempuserId; 
        $temp2stmt->bind_param("i", $userId); 
        $temp2stmt->execute();

        $temp2stmt->bind_result($userName, $userEmail);
        $temp2stmt->fetch();
        $temp2stmt->close();

        $getownersql = "SELECT boarderName FROM boarderdetails WHERE bhId = ?";

        $getownerstmt = $temp1conn->prepare($getownersql);
        $getownerstmt->bind_param("i", $bhId); 
        $getownerstmt->execute();

        $result = $getownerstmt->get_result();
        $info = $result->fetch_all(MYSQLI_ASSOC);
        $boarderName = array();
        foreach ($info as $row) {
            $boarderName[] = $row['boarderName'];
        }
        $getownerstmt->close();
        

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== REMIXICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="profile-owner-boarders.css">

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
                    </div>
                </div>

                <div class="menu">
                    <a href="../profile-owner.php" class="menu-link"><i class="ri-account-circle-fill menu-icon"></i>Account</a>
                    <a href="../bh/profile-owner-bh.php" class="menu-link"><i class="ri-hotel-bed-fill menu-icon"></i></i>Boarding House</a>
                    <a href="profile-owner-boarders.php" class="menu-link"><i class="ri-team-fill menu-icon"></i>Boarders</a>
                    <a href="../logout.php" class="menu-link"><i class="ri-logout-box-r-fill menu-icon"></i>Logout</a>
                </div>
            </div>

            <form class="account">
                <div class="account-header">
                    <h1 class="account-title">Boarders Setting</h1>
                </div>

                <main>
                <section class="task-list">
                    <div id="tasks">
                
                    <?php
                    foreach ($boarderName as $name) {
                        ?>
                        <div class="task">
                            <div class="content">
                                <input 
                                type="text"
                                class="text"
                                value="<?php echo htmlspecialchars($name); ?>" 
                                readonly
                                />
                            </div>
                            <div class="actions">
                                <a href="deleteBoarderList.php?name=<?php echo $name; ?>" class="remove">Remove</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                        
                        
                    </div>

                </section>
            </main>
            </form>
        </div>
    </body>
</html>