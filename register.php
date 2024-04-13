<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
	}

	if (isset($_POST['register'])) {
		
		$id = unique_id();
		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);

		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_STRING);

		$pass = sha1($_POST['pass']);
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);

		$cpass = sha1($_POST['cpass']);
		$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

		$image = $_FILES['image']['name'];
		$image = filter_var($image, FILTER_SANITIZE_STRING);
		$ext = pathinfo($image, PATHINFO_EXTENSION);
		$rename = unique_id().'.'.$ext;
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = 'uploaded_files/'.$image;

		$select_user = $conn->prepare("SELECT * FROM `users` WHERE email=?");
		$select_user->execute([$email]);

		if ($select_user->rowCount() > 0) {
			$warning_msg[] = 'email already exists';
		}else{
			if ($pass != $cpass) {
				$warning_msg[] = 'confirm password not matched';
			}else{
				$insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");
				$insert_user->execute([$id, $name, $email, $cpass, $image]);
				move_uploaded_file($image_tmp_name, $image_folder);
				$success_msg[] = 'new user registered! please login now';
			}
		}
	}


	?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- box icon cdn link -->
	<link href="http://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
	<title>Le' Rotti - Bread website register page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>



	<!-------------------registration form--------------------->

	<div class="form-container" style="margin-top: 5rem;">
		<form accept="" method="post" enctype="multipart/form-data" class="register">
			<h3>register now</h3>
			<div class="flex">
				<div class="col">
					<div class="input-field">
						<p>your name<span>*</span></p>
						<input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
					</div>
					<div class="input-field">
						<p>your email<span>*</span></p>
						<input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
					</div>
				</div>
				<div class="col">
					<div class="input-field">
						<p>your password<span>*</span></p>
						<input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
					</div>

					<div class="input-field">
						<p>confirm password<span>*</span></p>
						<input type="password" name="cpass" placeholder="enter your password" maxlength="50" required class="box">
					</div>
				</div>
			</div>
			<div class="input-field">
				<p>select profile</p>
				<input type="file" name="image" accept="image/*" class="box">
			</div>
			<div>
				<p class="link">already have an account ? <a href="login.php">login now</p>
				<input type="submit" name="register" class="btn" value="register now">
			</div>
		</form>
	</div>



	<!-- sweetalert cdn link -->

	<script src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!-- custom link js -->
	<script type="text/javascript" src="js/user_script.js"></script>
	<!-- alert -->

	<?php include 'components/alert.php'; ?>

</body>
</html>