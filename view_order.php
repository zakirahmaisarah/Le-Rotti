<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
	}

	if (isset($_GET['get_id'])) {
		$get_id = $_GET['get_id'];
	}else{
		$get_id = '';
		header('location:order.php');
	}

	if (isset($_POST['cancelled'])) {
		$update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
		$update_order->execute(['cancelled', $get_id]);
		header('location:order.php');
	}


	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website order detail page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>order detail</h1>
			<p>Indulge in the magic of Le Rotti, where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> order detail</span>
		</div>
	</div>


	<!-------------------registration form--------------------->

	<div class="view_order">
		<div class="heading">
			<h1>order detail</h1>
			<img src="image/divider.png">
		</div>

		<div class="box-container">

			<?php
			$grand_total = 0;
			$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
			$select_order->execute([$get_id]);

			if ($select_order->rowCount() > 0) {
				while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
					$select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");

					$select_product->execute([$fetch_order['product_id']]);

					if ($select_order->rowCount() > 0) {
						while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
							$sub_total = ($fetch_order['price']*$fetch_order['quantity']);
							$grand_total += $sub_total;

			?>

			<div class="box">
				<div class="col">
					<img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
					<p class="date"><i class="bx bxs-calendar-alt"></i><?= $fetch_order['date']; ?></p>
					<p class="time"><i class="bx bxs-time"></i><?= $fetch_order['time']; ?></p>

					<div class="detail">
						<p class="price"><?= $fetch_product['price']; ?>X<?= $fetch_order['quantity']; ?></p>
						<h3 class="name"><?= $fetch_product['name'];?></h3>
						<p class="grand-total">total amount payable : <span>RM<?= $grand_total; ?></span></p>
					</div>
				</div>
				<div class="col">
					<p class="title">billing address</p>
					<p class="user"><i class="bx bxs-user-rectangle"></i><?= $fetch_order['name']; ?></p>
					<p class="user"><i class="bx bxs-phone-outgoing"></i><?= $fetch_order['number']; ?></p>
					<p class="user"><i class="bx bxs-envelope"></i><?= $fetch_order['email']; ?></p>
					<p class="user"><i class="bx bxs-map-alt"></i><?= $fetch_order['address']; ?></p>
					<p class="title">status</p>
					<p class="status" style="color:<?php if($fetch_order['status'] == 'delivered'){echo "green";}elseif($fetch_order['status'] == 'canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_order['status']; ?></p>

					<?php if ($fetch_order['status'] == 'cancelled') { ?>
						<a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class= "btn">order again</a>

					<?php }else{ ?>
						<form action="" method="post">
							<button type="submit" name="cancelled" class="btn" onclick="return confirm('do you want to cancelled this product');">cancelled</button>
						</form>

					<?php } ?>

				</div>
			</div>

			<?php

						}
					}
				}
			}else{
				echo ' 
						<div class="empty" >
							<p>no order take placed yet!</p>
						</div>
			';
			}

			?>
			
			

		</div>
		
	</div>












	<?php include 'components/user_footer.php'; ?>

	<!-- sweetalert cdn link -->

	<script src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!-- custom link js -->
	<script type="text/javascript" src="js/user_script.js"></script>
	<!-- alert -->

	<?php include 'components/alert.php'; ?>

</body>
</html>