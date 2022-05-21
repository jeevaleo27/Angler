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
						<a class="btn btn-primary" href="Add.php">Add</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="container-fluid" style="margin-top: 100px;">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					Catagory Name:*<select name = "CatagoryName" class="form-control" id="dropdown" >
						<option value="">SELECT</option>
						<?php
						$conn=mysqli_connect("localhost","root","","Angler");
						$query = "select * from mProductCategory";
						$results = mysqli_query($conn,$query);
						while ($rows = mysqli_fetch_array(@$results)){ 
							?>
							<option value="<?php echo $rows['ProductCategoryUID'];?>"><?php echo $rows['CategoryName'];?></option>

							<?php
						} 
						?>
					</select><p id="alertdrop"></p>
				</div>
				<div class="m-4">
					<table id="table_id" class="display productLIST">
						<thead>
							<tr>
								<th>Product Name</th>
								<th>Product Code</th>
								<th>Product Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$conn=mysqli_connect("localhost","root","","Angler");
							$query = "SELECT * FROM mProductDetails ORDER BY ProductDetailsUID DESC";
							$result = mysqli_query($conn,$query);
							if($result ->num_rows>0){
								while($row = mysqli_fetch_array($result)){

									$ProductDetailsUID = $row['ProductDetailsUID'];
									$ProductName = $row['ProductName'];
									$ProductCode = $row["ProductCode"];
									$ProductImage = $row['ProductImage'];
									echo "<tr>";
									echo "<td>".$ProductName."</td>";
									echo "<td>".$ProductCode."</td>";
									echo "<td> <a href='Add.php?S_no=".$ProductDetailsUID."' data-toggle='tooltip' data-bs-placement='right' title='EDIT'><img src=".$ProductImage." alt='Italian Trulli'width='100' height='30'></a></td>";
									echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-trash delete' data-id='".$ProductDetailsUID."' data-toggle='tooltip' data-bs-placement='right' title='DELETE' viewBox='0 0 16 16'>
									<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
									<path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
									</svg>
									</td>";

									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</body>
<script>
	$(document).ready( function () {

		var table = $('#table_id').DataTable();

		$('[data-toggle="tooltip"]').tooltip();

	});

		$(document).off('click','.delete').on('click','.delete', function(e) {
		var ProductDetailsUID = $(this).attr('data-id');

		//e.preventDefault();

		swal({
			title: "Are you sure ??",
			text: "Do you want to delete?", 
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: "delete.php",
					type: "POST",
					dataType:"JSON",
					data: {"ProductDetailsUID": ProductDetailsUID},
					success: function(data)
					{
						if(data==1)
						{

							swal("success", "Product Delete Successfully!", "success");
							setTimeout(function () {
								window.location.href = 'jeeva.php';
							}, 2000);
						}else  if(data==2)
						{
							swal("Failed!", "Product Delete Failed!", "warning");
							setTimeout(function () {
								window.location.href = 'jeeva.php';
							}, 2000);
						}
						else
						{
							swal("Failed!", "Product NOT Avaialbe!", "warning");
							setTimeout(function () {
								window.location.href = 'jeeva.php';
							}, 2000);

						}
					}         
				});
			}
		});
	});


	$("#dropdown").on('change',(function(e) {
		e.preventDefault();
		var CatagoryUID = $(this).val();
		$('#table_id').DataTable().destroy();
		$.ajax({
			url: "Filter.php",
			type: "POST",
			dataType:"json",
			data: {"CatagoryUID": CatagoryUID},
			success: function(data)
			{
				$('#table_id').DataTable({

				});
				$('.productLIST').html("");
				$('.productLIST').html(data);
				$('[data-toggle="tooltip"]').tooltip();
				
			}         
		});
	}));
</script>
</html>