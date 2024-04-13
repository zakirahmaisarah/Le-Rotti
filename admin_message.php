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
	<title>Le' Rotti - Bread website user message page</title>
</head>
<body>

	<?php include '../components/admin_header.php'; ?>

	<div class="banner">
		<div class="detail">
			<h1>user message</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="dashboard.php">admin </a><i class="bx bx-right-arrow-alt " ></i> user message</span>
		</div>
	</div>

	<section class="message-container" style="margin-top: -2rem;">
		<div class="heading ">
			<h1>user message's</h1>
			<img src="../image/divider.png">
		</div>

		<div class="box-container" style="margin-top: -3rem;">
			<?php
			$select_message = $conn->prepare("SELECT * FROM `message`");
			$select_message->execute();

			if ($select_message->rowCount() > 0) {
				while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){

			?>

			<div class="box">
				<h3 class="name"><?= $fetch_message['name']; ?></h3>
				<h4><?= $fetch_message['subject']; ?></h4>
				<p><?= $fetch_message['message']; ?></p>
				<form action="" method="post">
					<input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
					<button type="submit" name="delete" class="btn" onclick="return confirm('delete this message');">delete message</button>
				</form>
			</div>

			<?php 

					}
				}else
				{
					echo '
							<div class="empty" style="margin-top: 2rem;">
								<p>no message</p>
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