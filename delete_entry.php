<?php
include('connection.php');

// Check if the delete_id parameter is set and it's a valid integer
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Prepare and execute the delete query
    $delete_query = $db->prepare("DELETE FROM Ex_bgroup WHERE id = :id");
    $delete_query->bindValue(':id', $delete_id, PDO::PARAM_INT);
    if ($delete_query->execute()) {
        // Redirect back to the exchange blood list page after successful deletion
        header("Location: exchange-blood-list.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        // Handle deletion failure (optional)
        echo "Failed to delete entry.";
    }
}
?>

