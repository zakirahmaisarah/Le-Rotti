<?php
	include '../components/connect.php';

	if (isset($_COOKIE['seller_id'])) {
		$seller_id = $_COOKIE['seller_id'];
	}else{
		$seller_id = '';
		header('location:login.php');
	} 

	//delete product
	if (isset($_POST['delete'])) {
		
		$product_id = $_POST['product_id'];
		$product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

		$delete_image = $conn->prepare("SELECT * FROM `products` WHERE id =? ");
		$delete_image->execute([$product_id]);
		$fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

		if ($fetch_delete_image['image'] != '') {
			unlink('../uploaded_files/'.$fetch_delete_image['image']);
		}

		$delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
		$delete_product->execute([$product_id]);

		$success_msg[] = 'product deleted successfully';
	}
?>


<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website view deactive products page</title>
</head>
<body>

	<?php include '../components/admin_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>view deactive products</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="dashboard.php">admin </a><i class="bx bx-right-arrow-alt " ></i> view deactive products</span>
		</div>
	</div>

	<section class="show_products" style="margin-top: -2rem;">
		<div class="heading ">
			<h1>your products</h1>
			<img src="../image/divider.png">
		</div>
		<div class="box-container">
			<?php

			$select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status = ?");
			$select_deactive_product->execute([$seller_id, 'deactive']);
			$num_of_deactive_product = $select_deactive_product->rowCount();

			if ($select_deactive_product->rowCount() > 0) {
				while ($fetch_products = $select_deactive_product->fetch(PDO::FETCH_ASSOC)) {
			

			?>
			<form action="" method="post" class="box">
				<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
					<?php if ($fetch_products['image'] != '') { ?>
	    				<img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
					<?php } ?>
				<div class="status" style="color: <?php if ($fetch_products['status']=='active') {
					echo "limegreen";} else{echo "red";} ?>"><?= $fetch_products['status']; ?></div>

					<p class="price">/RM<?= $fetch_products['price']; ?>/</p>
					<div class="content">
						<div class="title"><?= $fetch_products['name']; ?></div>
						<div class="flex-btn">
							<a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">edit</a>
							<button type="submit" name="delete" class="btn" onclick="confirm('delete this product');">delete</button>
							<a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">view product</a>
						</div>
					</div>
				</form>
				<?php

					}
			}else{
				echo ' 
						<div class="empty">
							<p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1rem;">add product</a></p>
						</div>
						';
			}


			?>
			
		</div>
	</section>

	<?php include '../components/admin_footer.php'; ?>

	<!-- sweetalert cdn link -->

	<script src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!-- custom link js -->
	<script type="text/javascript" src="../js/admin_script.js"></script>
	<!-- alert -->

	<?php include '../components/alert.php'; ?>

</body>
</html>