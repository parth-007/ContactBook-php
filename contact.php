<html>
<head>
		<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
	<script>
			function checkme()
			{
				jQuery.ajax({
url: "check.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#email-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
			}
		</script>
	</script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>


		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="mybd"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso .form').length>0 ? $('.bootstrap-iso .form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy/mm/dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
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
	</script>
	<title></title>
</head>
<?php
session_start();

if (!isset($_SESSION['cs1'])) {
	header("location:index.php");
}

$v1 = $_SESSION['id1'];
$con = mysqli_connect("localhost","root","admin123","contact-db");

if(isset($_GET['upid']))
{
	$buttontext = "Update";
	$i2 = $_GET['upid'];
	$q5 = "select * from contact where id=$i2";
	$res_arr = mysqli_query($con,$q5);

	$row = mysqli_fetch_assoc($res_arr);

	$name = $row['name'];
	$email = $row['email'];
	$phone = $row['phone'];
	$city = $row['city'];
	$dob = $row['dob'];

}
else
{
	$buttontext="Save";
}
if(isset($_POST['btnShow']))
{
	header("location:dashboard.php");
}
if(isset($_POST['btnsubmit']))
{
	//echo "<pre>";print_r($_POST);print_r($_FILES);die;

	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['mobile'];
	$dob = $_POST['mybd'];
	$city = $_POST['s1'];
	$imag=date('d').time().$_FILES['mypic']['name'];
	if(trim($name)=="")
	{
		$amsg="Please Enter Name";
	}
	elseif (!preg_match("/^[A-Za-z ]{5,20}$/", $name)) {
		$amsg="Please Enter Valid Name";
	}
	if (trim($email)=="") {
		$bmsg="Please Enter Email";
	}
	elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
	{
		$bmsg="Please Enter Valid Email";
	}
	if(trim($phone)=="")
	{
		$cmsg="Please Enter Phone";
	}
	elseif(!preg_match("/^[6-9]{1}[0-9]{9}$/", $phone))
	{
		$cmsg="Enter Valid PHone";
	}
	if(trim($city)=="")
	{
		$dmsg="Please Select City";
	}
	if(trim($dob)=="")
	{
		$emsg="Please Enter Birthdate";
	}


	if(isset($_GET['upid']))
	{
		if(!empty($_FILES['mypic']['name']))
		{
			//move_uploaded_file($_FILES['mypic']['tmp_name'],"images/".$imag)
			copy($_FILES['mypic']['tmp_name'], "con_images/".$imag);
			$imag1 = "con_images/".$imag;
			$imag=$imag1;
			unlink($row['image']);
		}
		else
		{
			$imag=$row['image'];
		}
		if ($_SESSION['dups']==0 && empty($emsg) && empty($amsg) && empty($bsmg) && empty($cmsg)  && empty($dmsg)) 
		{
			$query = "update contact set name='$name',phone='$phone',email='$email',city='$city',dob='$dob',image='$imag' where id=$i2";
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
	else
	{
		if(is_uploaded_file($_FILES['mypic']['tmp_name']))
		{
			copy($_FILES['mypic']['tmp_name'], "con_images/".$imag);
			$imag1 = "con_images/".$imag;
			//echo $imag1;
			//die;
		}
	else
	{
	$imag1="";
	}
		

	if($_SESSION['dups']==0 && empty($emsg) && empty($amsg) && empty($bsmg) && empty($cmsg)  && empty($dmsg))
	{
	$query = "insert into contact(user_id,name,email,phone,city,dob,image) values('$v1','$name','$email','$phone','$city','$dob','$imag1')";
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
	//
	else{
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
}
	?>
<body>
<form name="f1" method="post" enctype="multipart/form-data">

<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Contact Registration</h1>
	               		<hr />
	               	</div>
	            </div> 
	            <div class="main-login main-center">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name" value="<?php echo @$name;?>"/>
									
								</div>
							</div>
								<label><?php echo @$amsg;?></label>	
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="emailid" placeholder="Enter your Email" value="<?php echo @$email;?>" onBlur="checkme()"/>
									<!-- <?php echo @$bmsg;?> -->
								</div>
								<span id="email-status"></span>
							</div>
							<label><?php echo @$bmsg;?></label>

						</div>

						
						

						<div class="form-group">
							<label for="phone" class="cols-sm-2 control-label">Enter Mobile:</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-phone" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="mobile" id="confirm"  placeholder="Enter Your Mobileno" value="<?php echo @$phone;?>"/>
									
								</div>
							</div>
							<label><?php echo @$cmsg;?></label>
						</div>


				<div class="bootstrap-iso">
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-6 col-sm-6 col-xs-12">
     <div class="form-group form">
      <label class="control-label col-sm-3 requiredField" style="text-align: left;" for="date">
       Select Birthdate
       
      </label>
      <div class="col-sm-9">
       <div class="input-group">
        <div class="input-group-addon">
         <i class="fa fa-calendar">
         </i>
        </div>
        <input class="form-control" id="date" name="mybd" placeholder="YYYY/MM/DD" type="text" value="<?php echo @$dob;?>"/>
       </div>
      </div>
     </div>
     
    
   </div>
  </div>
 </div>
 <label><?php echo @$emsg;?></label>
</div>


						<div class="form-group">
							<label for="city" class="cols-sm-2 control-label">Select City</label>
							<div class="cols-sm-6">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-building" aria-hidden="true"></i></span>
									
									<select name="s1" name="city" class="form-control"><?php echo @$dmsg;?>
										<option value="">Select</option>
										<option <?php if(@$city == "Surat") echo "selected";?> >Surat</option>
											<option <?php if(@$city == "Vadodara") echo "selected";?> >Vadodara</option>
											<option <?php if(@$city == "Ahemadabad") echo "selected";?> >Ahemadabad</option>
											<option <?php if(@$city == "Gandhinagar") echo "selected";?> >Gandhinagar</option>
											
											
											
									</select>
								</div>
							</div>
						 	<label><?php echo @$dmsg;?></label>
						</div>

						<div class="form-group">
							<label for="file" class="cols-sm-2 control-label">Upload Picture</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-image" aria-hidden="true"></i></span>
									<input type="file" class="form-control" name="mypic" accept="image/*" onchange="loadFile(event)"/>
								</div>
							</div>
						</div>

<!-- <?php
//if(isset($_GET['upid']))
{
	?> -->
	<img src="<?php echo $row['image'];?>" height="100" width="100" id="output" alt="Image not Specified">
<!-- <?php }
//else
{

}
?> -->
<br><BR><BR><BR>

						<input type="submit" name="btnsubmit" value="<?php echo $buttontext;?>">
						<input type="reset" name="resetbtn" value="Reset">
						<input type="submit" name="btnShow" value="Display">
							<br><Br>
					
					</div>
					</form>
					</body>
</html>