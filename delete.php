<?php
include_once 'includes/db_connect.php';

// Add before deletion
$stmt = $conn->prepare("SELECT image FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if ($item['image']) {
    unlink("uploads/" . $item['image']);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}
