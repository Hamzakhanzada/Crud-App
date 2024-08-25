<?php
// connect to the database


$insert = false;
$update = false;
$delete = false;

$serverName = "localhost";
$userName = "root";
$password = "";
$database = "notes";

// create a connection
$conn = mysqli_connect($serverName, $userName, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("sorry we failed to connect: " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes`  WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        echo "yes";
        // update the records
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];

        // sql query to be executed
        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description'  WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "we could not updated a record successfully";
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        // sql query to be executed
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // echo "The record has been inserted successfully";
            $insert = true;
        } else {
            echo "The record was not inserted successfully: " . mysqli_error($conn);
        }
    }
}
?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Php Crud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">

</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/CRUD-APP/index.php" method="Post">
                        <input type="hidden" name="snoEdit" id="snoEdit">

                        <div class="mb-3">
                            <label for="titleEdit" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="descriptionEdit" class="form-label">Note Discription</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary d-block mr-auto">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                        <a class="nav-link" href="#">Contact-us</a>
                    </li>


                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong> Your note has been entered successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <?php
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong> Your note has been updated successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <?php
    if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong> Your note has been deleted successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <div class="container my-4">
        <h2>Add a note</h2>
        <form action="/CRUD-APP/index.php" method="Post">

            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Discription</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container my-4">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.NO </th>
                    <th scope="col">Title</th>
                    <th scope="col">Discription</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql =  "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
                    <th scope='row'>" . $sno . "</th>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td> <button class=' edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class=' delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button>
                    </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit", );
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName('td')[0].innerText;
                description = tr.getElementsByTagName('td')[1].innerText;
                console.log(title, description);
                descriptionEdit.value = description;
                titleEdit.value = title;
                snoEdit.value = e.target.id
                console.log(e.target.id);
                $('#editModal').modal('toggle');



            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit", );
                sno = e.target.id.substr(1, )

                if (confirm("Are you sure want to delete this note!")) {
                    console.log("yes");
                    window.location = `/CRUD-APP/index.php?delete=${sno}`;

                } else {
                    console.log("no");

                }




            })
        })
    </script>
</body>

</html>