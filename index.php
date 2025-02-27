<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/db_connect.php'; ?>

<div class="mb-4">
    <h1>Online Store Inventory</h1>
    <a href="create.php" class="btn btn-success">Add New Item</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM items";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) :
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <?php if ($row['image']) : ?>
                        <img src="uploads/<?= $row['image'] ?>" class="item-image img-thumbnail">
                    <?php else : ?>
                        <span class="text-muted">No image</span>
                    <?php endif; ?>
                </td>
                <td><?= $row['description'] ?></td>
                <td>₦<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>
                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include_once 'includes/footer.php'; ?>