<?php

$ProductDetailsUID=$_POST['ProductDetailsUID'];

$conn=mysqli_connect("localhost","root","","Angler");

if($conn==true){

}
else
{

	$output=0;
	echo json_encode($output);exit;
}

$sql="SELECT ProductDetailsUID FROM mProductDetails WHERE ProductDetailsUID=".$ProductDetailsUID;
$result=$conn ->query($sql);
if($result ->num_rows >0)

{

	$del=" DELETE FROM mProductDetails WHERE ProductDetailsUID='".$ProductDetailsUID."'";

	$result= $conn -> query($del);

	if($result == true){

		$output=1;
		echo json_encode($output);
		exit();

	}else{

		$output=2;
		echo json_encode($output);
		exit();

	}
}
else
{
//echo " data failed";
	$output=0;
	echo json_encode($output);exit;
}
?>