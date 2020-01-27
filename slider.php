<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">



	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">

<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script></script>
	
	
	<title></title>
	<style type="text/css">
	body
	{
		margin:0;
		padding:0;
	}
	body {
    padding-top: 20px;
    
}

.btn-default {
    top: 25%;
    left:25%; 
    color: #999; 
    background: #fffccc; 
} 
</style>
</head>
<body>

</body>
<br><Br>	
<?php
session_start();
$con=mysqli_connect("localhost","root","admin123","contact-db");
if (!isset($_SESSION['cs1'])) {
	header("location:index.php");
}

if(isset($_SESSION['last']))
{

	$vid=$_SESSION['last'];
	$query="select pic from images where userid=$vid";
	$fire_q=mysqli_query($con,$query);

//	$res_array=mysqli_fetch_array($fire_q);
}
if(isset($_GET['path']))
{
	$picname=$_GET['path'];

$delimgq = "select * from images where pic='$picname'";

$res1 = mysqli_query($con,$delimgq);
$count=mysqli_num_rows($res1);
	$mypics = mysqli_fetch_assoc($res1);

	//  echo "<pre>";
	//  print_r($mypics);
	// die;

	unlink($mypics['pic']);


	$del_q="delete from images where pic='$picname'";
	$runme=mysqli_query($con,$del_q);
	header("location:slider.php");
}
?>




<div class="container">
<table>
	<tr><th colspan="3"><center style="color:red;border:5px groove lime";><a href="dashboard.php">Back To Dashboard</a></center></th></tr>
<?php
while($row = mysqli_fetch_array($fire_q))
{
	// $row['pic'];

	$arr[]=$row['pic'];
	?>
	<tr>
	<td>
	<img src="<?php echo $row['pic'];?>" width="200" height="200">
	</td>
	<td>
		<b>Discription:</b><?php echo $row['pic'];?>
	</td>
	
	<td height="auto" width="auto">
	<a href="slider.php?path=<?php echo $row['pic'];?>">	<input type="button" class="btn btn-link" value="Remove" name="res"></a></td>
</tr>


<!-- used for printing name of the image in array .print_r($arr[0][2]); -->
<?php }
?>
</table>

</div>
<br><br>


<center style="color:red;border:5px groove lime;"><input type="button" name="myme" class="link link-button" value="View As a Slideshow"></center>
<div class="w3-content w3-display-container">

<?php 
$c1=@sizeof($arr);
for($i=0;$i<$c1;$i++)
{
	?><center>
	<img class="mySlides" src="<?php echo $arr[$i];?>" style="width:30%;height:30%"></center>
<?php }
?>
<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>	

</div>

	<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
</body>
</html>