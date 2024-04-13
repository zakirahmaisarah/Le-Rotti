<div class="box-container">
	<?php 
	$select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ? LIMIT 6");

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
<div class="more">
	<a href="menu.php" class="btn">load more</a>
</div>