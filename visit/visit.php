<?php
    session_start();

    $hint = [];

    $temp1conn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if($temp1conn->connect_error) {
        die(''. $temp1conn ->connect_error);
    } else {
        $temp1sql = 'SELECT bhId, bhName, bhAddress FROM bhdetails';
        $temp1stmt = $temp1conn->query($temp1sql);
        $temp1info = mysqli_fetch_all($temp1stmt, MYSQLI_ASSOC);

        $temp2sql = 'SELECT bhPic FROM bhdetails';
        $temp2stmt = $temp1conn->query($temp2sql);
        $temp2info = mysqli_fetch_all($temp2stmt, MYSQLI_ASSOC);
    }

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== REMIXICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="visit.css">

        <title>Boarding House Finder</title>
        <link rel="icon" type="image/png" href="Logo.png">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>
    <body>
        <!--=============== HEADER ===============-->
        <header class="header">
            <div class="header1">
            <nav class="nav container">
                <div class="nav__data">
                    <a href="#" class="nav__logo">
                        <img class="logo" src="Logo.png"></i><span>BOARDING HOUSE FINDER</span></i></a>
    
                    <div class="nav__toggle" id="nav-toggle">
                        <i class="ri-menu-line nav__toggle-menu"></i>
                        <i class="ri-close-line nav__toggle-close"></i>
                    </div>
                </div>

                <!--=============== NAV MENU ===============-->
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li>
                            <a href="../index.html" class="nav__link">Home</a>
                        </li>
                        <li>
                            <a href="#" class="nav__link">Favorites</a>
                        </li>

                        <!--=============== DROPDOWN 1 ===============-->
                        <li class="dropdown__item">                      
                            <div class="nav__link dropdown__button">
                                Filter <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                            </div>

                            <div class="dropdown__container">
                                <div class="dropdown__content">
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-price-tag-3-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">Price Range</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="#" class="dropdown__link">₱1000 - ₱3000</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">₱3000 - ₱5000</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">₱6000 - ₱8000</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-pin-distance-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">Proximity to Campus</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="#" class="dropdown__link">100 meters</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">200 meters</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">300 meters</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-home-wifi-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">Amenities</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="#" class="dropdown__link">WiFi</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Laundry Facilities</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Private Bathrooms</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Security</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav__link">
                                <i class="ri-account-circle-line"></i>
                            </a>
                            <a href="username.php"></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="header2">
            <div class="box">
                <input type="text" id="input-box" placeholder="Search..." autocomplete="off" onkeyup="searchBH(this.value)">
                <a href="#">
                    <i class="ri-search-line"></i>
                </a>
            </div>
        </div>
        <div class="result-box">
        </div>
        </header>

        <div class="accredited">
            <div class="title">
                <h2>Accredited Boarding Houses</h2>
            </div>

            <div class="bh-content">
                <?php
                foreach($temp1info as $row) {
                    array_push($hint, $row['bhName']);
                ?>
                    <a href="bh/bh.php?id=<?php echo htmlspecialchars($row['bhId']) ?>">
                    <div class="col-content">
                            <img src="displayBHPic.php?id=<?php echo htmlspecialchars($row['bhId']) ?>" alt="Image from Database">
                            <i class="ri-shield-check-fill"></i>
                        <h5><?php echo htmlspecialchars($row['bhName']) ?></h5>
                        <i class="ri-map-pin-fill"></i>
                        <p><?php echo htmlspecialchars($row['bhAddress']) ?></p>
                    </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>

        <script>
            let availableKeywords = <?php echo json_encode($hint) ?>;
            const resultsBox = document.querySelector(".result-box");
            const inputBox = document.getElementById("input-box");
            function searchBH(str){
                let result = [];
                if(str.length){
                    result = availableKeywords.filter((keyword)=>{
                        return keyword.toLowerCase().includes(str.toLowerCase());
                    });
                    console.log(result);
                }
                display(result);

                if(!result.length){
                    resultsBox.innerHTML = '';
                }
            }
            function display(result){
                const content = result.map((list)=>{
                    return "<li onclick=selectInput(this)>" + list + "</li>";
                });

                resultsBox.innerHTML = "<ul>" + content.join('') + "</ul>";
            }

            function selectInput(list){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "bh/bh.php?id=")
            }
        </script>

        <!--=============== MAIN JS ===============-->
        <script src="visit.js"></script>
        <script src="autocomplete.js"></script>
    </body>
</html>
</html>