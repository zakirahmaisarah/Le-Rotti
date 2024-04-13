<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
	}

	include 'components/add_cart.php';

	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website shop page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>latest products</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> latest products</span>
		</div>
	</div>

	<div class="products">

		<div class="box-container">
	<?php 
	$select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?");

	$select_products->execute(['active']);

	if ($select_products->rowCount() > 0) {
		while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
		
		?>

		<form action="" method="post" class="box" <?php if($fetch_products['stock'] == 0){echo 'disable';} ?>>

			<img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
			<?php if ($fetch_products['stock'] > 9){ ?>
				<span class="stock" style="color:green;">In Stock</span>

			<?php } elseif($fetch_products['stock'] == 0){ ?> <span class="stock" style="color:red;">Out Of Stock</span>

			<?php }else{ ?>
				<span class="stock" style="color:red;">Hurrey Only <?= $fetch_products['stock']; ?> Left</span>

			<?php } ?>

			<p class="price">Price /RM <?= $fetch_products['price'];?>/</p>
			<div class="content">
				<div class="button">
					<div><h3><?= $fetch_products['name']; ?></h3></div>
					<div>
					<button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
					<a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
					</div>
				</div>
				<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
				<div class="flex-btn">
					<input type="number" name="quantity" required min="1" value="1" max="99" maxlength="2" class="quantity" style="width: 100%; text-align: center;">
					

				</div>
			</div>
		</form>

		<?php
		}
	}else{
		echo ' 
						<div class="empty" >
							<p>no products added yet!</p>
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