<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<script>
			function checkAvail()
			{
				jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#email-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
			}
		</script>
		<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<script>

  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>
</head>
<?php

session_start();
$con = mysqli_connect("localhost","root","admin123","contact-db");
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
$_SESSION['mainp'] = $value;
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('images/3.jpg');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    return 0;
} else {
    echo "Message sent!";
    return 1;
}
}

if(isset($_POST['moveBtn']))
{
	header("location:index.php");
}

if(isset($_GET['uid']))
{
	$buttontext='Update';
	$ex_query = "select * from user where id='$_GET[uid]'";
	$res_array = mysqli_query($con,$ex_query);
	$res=mysqli_fetch_assoc($res_array);
	$name=$res['name'];
	$pass=$res['password'];
	$email=$res['email'];
	$phone=$res['phone'];
	$gender=$res['gender'];
	$city=$res['city'];
	$image=$res['image'];
}
else
{
	$buttontext="Save";
}
if(isset($_POST['btnsubmit']))
{

	$name = @$_POST['name'];
	$email = @$_POST['email'];
//	$pass = @$_POST['password'];
	$phone = @$_POST['mobile'];
	$gender = @$_POST['gender'];
	$city = @$_POST['s1'];
	$imag=date('d').time().$_FILES['mypic']['name'];

	if (trim($name)=="") {
		# code...
		$amsg="Enter Name Here";
	}
	else if(!preg_match("/^[A-Za-z ]{3,30}$/", $name))
	{
		$amsg="Enter Valid Name";
	}
	if (trim($email)=="") {
		# code...
		$bmsg="Enter Email Here";
	}
	elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		# code...
		$bmsg="Enter Valid Email";
	}
	// if(trim($pass)=="")
	// {
	// 	$cmsg="Enter Password";
	// }
	// elseif(!preg_match("/^[a-zA-Z0-9!@#$%^&*() ]{6,30}$/", $pass)) {
	// 	# code...
	// 	$cmsg="Enter Valid Password";
	// }
	if(trim($phone)=="")
	{
		$dmsg="Enter Mobileno";
	}
	elseif(!preg_match("/^[6789]{1}[0-9]{9}$/", $phone))
	{
		$dmsg="Enter Valid No";
	}
	if(trim($gender)=="")
	{
		$emsg="Enter Gender";
	}
	if(trim($city)=="")
	{
		$fmsg="Select City";
	}

	//if()

	if(isset($_GET['uid']))
	{
		if(!empty($_FILES['mypic']['name']))
		{
			//move_uploaded_file($_FILES['mypic']['tmp_name'],"images/".$imag)
			copy($_FILES['mypic']['tmp_name'], "images/".$imag);
			$imag1 = "images/".$imag;
			$imag=$imag1;
			unlink($res['image']);

		}
		else
		{
			$imag=$res['image'];
		}
		if(@$_SESSION['dup']==0 && empty($emsg) && empty($amsg) && empty($bsmg) && empty($fmsg)  && empty($dmsg))
	//	echo $_SESSION['dup'];
		{
			$ids=$_GET['uid'];
			$query = "update user set name='$name',phone='$phone',email='$email',city='$city',gender='$gender',image='$imag',password='$pass' where id=$ids";
				$fire_qry = mysqli_query($con,$query);
					if($fire_qry)
					{
					$_SESSION['ss']=1;
					header("location:dashboard.php");
					}	
				else
				{
				echo "Correct Details";
				}
		}
		else
		{
			?>
			<div class="alert alert-info" id="d1">
    		<strong>Info!</strong> Please First Fill all the Form with original details.
  			</div> 
		<script>
			$(function(){
				$("#d1").fadeUp(500);
			})
		</script>
		<?php }
			
	}
	
	//die;
	else{
			if(!empty($_FILES['mypic']['name'])){
			copy($_FILES['mypic']['tmp_name'], "images/".$imag);
			$imag1 = $imag;
		$imag1 = "images/".$imag;	
		}
	else{
		$picmsg="Select Picture";
	}
		if(empty($amsg) && empty($bmsg)  && empty($dmsg) && empty($emsg) && empty($fmsg) && $_SESSION['dup']==0 && empty($picmsg)){
			if(sendMail($email)){
				$pass=$_SESSION['mainp'];
	$query = "insert into user(name,email,password,phone,gender,city,image) values('$name','$email','$pass','$phone','$gender','$city','$imag1')";
	$fire_qry = mysqli_query($con,$query);
	header("Location:index.php?msg=Passwordsentonmail");
	//$query = "insert into user(name,email,password,phone,gender,city,image) values('$name','$email','".md5($pass)."','$phone','$gender','$city','$imag1')";
		}
		else{
	echo "Mail Not Sent";
		}
	}

}

	}
	
	
	

?>
<body>

 	<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Contact Registration</h1>
	               		<hr />
	               	</div>
	            </div> 
	            <form name="f1" method="post" enctype="multipart/form-data">
				<div class="main-login main-center">
					
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name" value="<?php echo @$name;?>"/>
								</div>
							</div>
							<?php echo @$amsg;?>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="emailid"  placeholder="Enter your Email" value="<?php echo @$email;?>" onBlur="checkAvail()"/>
								</div>
								<span id="email-availability-status"></span>
							</div>
							<?php echo @$bmsg;?>
						</div>

						
						<?php
						if(isset($_GET['uid']))
						{
							?>
						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" value="<?php echo @$pass;?>" style='display:hidden' />
								</div>
							</div>
							<?php echo @$cmsg;?>
						</div>
						<?php
						 }?>

						<div class="form-group">
							<label for="phone" class="cols-sm-2 control-label">Enter Mobile:</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-phone" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="mobile" id="confirm"  placeholder="Enter Your Mobileno" value="<?php echo @$phone;?>"/>
								</div>
							</div>
							<?php echo @$dmsg;?>
						</div>

						<div class="form-group">
							<label for="gender" class="cols-sm-2 control-label">Select Gender</label>
							
								<div class="input-group">
									<center>
									<span class="input-group-addon"><i class="fas fa-male" aria-hidden="true"></i>
									Male
									<input type="radio" name="gender" value="Male" <?php if(@$gender=='Male') {echo 'checked';}?>/>
<i class="fas fa-female" aria-hidden="true"> </i>
									Female
									<input type="radio" name="gender" value="Female" <?php if(@$gender=='Female') {echo 'checked';}?>/>
								</span>
								
							</div>
							<?php echo @$emsg;?>
						</div>

						<div class="form-group">
							<label for="city" class="cols-sm-2 control-label">Select City</label>
							<div class="cols-sm-6">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-building" aria-hidden="true"></i></span>
									<select name="s1" name="city" class="form-control">
										<option value="">Select</option>
										<option <?php if(@$city == "Surat") echo "selected";?> >Surat</option>
											<option <?php if(@$city == "Vadodara") echo "selected";?> >Vadodara</option>
											<option <?php if(@$city == "Ahemadabad") echo "selected";?> >Ahemadabad</option>
											<option <?php if(@$city == "Gandhinagar") echo "selected";?> >Gandhinagar</option>
											
											
											
									</select>
								</div>

							</div>
						 	<?php echo @$fmsg;?>
						</div>

						<div class="form-group">
							<label for="file" class="cols-sm-2 control-label">Upload Picture</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-image" aria-hidden="true"></i></span>
									<input type="file" class="form-control" name="mypic" id="file1" accept="image/*" onchange="loadFile(event)"/>
								</div>
							</div>
						</div>
<img src="<?php echo $res['image'];?>" height="100" width="100" id="output" alt="Image not Specified">
						<input type="submit" name="btnsubmit" value="<?php echo $buttontext;?>">
						<input type="reset" name="resetbtn" value="Reset">
						<input type="submit" name="moveBtn" value="Login">
						
							<br><Br>
					</form>
				</div>
			</div>
		</div>
</form>
	</Body>
		</html>