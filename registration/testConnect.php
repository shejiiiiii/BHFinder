<?php

if (isset($_FILES['bhPic']) && $_FILES['bhPic']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file name
    $tmp_name = $_FILES['bhPic']['tmp_name'];
    
    // Read the file contents
    $bhPic = file_get_contents($tmp_name);
    
    // Establish database connection
    $bhConn = new mysqli('localhost', 'root', '', 'bhfinder_boardinghouse');
    if ($bhConn->connect_error) {
        die("Connection Failed: " . $bhConn->connect_error);
    } else {
        // Prepare the SQL statement
        $bhSql = "INSERT INTO testbhpic (bhPic) VALUES (?)";
        $bhStmt = $bhConn->prepare($bhSql);
        
        // Bind parameters
        $bhStmt->bind_param("s", $bhPic);
        
        // Execute the statement
        if ($bhStmt->execute()) {
            echo "Image inserted successfully.";
            
        } else {
            echo "Error: " . $bhStmt->error;
        }
        
        // Close statement and connection
        $bhStmt->close();
        $bhConn->close();
    }
} else {
    echo "Error uploading file.";
}
    
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" conent="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>BH Finder - About Us</title>
    <link rel="stylesheet" href="registrationCSS.css">

</head>
<body>
    <h1>Display Image</h1>
    <a href="registration.html"class="cta-button">For boarders</a>
</body>
</html>