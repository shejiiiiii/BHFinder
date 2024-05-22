<?php
session_start();
// Establish database connection
$_SESSION['i'];
$_SESSION['bhId'];
$bhConn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
if ($bhConn->connect_error) {
    die("Connection Failed: " . $bhConn->connect_error);
}

$sqlDetails = "SELECT bhName,bhId FROM bhdetails WHERE bhStatus = 'registered'";
$stmtDetails = $bhConn->prepare($sqlDetails);
$stmtDetails->execute();
$stmtDetails->store_result();
$stmtDetails->bind_result($bhName, $bhId);


echo        '<div id="myModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <img src="" id="modalImage" class="modal-content">
            </div>';

echo '<script src="modal.js"></script>';

if ($stmtDetails->num_rows > 0) {   
    while ($stmtDetails->fetch()) {
        echo "$bhName<br>";
        $_SESSION['bhId'] = $bhId;
        for ($_SESSION['i'] = 1; $_SESSION['i'] <=3; $_SESSION['i']++) {
            // echo $_SESSION['i'];
            // echo '<img src="displayImageDocs.php">';
            echo '<img src="displayImageDocs.php?image=' . $_SESSION['i'] . '&bhId=' . $_SESSION['bhId'] . '" alt="Image ' . $_SESSION['i'] . '" class="thumbnail" onclick="openModal(\'displayImageDocs.php?image=' . $_SESSION['i'] . '\')" style="width: 300px; height: 200px;">';
        }
        // echo $_SESSION['i'];
        echo "<br><br>";
    }  
} else {
    echo "No names with active status found";
}


$stmtDetails->close();
$bhConn->close();
?>

