<!-- Configuration -->
<?php
$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
  die ("Connection to database failed due to " . mysqli_connect_error());
}
// echo $_GET['update'];
// echo $_POST['srnoEdit'];

  // echo "Connection was successful!";

  if(isset($_GET['delete'])){
    $srno = $_GET['delete'];
    $sql = "DELETE FROM `php_crud_notes` WHERE `Sr. No.` = $srno;";
    $result = mysqli_query($conn, $sql);
    if($result){
        // echo "The record has been deleted successfully!<br>";
        $delete = true;
      }else{
        echo "Could not insert the record due to " . mysqli_error($conn);
      }
  }

  // if($_SERVER['REQUEST_METHOD'] == 'GET'){
  //   $srno = $_GET['delete'];
  //   $sql = "DELETE FROM `php_crud_notes` WHERE `Sr. No.` = $srno;";
  //   $result = mysqli_query($conn, $sql);
  //   if($result){
  //       // echo "The record has been deleted successfully!<br>";
  //       $delete = true;
  //     }else{
  //       echo "Could not insert the record due to " . mysqli_error($conn);
  //     }
  // }
  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['srnoEdit'])){
      // Update the record
      $srno = $_POST["srnoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      $sql = "UPDATE `php_crud_notes` SET `Title` = '$title' ,  `Description` = '$description' WHERE `php_crud_notes`.`Sr. No.` = $srno;";
      $result = mysqli_query($conn, $sql);
      if($result){
        // echo "The record has been updated successfully!<br>";
        $update = true;
      }else{
        echo "Could not insert the record due to " . mysqli_error($conn);
      }

    }
    else{
      $title = $_POST["title"];
      $description = $_POST["description"];

      $sql = "INSERT INTO `php_crud_notes` (`Sr. No.`, `Title`, `Description`, `Time_Stamp`) VALUES (NULL, '$title', '$description', current_timestamp());";
      $result = mysqli_query($conn, $sql);

      if($result){
        // echo "The record has been added successfully!<br>";
        $insert = true;
      }else{
        echo "Could not insert the record due to " . mysqli_error($conn);
      }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

</head>

<body>

  <!-- Edit Button Modal Starts -->

  <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="srnoEdit" id="srnoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <!-- Edit Button Modal Ends -->

  <!-- Navbar Section Starts -->
  <!-- bg-body-tertiary -->
  <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="phplogo.svg" height="30px alt="" srcset=""> CRUD</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Navbar Section Ends -->

  <!-- Alert Section Starts -->

  <?php
    
    if($insert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> The note has been added successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    
    if($update){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> The note has been updated successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    
    if($delete){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Success!</strong> The note has been deleted successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    ?>

  <!-- Alert Section Ends -->

  <!-- Form Section Starts -->

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <!-- Form Section Ends -->

  <!-- Fetching Section Starts -->

  <div class="container my-4 py-4">
  <!-- <div class="container my-4 table-dark py-4 bg-dark"> -->

    <!-- <table class="table table-dark" id="myTable"> -->
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sr. No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
    
    $sql = "SELECT * FROM `php_crud_notes`";
    $result = mysqli_query($conn, $sql);
    $srno = 0; 
    while($row = mysqli_fetch_assoc($result)){
      $srno = $srno + 1;
      echo "<tr>
      <th scope='row'>" . $srno . "</th>
      <td>" . $row['Title'] . "</td>
      <td>" . $row['Description'] . "</td>
      <td> <button class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' id=".$row['Sr. No.'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['Sr. No.'].">Delete</button></td>
      </tr>";
      // <button type='button' class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button>
      // echo var_dump($row) . "<br>";
      // echo $row['Sr. No.'] . ". Title is " . $row['Title'] . ", Description is " . $row['Description'];
      // echo "<br>";
    }
    

    ?>
      </tbody>
    </table>

  </div>
  <hr>

  <!-- Fetching Section Ends -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script>
    // New script with some bugs
    // let table = new DataTable('#myTable');
    // Old Script
    $(document).ready(function (){
      $('#myTable').DataTable();
    });
  </script>

  <script>
    // For Edits
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        srnoEdit.value = e.target.id;
        console.log(e.target.id);
        // $('#editModal').modal('toggle');
      })
    })
    // For Delete
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete");
        tr = e.target.parentNode.parentNode;
        srno = e.target.id.substr(1,);

        let warning = confirm ("Are you sure you want to delete this note?")
        if(warning){
          console.log("yes");
          window.location = `index.php?delete=${srno}`;
          // window.location = "index.php?delete=true";
          // TODO : Create a form and use post request to submit a form
        }
        else{
          console.log("no");
        }
      })
    })
  </script>

</body>

</html>