<?php
function genLoginID($pid){ //function to add p to the id, s can differentiate between the different types of people 
$id="a".($pid);
return $id; 
}
function password_strength_check($password, $min_len = 6, $max_len = 9, $req_digit = 1, $req_lower = 1, $req_upper = 1, $req_symbol = 1) { 
//function to check strength of password 
// Build regex string depending on requirements for the password 
// url ref - https://stackoverflow.com/questions/11873990/create-preg-match-for-password-validation-allowing 
$regex = '/^'; 
if ($req_digit == 1) { $regex .= '(?=.*\d)'; } // Match at least 1 digit 
if ($req_lower == 1) { $regex .= '(?=.*[a-z])'; } // Match at least 1 lowercase letter 
if ($req_upper == 1) { $regex .= '(?=.*[A-Z])'; } // Match at least 1 uppercase letter 
if ($req_symbol == 1) { $regex .= '(?=.*[^a-zA-Z\d])'; } // Match at least 1 character that is none of the above 
$regex .= '.{' . $min_len . ',' . $max_len . '}$/';
if(preg_match($regex, $password)) { 
return TRUE; 
} else { 
return FALSE; 
} 
} 
if ($_POST["pw"]==$_POST["confirmpw"]){ //only proceeds when passwords are the same 
if (password_strength_check($_POST["pw"]) == TRUE ){ //make sure the password has a good strength 
require "connection.php"; 
require "admin.php"; 
$conn = connection::getConn(); 
//instantite parent object $h = new admin($_POST["username"],$_POST["pw"]); 
$username = $h->getUsername(); $password = $h->getPassword(); 
$phash = password_hash($password,PASSWORD_DEFAULT); 
if (password_Verify($password, $phash)){ 
//insert the details into table 
$sql = "INSERT INTO `admin` (`username`, `password`) VALUES ('$username', '$phash')"; 
if ($conn->query($sql) === TRUE) { 
echo "WELCOME admin You have successfully created an account."."<br>"; 
//get their ID so they can use for future ref 
$sql = "SELECT MAX(adminID) as max FROM admin"; 
$result = $conn->query($sql); 
if ($result->num_rows > 0) { 
while($row=$result->fetch_assoc()){ 
$id = $row["max"]; 
}}
$loginUN=$username; 
$loginPW=$phash; $loginID = "a".$id; 
$sql = "INSERT INTO `user` (`id`, `username`, `password`, `sid`, `tid`,`pid`) VALUES ('$loginID', '$loginUN', '$loginPW', NULL, NULL, NULL)"; 
if ($conn->query($sql) === TRUE) { 
echo "Please click ".'<a href="login.html">here</a>'." to be redirected to the login page"; 
}else{
echo "Connection error. Please try again later"; 
echo "<br>"; 
echo "Please click ".'<a href="http://al2020-2.tanglincomputing.com/al2020-13/coursework/adminSignUp.html">here</a>'." to be redirected to the register page"; 
} 
} else { 
echo "Connection error. Please try again later"; 
echo "<br>"; 
echo "Please click ".'<a href="http://al2020-2.tanglincomputing.com/al2020-13/coursework/adminSignUp.html">here</a>'." to be redirected to the register page"; 
} 
} 
}else{ 
echo "Password too weak. Must have a digit, a lowercase letter, uppercase letter, special character and between 6 to 9 characters."; 
echo "<br>"; 
echo "Please click ".'<a href="http://al2020-2.tanglincomputing.com/al2020-13/coursework/adminSignUp.html">here</a>'." to be redirected to the register page"; 
} 
}else{
echo "different passwords entered"; 
echo "<br>"; 
echo "Please click ".'<a href="http://al2020-2.tanglincomputing.com/al2020-13/coursework/adminSignUp.html">here</a>'." to be redirected to the register page"; 
} 
$conn->close(); 
?>
