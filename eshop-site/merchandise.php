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
				echo '<script>alert("Το προϊόν αφαιρέιηκε από το καλάθι")</script>';
				echo '<script>window.location="merchandise.php"</script>';
			}
		}
	}
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>A R C H I T E C T S - Προϊόντα</title>
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
          <li class="selected"><a href="merchandise.html">Προϊόντα</a></li>
          <li><a href="contact.html">Επικοινωνία</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="sidebar_container">
        <div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
            <!-- insert your sidebar items here -->
            <h3>Τελευταία Νέα</h3>
            <h4>Συναυλίες</h4>
            <h5>Μάιος 21/22/23, 2019</h5>
            <p>Η μπάντα μας θα βρεθεί στον Καναδά στις περιοχές Μόντρεαλ και Τορόντο<br />
          </div>
          <div class="sidebar_base"></div>
        </div>
        <div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
            <h3>Χρήσιμοι Σύνδεσμοι</h3>
            <ul>
              <li><a href="https://el-gr.facebook.com/architectsuk/" target="_blank">Facebook</a></li>
              <li><a href="https://www.instagram.com/architects/?hl=el" target="_blank">Instagram</a></li>
              <li><a href="https://twitter.com/architectsuk?lang=el" target="_blank">Twitter</a></li>
			  <li><a href="https://www.youtube.com/channel/UCdp-kaIi7YO2WmNQ-LafmpA" target="_blank">YouTube</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <?php
				$query = "SELECT * FROM tbl_product ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
                <div class="col-md-4">
				<form method="post" action="merchandise.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#494949; border-radius:5px; padding:16px;" align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<a href="product.php?id=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a>
						
            <h4 class="text-danger">€ <?php echo $row["price"]; ?></h4>
            
            <h4 class="text-danger"><?php echo $row["quantity"]; ?> τεμαχια</h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Προσθήκη στο καλάθι" />

					</div>
        </form>
        <br>
			</div>
			<?php
					}
				}
      ?>