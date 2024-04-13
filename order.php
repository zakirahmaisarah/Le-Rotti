<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
	}




	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website my order page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>my order</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> my order</span>
		</div>
	</div>


	<!-------------------registration form--------------------->

	<div class="orders">
		<div class="heading">
			<h1>my orders</h1>
			<img src="image/divider.png">
		</div>

		<div class="box-container">
			<?php 

			$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
			$select_orders->execute([$user_id]);

			if ($select_orders->rowCount() > 0) {
				while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
					$product_id = $fetch_orders['product_id'];
					$select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
					$select_products->execute([$fetch_orders['product_id']]);
					if ($select_products->rowCount() > 0) {
						while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

			?>
			<div class="box">
				<a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">

					<img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
					<div class="content">
						<p class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_orders['date']; ?></span></p>
						<p class="time"><i class="bx bxs-time"></i><span><?= $fetch_orders['time']; ?></span></p>
						<div class="row">
							<h3 class="name"><?= $fetch_products['name']; ?></h3>
							<p class="price">/RM<?= $fetch_products['price']; ?>/</p>
							<p class="status" style="color:<?php if($fetch_orders['status'] == 'delivered'){echo "green";}elseif($fetch_orders['status'] == 'canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_orders['status']; ?></p>
						</div>
					</div>
				</a>
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