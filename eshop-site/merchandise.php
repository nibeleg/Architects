<?php 
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
          <li class="selected"><a href="merchandise.php">Προϊόντα</a></li>
          <li><a href="contact.html">Επικοινωνία</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="sidebar_container">
	      <canvas id="canvas" width="200" height="200" style="background-color:transparent"></canvas>
      <script>
      var canvas = document.getElementById("canvas");
      var ctx = canvas.getContext("2d");
      var radius = canvas.height / 2;
      ctx.translate(radius, radius);
      radius = radius * 0.90
      setInterval(drawClock, 1000);
      
      function drawClock() {
        drawFace(ctx, radius);
        drawNumbers(ctx, radius);
        drawTime(ctx, radius);
      }
      
      function drawFace(ctx, radius) {
        var grad;
        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, 2*Math.PI);
        ctx.fillStyle = 'white';
        ctx.fill();
        grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
        grad.addColorStop(0, '#333');
        grad.addColorStop(0.5, 'white');
        grad.addColorStop(1, '#333');
        ctx.strokeStyle = grad;
        ctx.lineWidth = radius*0.1;
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
        ctx.fillStyle = '#333';
        ctx.fill();
      }
      
      function drawNumbers(ctx, radius) {
        var ang;
        var num;
        ctx.font = radius*0.15 + "px arial";
        ctx.textBaseline="middle";
        ctx.textAlign="center";
        for(num = 1; num < 13; num++){
          ang = num * Math.PI / 6;
          ctx.rotate(ang);
          ctx.translate(0, -radius*0.85);
          ctx.rotate(-ang);
          ctx.fillText(num.toString(), 0, 0);
          ctx.rotate(ang);
          ctx.translate(0, radius*0.85);
          ctx.rotate(-ang);
        }
      }
      
      function drawTime(ctx, radius){
          var now = new Date();
          var hour = now.getHours();
          var minute = now.getMinutes();
          var second = now.getSeconds();
          
          hour=hour%12;
          hour=(hour*Math.PI/6)+
          (minute*Math.PI/(6*60))+
          (second*Math.PI/(360*60));
          drawHand(ctx, hour, radius*0.5, radius*0.07);
          
          minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
          drawHand(ctx, minute, radius*0.8, radius*0.07);
          
          second=(second*Math.PI/30);
          drawHand(ctx, second, radius*0.9, radius*0.02);
      }
      
      function drawHand(ctx, pos, length, width) {
          ctx.beginPath();
          ctx.lineWidth = width;
          ctx.lineCap = "round";
          ctx.moveTo(0,0);
          ctx.rotate(pos);
          ctx.lineTo(0, -length);
          ctx.stroke();
          ctx.rotate(-pos);
      }
      </script>
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

						<input type="text" name="quantity" value="1" class="form-control" /><br>

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="button" value="Προσθήκη στο καλάθι" />

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
				<td><a href="merchandise.php?action=update&id=<?php echo $values["item_id"]; ?>&item_quantity=<?php echo $values["item_quantity"]; ?>"><span class="text-danger">Ολοκλήρωση παραγγελίας</span></a></td>
				</div>
				<br>
			</div>
    <div id="content_footer"></div>
    <div id="footer">
      <p><a href="index.html">Αρχική</a> | <a href="merchandise.php">Προϊόντα</a> | <a href="contact.html">Επικοινωνία</a></p>
    </div>
  </div>
</body>
</html>
