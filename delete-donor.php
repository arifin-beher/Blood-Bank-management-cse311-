<?php
// Include database connection code and session management here

// Receive the donor ID from the URL parameter
if(isset($_GET['id'])) {
    $donor_id = $_GET['id'];

    // Delete the donor record from the database
    $query = $db->prepare("DELETE FROM donor_reg WHERE id = ?");
    $query->execute([$donor_id]);

    // Redirect to the donor list page after deletion
    header("Location: donor_list.php");
    exit();
}
?>

