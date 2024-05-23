<?php
    session_start();
    $tempuserId= $_SESSION['userId'];
    $bhId= $_GET['id'];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if ($temp1conn->connect_error) {
        die("Connection Failed: " . $temp1conn->connect_error);
    }
        $temp1sql = "SELECT bhName, bhAddress,bhStatus, bhCPNum, bhPrice, bhOccupants, bhPic, ownerId 
         FROM bhdetails WHERE bhId= ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $bhId); 
        $temp1stmt->execute();

        $temp1stmt->bind_result($bhName,$bhAddress, $bhStatus, $bhCPNum, $bhPrice, $bhOccupants
        , $bhPic, $ownerId );
        $temp1stmt->fetch();
        $temp1stmt->close();

        $temp1sql = "SELECT bhAmmenity FROM bhammenities WHERE bhId= ?";

        $temp1stmt = $temp1conn->prepare($temp1sql);
        $temp1stmt->bind_param("i", $bhId); 
        $temp1stmt->execute();

        $result = $temp1stmt->get_result();
        $info = $result->fetch_all(MYSQLI_ASSOC);
        $bhAmmenity = array();
        foreach ($info as $row) {
            $bhAmmenity[] = $row['bhAmmenity'];
        }
        $temp1stmt->close();
        $temp1conn->close();

        $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_registration');
        if ($temp1conn->connect_error) {
            die("Connection Failed: " . $temp1conn->connect_error);
        }
            $temp1sql = "SELECT ownerName, ownerBday, ownerGender, ownerAge, ownerAddress, ownerCPNum
            , ownerCStatus, ownerImg FROM ownerdetails WHERE ownerId = ?";
    
            $temp1stmt = $temp1conn->prepare($temp1sql);
            $userId = $tempuserId; 
            $temp1stmt->bind_param("i", $ownerId); 
            $temp1stmt->execute();
    
            $temp1stmt->bind_result($ownerName, $ownerBday, $ownerGender, $ownerAge, $ownerAddress
            , $ownerCPNum, $ownerCStatus, $ownerImg);
            $temp1stmt->fetch();
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
        <link rel="stylesheet" href="bh.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>

    <body>
        <a href="../<?php echo htmlspecialchars($_SESSION['back']) ?>" class="ri-arrow-left-circle-fill"></a>
        <header class="header">
            <a href="index.html" class="logo">Boarding House Finder</a>

            <nav class="navbar">
                <a href="#owner" class="active">Owner</a>
                <a href="#bh">Boarding House</a>
                <a href="#docu">Documents</a>
                <a href="https://www.google.com/maps/place/Estiller+Boarding+House/@13.296351,123.48733,3a,75y,115.03h,121t/data=!3m7!1e1!3m5!1s5dnlVNvX0TWvJXmjbwuTGA!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fpanoid%3D5dnlVNvX0TWvJXmjbwuTGA%26cb_client%3Dsearch.gws-prod.gps%26w%3D360%26h%3D120%26yaw%3D128.54358%26pitch%3D0%26thumbfov%3D100!7i16384!8i8192!4m20!1m13!4m12!1m6!1m2!1s0x33a1a1826fdac0b1:0x8843d771db97a214!2sEstiller+Boarding+House!2m2!1d123.4873611!2d13.2963229!1m3!2m2!1d123.486641!2d13.2954079!3e0!3m5!1s0x33a1a1826fdac0b1:0x8843d771db97a214!8m2!3d13.2963106!4d123.4873799!16s%2Fg%2F11sd65b17m?entry=ttu">Google Map</a>
            </nav>
        </header>

        <section class="owner" id="owner">
            <div class="owner-content">
                <h3>Owner of <?php echo $bhName?></h3>
                <h1><?php echo $ownerName?></h1>
                <h3><?php echo $bhAddress?></h3>
                <p>Meet <?php echo $ownerName?>, the dedicated owner of <?php echo $bhName?>, a haven for travelers and students alike. With a passion for hospitality and a keen eye for comfort, <?php echo $ownerName?> ensures that every guest feels at home in his cozy and welcoming establishment. Whether you're seeking a temporary refuge or a long-term stay, <?php echo $bhName?> promises a warm atmosphere, impeccable service, and a memorable experience for all who walk through its doors.</p>
                <div class="social-media">
                    <a href="#"><i class="ri-facebook-circle-fill"></i></a>
                </div>
                <a href="#bh" class="btn">Visit Boarding House</a>
            </div>

            <div class="owner-img">
                <img src="displayProfilePicVisit.php?ownerId=<?php echo $ownerId; ?>" alt="Image from Database" class="owner-img">
                
            </div>
        </section>

        <section class="bh" id="bh">
            <div class="bh-img">
                <img src="displayBHPicVisit.php?ownerId=<?php echo $ownerId; ?>" alt="Image from Database" class="profile-img">
            </div>

            <div class="bh-content">
                <h2 class="heading"><?php echo $ownerName?> <span>Boarding House</span></h2>
                <h3>₱<?php echo $bhPrice?></h3>
                <h4>Address:</h4>
                <p><?php echo $bhAddress?></p>
                <h4>Amenities:</h4>
                <p><?php  foreach ($bhAmmenity as $temp) {
                                echo $temp." "; 
                            }?></p>
                <h4>Description:</h4>
                <p><?php echo $bhName?> offers cozy accommodations in a quaint, homely environment. Located in the heart of the city, it provides convenient access to nearby amenities and attractions. With comfortable rooms and attentive staff, guests can expect a pleasant stay at affordable rates. If you're a student looking for a place to call home, <?php echo $bhName?> welcomes you with open arms.</p>

                <a href="applyBoarder.php?bhId=<?php echo $bhId; ?>" class="btn">Apply Now</a>
            </div>
        </section>

        <section class="docu" id="docu">
            <h2 class="heading">Legal Documents</h2>

            <div class="docu-container">

                <?php 
                $h4 = array("Business Permit", "Fire Safety Inspection Certificate" , "Sanitary Permit",
                            "Police Clearance", "Certificate of Membership and Registration", "Certificate of Business Name Registration");
                $p = array("Office of the Mayor", "Bureau of Fire Protection", "City Health Office",
                            "Polangui Municipal Police Station", "PADPAO, Inc.", "DTI Philippines");
                for($i = 0; $i < 6; $i++){
                ?>    

                    <div class="docu-box">
                        <img src="displayDocumentPicVisit.php?bhId=<?php echo htmlspecialchars($bhId) ?>&i=<?php echo htmlspecialchars($i) ?>" 
                        alt="">
                        <div class="docu-layer">
                            <h4><?php echo htmlspecialchars($h4[$i]) ?></h4>
                            <p><?php echo htmlspecialchars($p[$i]) ?></p>
                            <a href="#"><i class="ri-external-link-fill"></i></a>
                        </div>
                    </div>

                <?php 
                }
                ?>

            </div>

        </section>

        <footer class="footer">
            <div class="footer-text">
                <p>Copyright &copy; 2024 by Owner | All Rights Reserved.</p>
            </div>

            <div class="footer-iconTop">
                <a href="#owner"><i class="ri-arrow-up-circle-fill"></i></a>
            </div>
        </footer>

        <script src="bh.js"></script>
    </body>