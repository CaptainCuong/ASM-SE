<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php
	
	if(isset($_POST['do_']) && $_POST['do_'] == "paid_by_cash")
	{
		$order_id = $_POST['order_id'];

        $stmt = $con->prepare("update placed_orders set paid = 1 where order_id = ?;
							   update placed_orders set payment_method = 'cash' where order_id = ?");
        $stmt->execute(array($order_id, $order_id));
	}
	elseif(isset($_POST['do_']) && $_POST['do_'] == "paid_with_paypal")
	{
		$order_id = $_POST['order_id'];

        $stmt = $con->prepare("update placed_orders set paid = 1 where order_id = ?;
							   update placed_orders set payment_method = 'paypal' where order_id = ?");
        $stmt->execute(array($order_id, $order_id));
	}
	elseif(isset($_POST['do_']) && $_POST['do_'] == "order_confirm")
	{
		$order_id = $_POST['order_id'];

        $stmt = $con->prepare("update placed_orders set confirmed = 1 where order_id = ?;");
        $stmt->execute(array($order_id));
	}

?>