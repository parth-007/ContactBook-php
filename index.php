<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contact-Book</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script>
		$(function(){
$("#i1").fadeOut(2000);
});

		$(function(){
$("#i2").fadeOut(2000);
});
</script>	

  <style type="text/css">
  .c1
  {
  	color:red;
  }
  

</style>
</head>
<?php
session_start();
$con = mysqli_connect("localhost","root","admin123","contact-db");
if(isset($_GET['msg']))
{
  echo "Password sent on email";
}
if(isset($_GET['em']))
{
  echo "<b>OTP Sent</b>";
}
if(isset($_GET['var']))
{
  echo $_GET['var'];
}
if(isset($_POST['forget']))
{
  header("Location:password.php");
}
if(isset($_POST['login']))
{
	$user = $_POST['email'];
	$pass = $_POST['password'];

	$query = "select * from user where email='$user' and password='$pass'";
	
	$result = mysqli_query($con,$query);
	$count = mysqli_num_rows($result);

	if($count>0)
	{
		$res_array = mysqli_fetch_assoc($result);
		$myval = $res_array['email'];

		$ins_qry = "insert into livetb(email,time_use) values('$myval',now())";
		$_SESSION['cs1']=$myval;
    $_SESSION['impid']=$res_array['id'];
		$res_q = mysqli_query($con,$ins_qry);

		header('location:dashboard.php');
		?>

		<div class="alert alert-success" id="i2">
  <strong>Success!</strong> 
</div>
<?php 
	}
	else
	{
		//echo "Login Failed";

		?>
		<div class="alert alert-warning" id="i1">
  <strong>Warning!</strong> Invalid Email or Password.
</div>
	<?php }
}
	?>
		

<body link="red">
<form name="f1" method="post">
<div class="container">
  <h2><font color="blue">User-Login</font></h2>
  <p>You can Login using this form to your account.</p>
  
    <div class="form-group">
      <label for="inputdefault">Enter Email:</label>
      <input class="form-control" name="email" type="text">
    </div>
    <div class="form-group">
      <label for="inputlg">Enter Password:</label>
      <input class="form-control" name="password" type="password">
    </div>

    <i class="fas fa-key"></i><input type="submit" class="btn btn-link" name="forget" value="Forgot Password">
    <br><br>

    <input type="submit" class="btn btn-primary" name="login" value="Login">

    <input type="reset" class="btn btn-info" name="reset" value="Reset">


    <br>
    <br>
    <font face="calibri"><a href="signup.php" class="c1">Signup- Create a new Account</a></font>
     </form>
</div>
</body>
</html>