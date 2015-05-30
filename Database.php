<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="tw";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//$sql = "INSERT INTO users (Username, Password, Type,Email) VALUES('a','ab','ab','ab') ";
						//VALUES ($User->getName(), $User->getPassword(), $User->getType(),$User->getEmail())";

//if ($conn->query($sql) === TRUE) {
  //  echo "New record created successfully";
//} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
//}

/*$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);
while($asd=mysqli_fetch_assoc($result))
{
	echo $asd['Username'];
	//echo implode(" ",$asd);
	
}*/
//$conn->close();*/
?>