<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<title>Contact-Display</title>

	<style type="text/css">
	#d1
	{
		padding:0;
		margin-top:10px;
		margin-right:50px;
	}
	.c2
	{
		margin:5px 5px 5px 15px;
	}
	h3 
	{
		padding:50;
		margin:5px 5px 5px 15px;
	}
	h5
	{
		padding:50;
		margin:5px 5px 5px 15px;
	}
	h6
	{
		padding:0;
		margin:5px 5px 5px 15px;
	}
</style>
<script language="javascript">
		function callme()
		{
			//alert("Hello");
			
		}
	</script>
<script>
	function search(id){
	$.ajax({
        type: "GET",
        url: "dashboard.php",
        data: "mainid =" + id,
        success: function(result) {
            $("#d1").html(result);
        }
    });
};
</script>
</head>
<?php
if(isset($_GET['mainid']))
{
	echo 44;
}
?>
<body>
	
<?php
session_start();
$con = mysqli_connect("localhost","root","admin123","contact-db");


//Pagination
if(isset($_GET['page']))
{
	$page = $_GET['page'];
}
else
{
	$page=1;	
}
$limit=2;
$start=($page-1) * $limit;

// $value = @$_SESSION['cs1'];
// $q1 = "select * from user where email='$value'";
// //echo $q1;

// $result = mysqli_query($con,$q1);

// $res1 = mysqli_fetch_assoc($result);

// $id = $res1['id'];

// $_SESSION['id1'] = $id;
//Searching with pagination
$v = $_SESSION['impid'];

//$sql="select * from contact where user_id=$v limit $start,$limit";

if(isset($_GET['filter']) && isset($_GET['search']))
{
	$field=$_GET['filter'];
	$txt=@$_GET['search'];
	$sql = "select * from contact where user_id=$v and $field like '%".$txt."%' limit $start,$limit";
	$sql_cnt= "select * from contact where user_id=$v and $field like '%".$txt."%'";
}
else
{
	$sql = "select * from contact where user_id=$v limit $start,$limit";
	$sql_cnt= "select * from contact where user_id=$v";
}

$res=mysqli_query($con,$sql);
$res_cnt=mysqli_query($con,$sql_cnt);
//echo $sql_cnt;
//die;
$cnt=mysqli_num_rows($res_cnt);
// if (isset($_POST['trigger'])) {
// 	$main_f=@$_POST['filter'];
// 	$text_s=@$_POST['search'];
// 	if(!empty($text_s) && $main_f=="name")	
// 	{
// 		$sql1="select * from contact where user_id=$v and name like '%$text_s%' limit $start,$limit";

// 	}
// 	if(!empty($text_s) && $main_f=="email")	
// 	{
// 		$sql1="select * from contact where user_id=$v and email like '%$text_s%' limit $start,$limit";
// 	}
// 	if(!empty($text_s) && $main_f=="phoneno")	
// 	{
// 		$sql1="select * from contact where user_id=$v and phone like '%$text_s%' limit $start,$limit";
// 	}

// 	$res1=mysqli_query($con,$sql);
// 	$res2=mysqli_query($con,$sql1);
// 	$counter=mysqli_num_rows($res2);
	

if (!isset($_SESSION['cs1'])) {
	header("location:index.php");
}

$value = @$_SESSION['cs1'];

$q1 = "select * from user where email='$value'";
//echo $q1;

$result = mysqli_query($con,$q1);

$res1 = mysqli_fetch_assoc($result);

$id = $res1['id'];
$nm = $res1['name'];
$em = $res1['email'];
$_SESSION['id1'] = $id;

$q2 = "select count(*) as cnt from contact where user_id=$id";
$result_set = mysqli_query($con,$q2);
//$total = mysqli_num_rows($result_set);
$q3 = "select * from contact where user_id='$id'";
$res2 = mysqli_query($con,$q3);


$records = mysqli_num_rows($res2);
$res_array = mysqli_fetch_assoc($result_set);
$total = $res_array['cnt'];
	
//echo $_SESSION['myname'];
//echo $_SESSION['id1'];
$q10 = "select count(*) as c1 from livetb where email='$value'";
$res_set = mysqli_query($con,$q10);
$result1 = mysqli_fetch_assoc($res_set);
$logs = $result1['c1'];
if(isset($_POST['logout']))
{
	session_destroy();
	header("location:index.php");
}
if(isset($_POST['DispBtn']))
{
	$_SESSION['last']=$id;
	header("location:slider.php");
	
}
if(isset($_POST['updateD']))

{
	header("Location:signup.php?uid=$id");
}
if(isset($_POST['imgBtn']))
{
	header("Location:images.php?imid=$id");
}

if (isset($_POST['del_btn'])) {
	//print_r($_POST);die;
	$cheks = implode("','", $_POST['del_ids']);
	
$sql = "delete from contact where id in ('$cheks')";

$result = mysqli_query($con,$sql) or die(mysqli_error());
header("Location:dashboard.php");
}


if(isset($_GET['dlid']) && !empty($_GET['dlid']))
{
	$id1 = $_GET['dlid'];

	$delimgq = "select * from contact where id='$id1'";
$res1 = mysqli_query($con,$delimgq);
	$mypics = mysqli_fetch_assoc($res1);

	//  echo "<pre>";
	//  print_r($mypics);
	// die;

	unlink($mypics['image']);

	$qry = "delete from contact where id=$id1";
	
	$res_q1 = mysqli_query($con,$qry);

	if($res_q1)
	{
		echo "Record Deleted";
		header("Location:dashboard.php");
	}

}
?>

<form method="post" name="f1">

<input type="submit" value="Logout" class="btn btn-primary btn-lg pull-right" id="d1" name="logout"><i class="fas fa-sign-out-alt"></i>

	<h3><?php echo "Welcome,". " ".$nm;?></h3>
	<h5><font color="red"><?php echo "-".$em;?></font></h5>
	<Table border="2" bordercolor="red" height="100%" width="100%">

<tr>
<b>
	<th style="text-align:center;"><input type="submit" class="btn btn-link" name="updateD" value="Update Account Details">
	</th>
	<th style="text-align:center;"><a href="contact.php" class="c2">Add New Contact</a></th>
	<th style="text-align:center;"><input type="submit" class="btn btn-link" name="imgBtn" value="Upload Images">
	</th>
</b>
</th>
</tr>
<Tr>
	<td colspan=3><center><b><input type="submit" class="btn btn-link" name="DispBtn" value="See Uploaded Images & SlideShow"></b></center></td>
</Tr>
</Table>
</form>
	<h6>Total Contacts Added:<?php echo $total;?></h6>
	<h6>Login Time:<?php echo $logs;?></h6>

<br>

<form name="f3">
<h3>Filters</h3>

<table class='table-bordered' caption="Search Filters" border="2" bordercolor="blue">
<tr>
	<th><select name="filter" onchange="">
	<option value="">Select Here</option>
	<option value="name" <?php if(@$field=='name'){echo 'selected';}?>>name</option>
	<option value="email" <?php if(@$field=='email'){echo 'selected';}?>>email</option>
	<option value="phone" <?php if(@$field=='phone'){echo 'selected';}?>>phone</option>
	</select>
</th>
<td>
	<input type="Text" name="search" id="sid" onChange="search(this.value)" value="<?php echo @$txt;?>">
	</td>
	<td>
		<input type="submit" class="btn btn-primary btn-md" name="trigger" value="Search">
	</td>
</tr>
</tr>
</table>
</form>
<br><Br>

<div class="table-responsive">
<table border="1" bordercolor="blue" align="Center" cellspacing="10" cellpadding="10" width="80%"class="table table-condensed table-stripped">
	<tr>
		<th><Center>Delete Multiple</Center></th>
		<th><center>ID</th>
		<Th><center>User_ID</Th>
		<th><center>Contact name</th>
		<th><center>Email</th>
		<Th><center>Phone</Th>
		<th><center>City</th>
		<th><center>Birthdate</th>
		<th><center>Image</th>
			<th><center>Update</center></th>
			<th><center>Delete</center></th>
	</Center>
	</tr>
<?php
$main_qry = "select * from contact where user_id=$id limit $start,$limit";
//$res_q = mysqli_query($con,$main_qry);
?><form method="post"><input type="submit" name="del_btn" value="Delete Selected">
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="select_all" value="Select All">

<?php  
while($row = mysqli_fetch_assoc($res))
{
	?>
	<br>
	<tr>
		<center>
			<td><input type="checkbox" name="del_ids[]" value="<?php echo $row['id']?>"></td>
		<td height=50 width=50><?php echo $row['id'];?></td>
		<td height=50 width=50><?php echo $row['user_id'];?></td>
		<td height=100 width=100><?php echo $row['name'];?></td>
		<td><?php echo $row['email'];?></td>
		<td><?php echo $row['phone'];?></td>
		<td><?php echo $row['city'];?></td>
		<td><?php echo $row['dob'];?></td>
		<td height=100 width=100><img src="<?php echo $row['image'];?>" height="100" width="100"></td>
		<td height="100" width=100><a href="contact.php?upid=<?php echo $row['id'];?>"><img src="actions/marker.png" height="70" width="70"></a></td>
		<td height="100" width="100"><a href="dashboard.php?dlid=<?php echo $row['id'];?>"><img src="actions/delete.png" height="70" width="70"></a></td>
		<center>
	</tr>
<?php } 
?>
</form>
<tr>
	<td colspan="11">
		<?php

		$tot_pages = ceil($cnt / $limit);
		//echo $tot_pages;
		if($page > 1)
	{?>
	<a href="dashboard.php?page=1<?php if(isset($filter)){echo "&filter=$field&search=$txt";}?>" class="btn btn-danger">First</a>

		<a href="dashboard.php?page=<?php echo $page-1;if(isset($filter)){echo "&filter=$field&search=$txt";}?>" class="btn btn-danger"><B><</B></a>
	   
	    <?php }
		
	for($p=1;$p<=$tot_pages;$p++)
	{
	?>
		<a href="dashboard.php?page=<?php echo $p;if(isset($filter)){echo "&filter=$field&search=$txt";}?>" class="btn btn-primary"><?php echo $p;?></a></strong>
<?php	}

if($page < $tot_pages)
{?>
	<a href="dashboard.php?page=<?php echo $page+1;if(isset($filter)){echo "&filter=$field&search=$txt";}?>" class="btn btn-danger"><B>></B></a>


		<a href="dashboard.php?page=<?php echo $tot_pages;if(isset($filter)){echo "&filter=$field&search=$txt";}?>" class="btn btn-danger">Last</a>	
	</td>


	<?php }	?>
	</tr>

</body>
</html>