<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(function(){
$("#ddd1").fadeOut(2000);
});
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
$con=mysqli_connect("localhost","root","admin123","contact-db");
if (!isset($_SESSION['cs1'])) {
	header("location:index.php");
}
if(isset($_POST['Btn']))
{
	$myid=$_GET['imid'];
	if(!empty($_FILES['mypic']['name']))
	{
		$iname = $myid."_".date('d')."_".date('m')."_".date('y')."_".time()."_".$_FILES['mypic']['name'];
		copy($_FILES['mypic']['tmp_name'],"user_images/".$iname);
		$fpath="user_images/".$iname;

		$query="insert into images values(null,$myid,'$fpath')";
		//echo $query;
		$run_q=mysqli_query($con,$query);
		if($run_q)
		{
		//	echo "Uploaded";
?>
			<div class="alert alert-success" id="ddd1">
  <strong>Success!</strong> Success,Image Uploaded.
</div>
<?php 		}
		else
		{
			
		}
	}
}
?>
<body>
<form name="f1" method="post" enctype="multipart/form-data">
	Submit Picture<br><input type="file" name="mypic" accept="image/*" onchange="loadFile(event)"/>
<br>
<img id="output" width="150" height="150" src="" alt="Image not Selected">
	<br><br>
	<input type="submit" name="Btn" value="Upload">
</form>

<a href="dashboard.php">Back to DashBoard!</a>
</body>
</html>