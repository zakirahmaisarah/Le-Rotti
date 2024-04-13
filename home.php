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
	<title>Le' Rotti - Bread website home page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner_delivery">
		<div class="delivery">
			<h1 style="color: #000; font-size: 34px;">Delivery Time:</h1>
			<h2 style="font-size: 34px;">2.00pm - 6.00pm</h2>
			<h3 style="font-size: 34px;">(Monday - Saturday)</h3>
		</div>
	</div>

	<div class="banner" style="margin-top: 5rem;">
		<div class="detail">
			<h1>Home</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> Home</span>
		</div>
	</div>

	<div class="products">
		<div class="heading">
			<h1>our popular product</h1>
			<img src="image/divider.png">
		</div>
		<?php include 'components/shop.php'; ?>
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