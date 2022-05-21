<?php

$CatagoryUID= $_POST['CatagoryName'];
$ProductName= $_POST["ProductName"];
$ProductCode= $_POST["ProductCode"];
$ProductDetailsUID= $_POST["ProductDetailsUID"];

?>

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fileToUpload= $target_file;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

/*Check if image file is a actual image or fake image*/
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    //echo "File is not an image.";
    $output=0;
    echo json_encode($output);exit;
    $uploadOk = 0;
  }
}

/*Check file size*/
if ($_FILES["fileToUpload"]["size"] > 500000) {

//print_r("Sorry, your file is too large.");
      $output=0;
    echo json_encode($output);exit;
  $uploadOk = 0;
}

/*Allow certain file formats*/
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $output=0;
    echo json_encode($output);exit;
  $uploadOk = 0;
}

/*Check if $uploadOk is set to 0 by an error*/
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
      $output=0;
    echo json_encode($output);exit;
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    /*echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";*/
  } else {
    //echo "Sorry, there was an error uploading your file.";
        $output=0;
    echo json_encode($output);exit;
  }
}
?>

<?php
$conn=mysqli_connect("localhost","root","","Angler");

if($conn==true){

}
else
{
  //echo " failed";
  $output=0;
  echo json_encode($output);exit;
}

if($ProductName && $ProductDetailsUID==""){

$query = "SELECT * FROM mProductDetails WHERE ProductName ='$ProductName'";
//print_r($query);
$result = mysqli_query($conn,$query);
//echo '<pre>';print_r($query);exit;
if($result ->num_rows!=0){
  $output="ProductName" ;
  echo json_encode($output);
  exit();
}
              

}

if($ProductCode && $ProductDetailsUID==""){

$query = "SELECT * FROM mProductDetails WHERE ProductCode ='$ProductCode'";

$result = mysqli_query($conn,$query);
//echo '<pre>';print_r($query);exit;
if($result ->num_rows>0){
 /* $output= ;*/
  echo json_encode("ProductCode");
  exit();
}
              

}

if(empty($ProductDetailsUID)){

$sql="INSERT INTO mProductDetails (ProductCategoryUID,ProductName,ProductCode,ProductImage) 
VALUES('$CatagoryUID','$ProductName','$ProductCode','$fileToUpload')";


}else{

$sql="UPDATE mProductDetails SET ProductCategoryUID='$CatagoryUID',ProductName='$ProductName',ProductCode='$ProductCode',ProductImage='$fileToUpload'WHERE ProductDetailsUID='$ProductDetailsUID' ";


}

if($conn ->query($sql)==true)

  {

$output=1;
    echo json_encode($output);
exit();

}
else
{
      $output=0;
    echo json_encode($output);exit;
}

?>