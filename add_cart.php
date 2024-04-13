<?php

	if (isset($_POST['add_to_cart'])) {
		if ($user_id != '') {
			$id = unique_id();
			$product_id = $_POST['product_id'];

			$quantity = $_POST['quantity'];
			$quantity = filter_var($quantity, FILTER_SANITIZE_STRING);

			$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
			$varify_cart->execute([$user_id, $product_id]);

			$max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$max_cart_items->execute([$user_id]);

			if ($varify_cart->rowCount() > 0) {
				$warning_msg[] = 'product already exists in your cart';
			}elseif ($max_cart_items->rowCount() > 20) {
				$warning_msg[] = 'cart is full';
			}else{
				$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
				$select_price->execute([$product_id]);
				$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

				$insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, quantity) VALUES(?,?,?,?,?)");
				$insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $quantity]);
				$success_msg[] = 'product add to cart successfully';
			}
		}else{
			$warning_msg[] = 'please login first';
		}
	}

?>