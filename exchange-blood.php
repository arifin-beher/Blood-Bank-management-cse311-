<?php
include('connection.php');
session_start();

// Check if the form is submitted for exchange
if(isset($_POST['sub'])) {
    $requiredBloodGroup = $_POST['ex_bgroup'];
    
    // Check blood is available ?
    $q = $db->prepare("SELECT COUNT(*) as count FROM donor_reg WHERE blood_group = :blood_group");
    $q->bindValue(':blood_group', $requiredBloodGroup);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $availableStock = $row['count'];

    if($availableStock > 0) {
        // If blood is available, proceed with the exchange
        // Your exchange process code here

        // Decrease the stock for the blood group taken
        $updateTakenQuery = $db->prepare("UPDATE donor_reg SET blood_group = NULL WHERE blood_group = :blood_group LIMIT 1");
        $updateTakenQuery->bindValue(':blood_group', $requiredBloodGroup);
        $updateTakenQuery->execute();

        // Increase the stock for the blood group given
        $givenBloodGroup = $_POST['blood_group'];
        $updateGivenQuery = $db->prepare("UPDATE donor_reg SET blood_group = :blood_group WHERE blood_group IS NULL LIMIT 1");
        $updateGivenQuery->bindValue(':blood_group', $givenBloodGroup);
        $updateGivenQuery->execute();

        // Redirect or display success message
        echo "<script>alert('Exchange successful');</script>";
    } else {
        // If blood is not available, display a message
        echo "<script>alert('Sorry, blood not available');</script>";
    }
}

if(isset($_POST['sub'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $blood_group = $_POST['blood_group'];
    $ex_bgroup = $_POST['ex_bgroup'];

    // Prepare and execute the SQL insert query
    $insert_query = $db->prepare("INSERT INTO Ex_bgroup (name, father_name, city, address, age, email, phone_num, blood_group, ex_bgroup) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_query->execute([$name, $father_name, $city, $address, $age, $email, $phone_num, $blood_group, $ex_bgroup]);
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
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <div class="inner-container">
            <!-- Heading -->
            <section class="header">
                <a href="admin-home.php"><h2>Blood Bank Management</h2></a>
            </section>
            
            <!-- Exchange Blood Registration -->
            <section class="body">
                <?php
                echo $un=$_SESSION['un'];
                if(!$un){
                    header("Location:index.php");
                }
                ?>
                <center><h3>Exchange Blood Donor Registration</h3></center>
                <center>
                    <div class="form">
                        <form action="" method="post">
                            <table>
                                <tr>
                                    <td><input type="text" name="name" placeholder="Enter Name"></td>
                                    <td><input type="text" name="father_name" placeholder="Enter Father's Name"></td>
                                    <td><input type="text" name="city" placeholder="Enter City"></td>
                                    <td><textarea name="address" placeholder="Your Address"></textarea></td>
                                    <td><input type="number" name="age" id="" placeholder="Enter Age"></td>
                                    <td><input type="email" name="email" id="" placeholder="Enter Your Email"></td>
                                    <td><input type="number" name="phone_num" id="" placeholder="Enter Your Mobile Number"></td> 
                                    <td>
                                        <select name="blood_group" id="">
                                            <option>Blood Group</option>
                                            <option>O+</option>
                                            <option>O-</option>
                                            <option>A+</option>
                                            <option>A-</option>
                                            <option>B+</option>
                                            <option>B-</option>
                                            <option>AB+</option>
                                            <option>AB-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="ex_bgroup" id="">
                                            <option>Exchange Group</option>
                                            <option>O+</option>
                                            <option>O-</option>
                                            <option>A+</option>
                                            <option>A-</option>
                                            <option>B+</option>
                                            <option>B-</option>
                                            <option>AB+</option>
                                            <option>AB-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button name="sub" id="save-btn" type="submit" value="Save">Submit</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </center>
            </section>


            <!-- Footer -->
            <section class="footer">
                <div class="copyright">
                    <span>Copyright@</span><strong> team_undefined</strong>
                </div>
                <!-- Logout portion -->
                <div class="logout">
                    <p><a href="logout.php">Logout</a></p>
                </div>
            </section>
        </div>
    </div>
</body>
</html>

