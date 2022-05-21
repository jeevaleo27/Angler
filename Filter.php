  <?php

  $CatagoryUID=$_POST['CatagoryUID'];

  $conn=mysqli_connect("localhost","root","","Angler");

  if($conn==true){

  }
  else
  {

    $output=0;
    echo json_encode($output);exit;
  }
  if(!empty($CatagoryUID)){

    $query = "SELECT * FROM mProductDetails WHERE ProductCategoryUID =".$CatagoryUID;
  }else{
    $query = "SELECT * FROM mProductDetails";

  }
  $result = mysqli_query($conn,$query);
  if($result ->num_rows>0){}

    $response ="<thead>";
  $response .="<tr>";
  $response .="<th>Product Name</th>";
  $response .="<th>Product Code</th>";
  $response .="<th>Product Image</th>";
  $response .="<th>Action</th>";
  $response .="</tr>";
  $response .="</thead>";
  $response .="<tbody>";

  while($row = mysqli_fetch_array($result)){

    $ProductDetailsUID = $row['ProductDetailsUID'];
    $ProductName = $row['ProductName'];
    $ProductCode = $row["ProductCode"];
    $ProductImage = $row['ProductImage'];
    $response .= "<tr>";
    $response .= "<td>".$ProductName."</td>";
    $response .= "<td>".$ProductCode."</td>";
    $response .= "<td><a href='Add.php?S_no=".$ProductDetailsUID."' data-toggle='tooltip' data-bs-placement='right' title='EDIT'><img src=".$ProductImage." alt='Italian Trulli'width='100' height='30'></a></td>";
    $response .= "<td><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-trash delete' data-id='".$ProductDetailsUID."' data-toggle='tooltip' data-bs-placement='right' title='DELETE' viewBox='0 0 16 16'>
                  <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                  <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                  </svg></td>";
    $response .= "</tr>";
  }
  $response .="</tbody>";
  echo json_encode($response);
  exit;

?>