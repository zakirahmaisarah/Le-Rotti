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
	<title>Le' Rotti - Bread website user manual page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail" style="margin-left: 3rem;">
			<h1>user manual</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> user manual</span>
		</div>
	</div>

	<section class="dashboard" style="margin-top: -2rem;">
		<div class="heading">
			<h1>User Manual</h1>
			<img src="image/divider.png" width="100px">
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 1</h1>
				<h2>Admin registers their account and proceeds to login to enter the website.</h2>
				<div class="image-container">
					<img src="image/registeradmin.png" alt="Register Admin">
					<img src="image/loginadmin.png" alt="Login Admin">
				</div>
			</div>
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 2</h1>
				<h2>After successfully login, users will redirect to home page where they will see the delivery time and popular product of the shop.</h2>
				<img src="image/home.png" alt="Add Product">
			</div>
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 3</h1>
				<h2>If the user want to add the product to their cart, user can hover over the product images and click the cart button.</h2>
				<img src="image/cartuser.png" alt="View Product">
			</div>
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 4</h1>
				<h2>When users click the cart button at navigation bar, prodict details that you add to cart will display.</h2>
				<img src="image/inthecart.png" alt="View Product">
			</div>
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 5</h1>
				<h2>After that user click the checkout button, they will be redirect to checkout page where the product summary and biling details form will display. </h2>
				<div class="image-container">
					<img src="image/summary.png" alt="Register Admin">
					<img src="image/billing.png" alt="Login Admin">
				</div>
			</div>
		</div>

		<div class="user-manual">
			<div class="text">
				<h1>Step 6</h1>
				<h2>After the user successfully place order, they will be redirect to where their payment method is which is cash on delivery or online banking. If the user choose online banking they will be redirect to bank that they preferred and if the user choose cash on delivery they will be redirect to order status page.</h2>
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