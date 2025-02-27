<?php
include_once 'includes/header.php';
include_once 'includes/db_connect.php';

// Fetch existing data
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $removeImage = isset($_POST['remove_image']);
    $imageName = $item['image'];

    // Image handling
    if ($removeImage && $item['image']) {
        if (file_exists("uploads/" . $item['image'])) {
            unlink("uploads/" . $item['image']);
        }
        $imageName = null;
    }

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $uploadDir = 'uploads/';
        $fileName = uniqid() . '_' . basename($image['name']);

        // Validate file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes) && $image['size'] <= 2097152) {
            if (move_uploaded_file($image['tmp_name'], $uploadDir . $fileName)) {
                // Delete old image
                if ($item['image'] && file_exists("uploads/" . $item['image'])) {
                    unlink("uploads/" . $item['image']);
                }
                $imageName = $fileName;
            }
        }
    }

    // Update statement
    $stmt = $conn->prepare("UPDATE items SET name=?, description=?, image=?, price=?, quantity=? WHERE id=?");
    $stmt->bind_param("sssdii", $name, $description, $imageName, $price, $quantity, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . $stmt->error . "</div>";
    }
}
?>

<h2 class="mb-4">Edit Item</h2>

<form action="update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3"
            required><?= htmlspecialchars($item['description']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price"
            value="<?= htmlspecialchars($item['price']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <?php if ($item['image']) : ?>
        <img src="uploads/<?= $item['image'] ?>" class="img-thumbnail mb-2" style="max-width: 150px;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage">
            <label class="form-check-label" for="removeImage">Remove current image</label>
        </div>
        <?php else : ?>
        <span class="text-muted">No image uploaded</span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">New Image</label>
        <input type="file" class="form-control" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Update Item</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include_once 'includes/footer.php'; ?>