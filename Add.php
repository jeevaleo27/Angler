<?php 
if(isset($_GET["S_no"])){
	$conn=mysqli_connect("localhost","root","","Angler");
	if($conn==true){
		$last_id=$_GET["S_no"];
		$querydata = "SELECT * FROM `mProductDetails` WHERE ProductDetailsUID =".$last_id.";";
		$result = mysqli_query($conn,$querydata);
		$EditData=mysqli_fetch_array($result);
		$conn->close();
	}
	else
	{
		echo " failed";
	}
}else{
	$EditData['ProductDetailsUID']="";
	$EditData['ProductCategoryUID']="";
	$EditData['ProductName']="";
	$EditData['ProductCode']="";
	$EditData['ProductImage']="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<style type="text/css">
	.error {
		border-color: #E74C3C;
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
	}
</style>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<h1 class="h2 mb-0 lh-sm text-primary font-weight-semibold">Product Details</h1>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0  me-2">
					<li class="nav-item active align-left">
						<a class="btn btn-primary" href="jeeva.php">View</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="container-fluid" style="margin-top: 100px;">
		<div class="row">
			<div class="col-sm-12">
				<div class="m-4">
					<div  class="main col-10 h-100   py-3">
						<form id="form" method="POST" name="myForm" action="save.php" 
						enctype="multipart/form-data" onsubmit="return validateForm()">
						<div>
							Bio-Data
						</div>
						<div>
							* Required fieldset
						</div>
						<?php //if(!empty($EditData['ProductDetailsUID'])){ ?>
							<input type="hidden" name="ProductDetailsUID" value="<?php echo $EditData['ProductDetailsUID'] ;?>">
							<?php //} ?>
							<div class="form-group">
								Catagory Name:*<select name = "CatagoryName" class="form-control" id="dropdown" >
									<?php
									$conn=mysqli_connect("localhost","root","","Angler");
									$query = "select * from mProductCategory";

									$results = mysqli_query($conn,$query);

									while ($rows = mysqli_fetch_array(@$results)){ 
										?>
										<option value="<?php echo $rows['ProductCategoryUID'];?>" <?php echo $EditData['ProductCategoryUID'] == $rows['ProductCategoryUID'] ? 'selected="selected"' : '' ;?>><?php echo $rows['CategoryName'];?></option>

										<?php
									} 
									?>
								</select><p id="alertdrop"></p>
							</div>
							<div class="form-group">
								<label for="ProductName">Product Name:*</label> <input class="form-control" type="text" id="ProductName" name="ProductName" value="<?php echo $EditData['ProductName'] ;?>" ><p id="alertProductName" class="text-danger"></p>
							</div>
							<div class="form-group">
								<label for="ProductCode">Product Code:*</label> <input class="form-control" type="text" id="ProductCode" name="ProductCode" value="<?php echo $EditData['ProductCode'] ;?>" pattern="[A-Za-z0-9]{6}" maxlength="6" placeholder="PRO001"><p id="alertProductCode" class="text-danger"></p>
							</div>
							<div class="form-group">
								<label for="fileToUpload">Product Image:*</label><input class="form-control" type="file" id="fileToUpload" name="fileToUpload"><p id="alertpassword"></p>
							</div>
							<div class="form-group">
								<div class="p-3 mb-4">
									<div class="text-center">
										<button type="submit" class="btn btn-success text-center" value="submit"> Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );

	$("#form").on('submit',(function(e) {
		e.preventDefault();

	}));

	function validateForm() {
		let ProductName = document.forms["myForm"]["ProductName"].value;
		if (ProductName == "") {
			swal("warning!", "Please Fill ProductName!", "warning");
			return false;
		}

		let ProductCode = document.forms["myForm"]["ProductCode"].value;
		if (ProductCode == "") {
			swal("warning!", "Please Fill ProductCode!", "warning");
			return false;
		}

		let fileToUpload = document.forms["myForm"]["fileToUpload"].value;
		if (fileToUpload == "") {
			swal("warning!", "Please Select Image!", "warning");
			return false;
		}

		if(ProductName!="" && ProductCode!="" && fileToUpload !=""){

			$("#ProductName").removeClass("error");
			$("#ProductCode").removeClass("error");
			$("#alertProductName").html("");
			$("#alertProductCode").html("");

			const formData = new FormData(form);
			$.ajax({
				url: "save.php",
				type: "POST",
				dataType:"JSON",
				data: formData ,
				contentType: false,
				cache: false,
				processData:false,
				success: function(data)
				{
					if(data==1)
					{
						swal("Good job!", "Product Details saved Successfully!", "success");
						setTimeout(function () {
							window.location.href = 'jeeva.php';
						}, 2000);
					}
					else if(data==0)
					{
						swal("Failed!", "Product Details Failed!", "warning");
						setTimeout(function () {
							window.location.href = 'Add.php';
						}, 2000);
					}else{
						swal("warning!", data+" Already Available", "warning");
						if(data == "ProductName"){
							$("#ProductName").addClass("error");
							$("#alertProductName").html("Product Name Already Available");
						}else if(data =="ProductCode"){
							$("#ProductCode").addClass("error");
							$("#alertProductCode").html("Product Code Already Available");
						}
					}         
				}
			});
		}
	}
</script>
</html>