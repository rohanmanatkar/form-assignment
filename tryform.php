<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php
// define variables and set to empty values
$nameErr = $emailErr = $PhoneErr = "";
$name = $email = $Phone ="";
$err = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
     $nameErr = "Name is required";
     $err = 1;
   } else {
     $name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Only letters and white space allowed";
       $err = 1;
     }
     if (strlen($name) >= 40) {
       $nameErr = "Characters should be less than 40";
       $err = 1;
     }
   }
  
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
     $err = 1;    
     } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Invalid email format";
       $err = 1;
     }
     else {
       if(strpos($email,"coep.ac.in") || strpos($email,"yahoo.com") || strpos($email,"gmail.com") || strpos($email,"riseup.net")) {
       }
       else {
         $emailErr = "Wrong Domain";
         $err = 1;
       }
     }
   }
    
   if (empty($_POST["Phone"])) {
     $PhoneErr = "Phone required";
     $err = 1;
   } else {
     $Phone = test_input($_POST["Phone"]);
     // check if Phone Number is valid
     if (!preg_match("/^[0-9]*$/",$Phone)) {
       $PhoneErr = "Invalid Number";
       $err = 1;
     }
     if (strlen($Phone) != 10 && strlen($Phone) != 8) {
       $PhoneErr = "Wrong number of digits";
       $err = 1;
     }
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<form method="post" action="display.php">
   Name: <input type="text" name="name" value="<?php echo $name;?>">
   <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
   E-mail: <input type="text" name="email" value="<?php echo $email;?>">
   <span class="error">* <?php echo $emailErr;?></span>
   <br><br>
   Phone: <input type="text" name="Phone" value="<?php echo $Phone;?>">
   <span class="error"><?php echo $PhoneErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"/>
	echo "hello world";
	echo "<br>";
</form>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && $err == 0) {
$tmp = "$name $email $Phone";
$tfile = fopen("tfile.txt", "w");
fwrite($tfile,$tmp);
fclose($file);

$servername = "localhost";
$username = "root";
$password = "root";


// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$myForm = "CREATE DATABASE myForm";
$myDB = "USE myForm";

mysqli_query($conn, $myDB);

// sql to create table
$Details = "CREATE TABLE Details (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(40) NOT NULL,
email VARCHAR(50),
Phone VARCHAR(10)
)";

$ins = "INSERT INTO Details (name, email, Phone)
VALUES ('$name', '$email', '$Phone')";
echo "<br>";
if (mysqli_query($conn, $ins)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $ins . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
}
?>
</body>
</html>
