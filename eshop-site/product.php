﻿<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "shopdb");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Το προϊόν υπάρχει ήδη στο καλάθι")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Το προϊόν αφαιρέθηκε από το καλάθι")</script>';
				echo '<script>window.location="merchandise.php"</script>';
			}
		}
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "update")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
				unset($_SESSION["shopping_cart"][$keys]);
				header("Location: purchase.php?product_id=".$values["item_id"] . "&product_quantity=".$values["item_quantity"]);
		}
	}
}

?>
<!DOCTYPE HTML>
<html>

<head>
  <title>A R C H I T E C T S</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index.html">Αρχική</a></li>
          <li><a href="merchandise.php">Προϊόντα</a></li>
          <li><a href="contact.html">Επικοινωνία</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="banner"></div>
			<?php
			  $id = $_GET["id"];
				$query = "SELECT * FROM tbl_product WHERE id = $id";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="merchandise.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#494949; border-radius:5px; " align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["name"]; ?></h4>

						<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" /><br>

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Προσθήκη στο καλάθι" />

						<br><br>
					</div>
        </form>
        <br>
			</div>
			<?php
					}
				}
      ?>
      <div style="clear:both"></div>
			<br />
			<h3>Πληροφορίες παραγγελίας</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Ονομασία προϊόντος</th>
						<th width="10%">Ποσότητα</th>
						<th width="20%">Τιμή</th>
						<th width="15%">Σύνολο</th>
						<th width="5%">Διαγραφή προϊόντος</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td>$ <?php echo $values["item_price"]; ?></td>
						<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="merchandise.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Διαγραφή</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Σύνολο</td>
						<td align="right">$ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
					<?php
					}
					?>
						
				</table>
				<div style="text-align: center;">
				<form method="post" action="complete_shoping">
					<div style="border:1px solid #333; background-color:#494949; border-radius:5px; padding:16px;" align="center">
					<td><a href="merchandise.php?action=update&id=<?php echo $values["item_id"]; ?>&item_quantity=<?php echo $values["item_quantity"]; ?>"><span class="text-danger">Ολοκλήρωση παραγγελίας</span></a></td>
				</div>
        </div>
	</div>
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="index.html">Αρχική</a> | <a href="merchandise.php">Προϊόντα</a> | <a href="contact.html">Επικοινωνία</a></p>
    </div>
  </div>
</body>
</html>