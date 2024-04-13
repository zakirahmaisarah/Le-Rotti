<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
	}

	$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
	$select_orders->execute([$user_id]);
	$total_orders = $select_orders->rowCount();

	$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
	$select_cart->execute([$user_id]);
	$total_cart = $select_cart->rowCount();
	


	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website profile page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>profile</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> profile</span>
		</div>
	</div>


	<!-------------------user profile --------------------->

	<section class="profile">
		<div class="heading">
			<h1>profile detail</h1>
			<img src="image/divider.png">
		</div>
		<div class="details">
			<div class="user">
				<img src="uploaded_files/<?= $fetch_profile['image']; ?>">
				<h3><?= $fetch_profile['name']; ?></h3>
				<p>user</p>
				<a href="update.php" class="btn">update profile</a>
			</div>
			
		</div>
	</section>

	












	<?php include 'components/user_footer.php'; ?>

	<!-- sweetalert cdn link -->

	<script src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!-- custom link js -->
	<script type="text/javascript" src="js/user_script.js"></script>
	<!-- alert -->

	<?php include 'components/alert.php'; ?>

</body>
</html>