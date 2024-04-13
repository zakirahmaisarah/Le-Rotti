<header>
	<div class="logo">
		<img src="../image/logo.png" width="170">
	</div>
	<nav class="navbar">
		<a href="dashboard.php">dashboard</a>
		<a href="add_products.php">add product</a>
		<a href="view_products.php">View products</a>
	</nav>
	<div class="right">
		<div class="bx bxs-user" id="user-btn"></div>
		<div class="bx bxs-book-open" id="manual-btn"></div>
		<div class="toogle-btn"></div>
	</div>
	<div class="profile-detail">
		<?php
		$select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
		$select_profile->execute([$seller_id]);

		if ($select_profile->rowCount() > 0) {
			$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

		?>
		<div class="profile">
			<img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
			<p><?= $fetch_profile['name']; ?></p>
		</div>
		<div class="flex-btn">
			<a href="profile.php" class="btn">profile</a>
			<a href="../components/admin_logout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>
		</div>
		<?php } ?>
	</div>
</header>

<script>
	document.getElementById("manual-btn").addEventListener("click", function() {
		window.location.href = "faq_usermanual.php";
	});
</script>
