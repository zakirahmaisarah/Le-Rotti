<?php
include '../components/connect.php';

// Redirect to login page if seller_id is not set
if (!isset($_COOKIE['seller_id'])) {
    header('location: login.php');
    exit; // Stop further execution
}

$seller_id = $_COOKIE['seller_id'];

// Update order status from database
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_status = $_POST['update_status'];

    $update_sta = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_sta->execute([$update_status, $order_id]);

    $success_msg[] = 'Order status updated';
}

// Update payment status from database
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_pay->execute([$update_payment, $order_id]);

    $success_msg[] = 'Order payment status updated';
}


// Delete order
if (isset($_POST['delete_order'])) {
    $delete_id = $_POST['order_id'];

    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);

    $success_msg[] = 'Order deleted';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">
    <title>Le' Rotti - Bread website user order page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Order detail</h1>
            <p>Indulge in the magic of Le Rotti,<br>where the aroma of freshly baked bread is a prelude to a taste adventure.</p>
            <span><a href="dashboard.php">Admin </a><i class="bx bx-right-arrow-alt"></i> User Order</span>
        </div>
    </div>

    <section class="order-container">
        <div class="heading">
            <h1>Total orders placed</h1>
            <img src="../image/divider.png" alt="Divider">
        </div>

        <div class="box-container">
            <?php
            $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
            $select_order->execute([$seller_id]);

            if ($select_order->rowCount() > 0) {
                while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box">
                <div class="detail">
                  
					<p>user name : <span><?= $fetch_order['name']; ?></span></p>
					<p>user id : <span><?= $fetch_order['user_id']; ?></span></p>
					<p>product id : <span><?= $fetch_order['product_id']; ?></span></p>
					<p>placed on : <span><?= $fetch_order['date']; ?></span></p>
					<p>placed on : <span><?= $fetch_order['time']; ?></span></p>
					<p>number : <span><?= $fetch_order['number']; ?></span></p>
					<p>email : <span><?= $fetch_order['email']; ?></span></p>
					<p>total price : <span><?= $fetch_order['price']; ?></span></p>
					<p>payment method : <span><?= $fetch_order['method']; ?></span></p>
					<p>address : <span><?= $fetch_order['address']; ?></span></p>
                </div>


                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                    <input type="hidden" name="update_status" value="<?= $fetch_order['status']; ?>">
                    <input type="hidden" name="update_payment" value="<?= $fetch_order['payment_status']; ?>">
                    
                    <div>
                        <p>Status</p>
                        <select name="update_status" class="box" style="width: 90%;">
                            <option disabled selected><?= $fetch_order['status']; ?></option>
                            <option value="in progress">In Progress</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <div>
                        <p>Payment</p>
                        <select name="update_payment" class="box" style="width: 90%;">
                            <option disabled selected><?= $fetch_order['payment_status']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>

                    <div class="flex-btn">
                        <button type="submit" name="update_order" class="btn">Update</button>
                        <button type="submit" name="delete_order" class="btn">Delete Order</button>
                    </div>
                </form>
            </div>
            <?php
                }
            } else {
                echo '<div class="empty"><p>No orders placed yet!</p></div>';
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
