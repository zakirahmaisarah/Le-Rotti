<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
	}


	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website about us page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>about us</h1>
			<p>Indulge in the magic of Le Rotti,<br> where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> about us</span>
		</div>
	</div>


	<!------------------about us--------------------->

	<div class="who">
		<div class="box-container">
			<div class="heading" style="margin-top: 3rem;">
				<h1>about us</h1>
				<img src="image/divider.png">
			</div>
		</div>

		<div class="form-container">
			<div class="about-text">
        <p>Le' Rotti is a bakery that offers a variety of bread with diverse shapes, flavors, <br>and distinctive names for each menu item. Situated in Puncak Alam, Selangor, 
            <br>Le' Rotti takes pride in its unique selection, ensuring a delightful experience for 
            <br>customers. The establishment prides itself on crafting bread with distinct tastes 
            <br>and aesthetically pleasing designs. Explore the rich variety of options available, <br>each infused with unique flavors and complemented by creative nomenclature. 
            <br>Nestled in the heart of Puncak Alam, Selangor, Le' Rotti is not just a bakery, it's <br>an experience of indulgence and culinary craftsmanship.</p>
            <img src="image/logo.png">
    </div>

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