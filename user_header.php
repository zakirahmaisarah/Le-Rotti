<header class="header">
	<section class="flex">
		<a href="home.php"><img src="image/logo.png" width="130px"></a>
		<nav class="navbar">
			<a href="home.php">home</a>
			<a href="menu.php">shop</a>
			<a href="order.php">my order</a>
			<a href="about.php">about us</a>
		</nav>
		<div class="icons">
			<div id="menu-btn" class="bx bx-list-plus"></div>

			<?php

			$count_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$count_cart_item->execute([$user_id]);
			$total_cart_item = $count_cart_item->rowCount();

			?>
			<a href="cart.php" class="cart-btn"><i class="bx bx-cart"></i><sup><?= $total_cart_item ?></sup></a>
			<div class="bx bxs-user" id="user-btn"></div>
			<div class="bx bxs-book-open" id="manual-btn"></div>
		</div>
		<div class="profile">
			<?php

			$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
			$select_profile->execute([$user_id]);

			if ($select_profile->rowCount() > 0) {
				$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
			
			?>
			<img src="uploaded_files/<?= $fetch_profile['image']; ?>">
			<h3 style="margin-bottom: 1rem"><?= $fetch_profile['name']; ?></h3>
			<div class="flex-btn">
				<a href="profile.php" class="btn">view profile</a>
				<a href="components/user_logout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>
			</div>
		<?php } else{ ?>
			<img src="image/user.png" alt="">
			<h3 style="margin-bottom: 1rem;">please login or register</h3>
			<div class="flex-btn">
				<a href="login.php" class="btn">login</a>
				<a href="register.php" class="btn">register</a>
			</div>
		<?php }?>

	</section>
</header>


<script>
	document.getElementById("manual-btn").addEventListener("click", function() {
		window.location.href = "faq_usermanual.php";
	});
</script>