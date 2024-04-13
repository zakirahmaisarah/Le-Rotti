<?php
	include '../components/connect.php';

	if (isset($_COOKIE['seller_id'])) {
		$seller_id = $_COOKIE['seller_id'];
	}else{
		$seller_id = '';
		header('location:login.php');
	} 

	//delete message from database
	if (isset($_POST['delete'])) {
		$delete_id = $_POST['delete_id'];
		$delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

		$verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ? ");
		$verify_delete->execute([$delete_id]);

		if ($verify_delete->rowCount() > 0) {
			
			$delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
			$delete_message->execute([$delete_id]);

			$select_message[] = 'message deleted';
		}else{
			$warning_msg[] = 'message already deleted';
		}
	}
	
?>


<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website registered user page</title>
</head>
<body>

	<?php include '../components/admin_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>registered admins</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="dashboard.php">admin </a><i class="bx bx-right-arrow-alt " ></i> registered admins</span>
		</div>
	</div>

	<section class="seller-container" style="margin-top: -2rem;">
		<div class="heading ">
			<h1>registered admins</h1>
			<img src="../image/divider.png">
		</div>
		<div class="box-container">
			<?php
			$select_sellers = $conn->prepare("SELECT * FROM `sellers`");
			$select_sellers->execute();

			if ($select_sellers->rowCount() > 0) {
				while($fetch_seller = $select_sellers->fetch(PDO::FETCH_ASSOC)){
					$user_id = $fetch_seller['id'];
			?>

			<div class="box">
				<img src="../uploaded_files/<?= $fetch_seller['image']; ?>">
				<div class="detail">
					<p>seller id : <span> <?= $seller_id; ?></span></p>
					<p>seller name : <span> <?= $fetch_seller['name']; ?></span></p>
					<p>seller email : <span> <?= $fetch_seller['email']; ?></span></p>
				</div>
			</div>

			<?php

						}
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