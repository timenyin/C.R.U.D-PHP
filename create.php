<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/db_connect.php'; ?>

<h2 class="mb-4">Add New Item</h2>

<form action="create.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" required>
    </div>

    <!-- Add image upload field -->
    <div class="mb-3">
        <label class="form-label">Item Image</label>
        <input type="file" class="form-control" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Add Item</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // File upload handling
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $uploadDir = 'uploads/';
        $fileName = uniqid() . '_' . basename($image['name']);
        $targetPath = $uploadDir . $fileName;

        // Validate file type and size
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes) && $image['size'] <= 2097152) {
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imageName = $fileName;
            }
        }
    }

    // Single prepare statement
    $stmt = $conn->prepare("INSERT INTO items (name, description, image, price, quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $name, $description, $imageName, $price, $quantity);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<?php include_once 'includes/footer.php'; ?>