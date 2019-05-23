<?php
$conn = mysqli_connect("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$product_id = $_GET['product_id']; 
$product_quantity = $_GET['product_quantity'];
$sql = "SELECT quantity FROM tbl_product WHERE id = '$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$updated_quantity = $row["quantity"] - $product_quantity;
$sql = "UPDATE tbl_product SET quantity = '$updated_quantity' WHERE id = '$product_id'";
$result = $conn->query($sql);
header("Location: merchandise.php");
$conn->close();
?>