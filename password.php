<!DOCTYPE html>
<html>
<head>
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
	</script>
	<title></title>
</head>
<?php
session_start();
function sendMail($em)
{
	require 'include/PHPMailerAutoload.php';

	$value = rand(100000,999999);
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server

//$mail->SMTPSecure = 'ssl';   
$mail->Host = "ssl://smtp.gmail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "phpmailtest80@gmail.com";
//aama thi mail jai
//Password to use for SMTP authentication
$mail->Password = "bananaisblue";
//Set who the message is to be sent from
$mail->setFrom('phpmailtest80@gmail.com','Contact OTP password');
//aama thi mail
//Set an alternative reply-to address
$mail->addReplyTo('parthmangukiya20@gmail.com', 'Parth Mangukiya');
//aane reply aave hardik reply kre to
//Set who the message is to be sent to
$mail->addAddress($em,'Password');
//aane mail jai parth thi
//Set the subject line
$mail->Subject = 'OTP for Your Contact- Account';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
// $mail->msgHTML("<table border='2' bordercolor='red'><tr><th>Password</th></tr><tr><td>$value</td></tr></table>");

//$mail->msgHTML("Your OTP is: " . $value);

$mail->msgHTML("<table style='border:1px red groove'><tr><th>Password</th></tr><tr><td>$value</td></tr></table>");
$_SESSION['sit'] = $value;
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('images/picture.jpg');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    return 0;
} else {
    echo "Message sent!";
    return 1;
}
}
if(isset($_POST['btn']))
{
	$em_check = @$_POST['email'];
	$con = mysqli_connect("localhost","root","admin123","contact-db");
	$query = "select count(*) as cnt from user where email='$em_check'";

	$result = mysqli_query($con,$query);
	$res_array=mysqli_fetch_assoc($result);
	$value = $res_array['cnt'];
	
	
	if($value==1)
	{
		if(sendMail($em_check))
		{
			$pass = $_SESSION['sit'];
			echo "Mail Sent";
			$query = "update user set password='$pass' where email='$em_check'";
			$run_q = mysqli_query($con,$query);
			if($run_q)
			{
				header("Location:index.php?em=EmailSent");	
			}
			else
			{
				echo "Error!..";
			}
			
		}
		else
		{
			echo "Email Not Sent";
		}
	}
	elseif($value==0)
	{
		?>
		<div class="alert alert-warning" id="i1">
  <strong>Warning!</strong> Email not found.
</div>
	<?php 	//echo "Email Not Found";

	}
	else
	{

		echo "Duplicate Emails Found";
		header("Location:index.php?var=duplicateEmailsFound.");
	}
	//echo $value;
}
?>
<body>
<form name="f1" method="post">
	<br>
	<div class="container">
		<div class="form-group">
	<label>Enter Email here and we will send OTP to your mail.</label>
	<br>
	<input type="email" placeholder="Enter Email Here" size="40" name="email" class="form-control">
	<br>
	<Br>
	<input type="submit" value="Send Password" name="btn">
</form>
</body>
</html>