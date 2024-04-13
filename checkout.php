<?php
	include 'components/connect.php';

	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'home.php';
	}
	
	if (isset($_POST['place_order'])) {
	if ($user_id != '') {
			$id = unique_id();

			$name = $_POST['name'];
			$name = filter_var($name, FILTER_SANITIZE_STRING);

			$email = $_POST['email'];
			$email = filter_var($email, FILTER_SANITIZE_STRING);

			$number = $_POST['number'];
			$number = filter_var($number, FILTER_SANITIZE_STRING);

			$address = $_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['country'].', '.$_POST['pin'];
			$address = filter_var($address, FILTER_SANITIZE_STRING);

			$address_type = $_POST['address_type'];
			$address_type = filter_var($address_type, FILTER_SANITIZE_STRING);

			$method = $_POST['method'];
			$method = filter_var($method, FILTER_SANITIZE_STRING);

			$bank_name = $_POST['bank_name'];
			$bank_name = filter_var($bank_name, FILTER_SANITIZE_STRING);

			// Define an array mapping bank names to their respective URLs
            $bank_urls = [
            	'none' => '../order.php',
                'maybank2U' => 'https://www.maybank2u.com.my/home/m2u/common/login.do',
                'bank islam' => 'https://www.bankislam.biz/',
                'cimb bank' => 'https://www.cimbclicks.com.my/clicks/#/',
                'agroBank' => 'https://www.agronet.com.my/rib/common/Login.do/'];

			$verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$verify_cart->execute([$user_id]);

			if (isset($_GET['get_id'])) {
				$get_product = $conn("SELECT * FROM `products` WHERE id = ? LIMIT 1");
				$get_product->execute([$_GET['get_id']]);

				if ($get_product->rowCount() > 0) {
					while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
						$seller_id = $fetch_p['seller_id'];
						$insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, bank_name, product_id, price, quantity) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
						$insert_order->execute([$id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $bank_name, $fetch_p['id'], $fetch_p['price'], 1]);
						header("location:order.php");
					}
				}else{
					$warning_msg[] = 'something went wrong';
				}
			}elseif ($verify_cart->rowCount() > 0) {
				while($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)){
					$s_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
					$s_products->execute([$f_cart['product_id']]);
					$f_product = $s_products->fetch(PDO::FETCH_ASSOC);

					$seller_id = $f_product['seller_id'];

					$insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, bank_name, product_id, price, quantity) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
						$insert_order->execute([$id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $bank_name, $f_cart['product_id'], $f_cart['price'], $f_cart['quantity']]);
						 header("Location: " . $bank_urls[$bank_name]);
				}
				if ($insert_order) {
					$delete_cart_id = $conn->prepare("SELECT FROM `cart` WHERE user_id = ?");
					$delete_cart_id->execute([$user_id]);
					header('location:order.php');
				}
			}else{
				$warning_msg[] = 'something went wrong';
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
	<title>Le' Rotti - Bread website checkout page</title>
</head>
<body>

	<?php include 'components/user_header.php'; ?>
	

	<div class="banner">
		<div class="detail">
			<h1>checkout</h1>
			<p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
			<span><a href="home.php">home </a><i class="bx bx-right-arrow-alt " ></i> checkout</span>
		</div>
	</div>


	<!-------------------product detail--------------------->

	<section class="checkout">
		<div class="heading">
			<h1>checkout summary</h1>
			<img src="image/divider.png">
		</div>

		<div class="row">
			<div class="form-container">
			<form action="" method="post" class="register">
				<input type="hidden" name="p_id" value="<?= $get_id; ?>">
				<h3>billing details</h3>
				<div class="flex">
					<div class="col">
						<div class="input-field">
							<p>your name<span>*</span></p>
							<input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>your number<span>*</span></p>
							<input type="number" name="number" placeholder="enter your number" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>your email<span>*</span></p>
							<input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>payment status<span>*</span></p>
							<select name="method" class="box" style="text-transform: capitalize;">
								<option value="cash on delivery">cash on delivery</option>
								<option value="online banking">online banking</option>
							</select>
						</div>
						<div class="input-field">
							<p>bank type (online banking only)<span>*</span></p>
							<select name="bank_name" class="box" style="text-transform: capitalize;">
								<option value="none">none</option>
								<option value="maybank2U">maybank2U</option>
								<option value="bank islam">bank islam</option>
								<option value="bank islam">cimb bank</option>
								<option value="agroBank">agroBank</option>
							</select>
						</div>
						<div class="input-field" c>
							<p>address type<span>*</span></p>
							<select name="address_type" class="box" style="text-transform: capitalize;">
								<option value="home">home</option>
								<option value="office">office</option>
							</select>
						</div>
					</div>
					<div class="col">
						<div class="input-field">
							<p>address line 01<span>*</span></p>
							<input type="text" name="flat" placeholder="e.g flat and building" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>address line 01<span>*</span></p>
							<input type="text" name="street" placeholder="e.g street name" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>city name<span>*</span></p>
							<input type="text" name="city" placeholder="enter your city name" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>country name<span>*</span></p>
							<input type="text" name="country" placeholder="enter your country name" maxlength="50" required class="box">
						</div>
						<div class="input-field">
							<p>poscode<span>*</span></p>
							<input type="number" name="pin" placeholder="110099" maxlength="6" required class="box">
						</div>
					</div>
				</div>
				<button type="submit" name="place order" class="btn">place order</button>
			</form>
			</div>

			<div class="summary">
				<h3>my bag</h3>
				<div class="box-container">

					<?php
					$grand_total = 0;
					if (isset($_GET['get_id'])) {
						$select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
						$select_get->execute([$_GET['get_id']]);

						while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
							$sub_total = $fetch_get['price'];
							$grand_total+= $sub_total;

					?>
					<div class="flex">
						<img src="uploaded_files/<?= $fetch_get['image']; ?>" class="image">
					<div>
						<h3 class="name"><?= $fetch_get['name']; ?></h3>
						<p class="price">/RM<?= $fetch_get['price']; ?>/</p>
					</div>
				</div>
				<?php
							}
						}else{
							$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
							$select_cart->execute([$user_id]);

							if ($select_cart->rowCount() > 0) {
								while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
									$select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
									$select_products->execute([$fetch_cart['product_id']]);
									$fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
									$sub_total = ($fetch_cart['quantity'] * $fetch_product['price']);
									$grand_total+= $sub_total;
		

					?>

					<div class="flex">
						<img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
					<div>
						<h3 class="name"><?= $fetch_product['name']; ?></h3>
						<p class="price">RM<?= $fetch_product['price']; ?> X <?= $fetch_cart['quantity']; ?></p>
					</div>
				</div>

				<?php
							}
						}else{
							echo ' 
								<div class="empty" >
									<p>no products added yet!</p>
								</div>
							';

						}
					}
				?>

				</div>
				<div class="grand-total"><span>total amount : </span>RM <?= $grand_total; ?></div>
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