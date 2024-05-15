<?php
include('connection.php');
session_start();

// Check if the delete_id parameter is set and it's a valid integer
if(isset($_GET['delete_id']) && ctype_digit($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute the delete query
    $delete_query = $db->prepare("DELETE FROM donor_reg WHERE id = :id");
    $delete_query->bindValue(':id', $delete_id, PDO::PARAM_INT);
    if($delete_query->execute()) {
        // Redirect back to the donor list page after successful deletion
        header("Location: donor-list.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        // Handle deletion failure (optional)
        echo "Failed to delete donor record.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/style.css">
    <style type="text/css">
        td{
            height:40px;
            overflow:hidden;
            margin-bottom:10px;
        }
       
    .form tr {
    position: relative;
    top: -30px;
    display: grid;
    grid-template-columns: repeat(9,1fr);
    column-gap: 7px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="inner-container">
            <section class="header">
                <a href="admin-home.php"><h2>Blood Bank Management</h2></a>
            </section>
            <section class="body">
                <?php
                $un = $_SESSION['un'];
                if(!$un){
                    header("Location:index.php");
                    exit(); // Ensure script execution stops after redirection
                }
                ?>
                <center><h3>Donor List</h3></center>
                <center>
                    <div class="form">
                        <table>
                            <tr>
                                <td><b>Name</b></td>
                                <td><b>Father's Name</b></td>
                                <td><b>City</b></td>
                                <td><b>Address</b></td>
                                <td><b>Age</b></td>
                                <td><b>Email</b></td>
                                <td><b>Contact</b></td>
                                <td><b>Blood Group</b></td>
                                <td><b>Action</b></td> <!--delete option -->
                            </tr>
                            <?php
                            $q = $db->query("SELECT * FROM donor_reg");
                            while($r1 = $q->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td><?= $r1->name; ?></td>
                                    <td><?= $r1->father_name; ?></td>
                                    <td><?= $r1->city; ?></td>
                                    <td><?= $r1->address; ?></td>
                                    <td><?= $r1->age; ?></td>
                                    <td><?= $r1->email; ?></td>
                                    <td style="color:blue;"><?= $r1->phone_num; ?></td>
                                    <td style="color:red;"><?= $r1->blood_group; ?></td>
                                    <!-- Delete option -->
                                    <td><a href="donor-list.php?delete_id=<?= $r1->id; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </center>
            </section>
            <section class="footer">
                <div class="copyright">
                    <span>Copyright@</span><strong> team_undefined</strong>
                </div>
                <div class="logout">
                    <p><a href="logout.php">Logout</a></p>
                </div>
            </section>
        </div>
    </div>
</body>
</html>

