<?php
session_start();
include("include/connection.php");
//code check email
if(!empty($_POST["emailid"])) {
	$valueem = $_POST['emailid'];
	$query = "SELECT count(*) as cnt FROM user WHERE email='$valueem'";
$result = mysqli_query($con,$query);
$res_array = mysqli_fetch_assoc($result);
$email_count = $res_array['cnt'];
// echo $email_count;
// echo $query;
//die;
if($email_count>0) {
	$_SESSION['dup']=1;
	echo "<span style='color:red'> Email Already Exists .</span>";

}
else
 {
 	$_SESSION['dup']=0;
	echo "<span style='color:green'> Email Available.</span>";
}
}
?>
