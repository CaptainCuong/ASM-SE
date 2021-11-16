<?php
    ob_start();
	session_start();

	$pageTitle = 'Orders';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

        ?>

            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('orders_link')[0].className += " active_link";

            </script>

        <?php

            
            $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM placed_orders p, clients c
                                        WHERE p.client_id = c.client_id
                                        ORDER BY p.order_id");
                $stmt->execute();
                $orders = $stmt->fetchAll();
            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- ORDERS TABLE -->

                        <table class="table table-bordered orders-table">
                            <thead>
                                <tr>
                                    <th scope="col">Order time</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Delivery address</th>
                                    <th scope="col">Delivered</th>
                                    <th scope="col">Canceled</th>
                                    <th scope="col">Cancellation reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($orders as $order)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $order['order_time'];
                                            echo "</td>";
                                            echo "<td>";
                                ?>
                                            <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo "client_".$order['client_id']; ?>" data-placement="top">
                                                <?php echo $order['client_id']; ?>
                                            </button>

                                            <!-- Client Modal -->

                                            <div class="modal fade" id="<?php echo "client_".$order['client_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Client Details</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul>
                                                                <li><span style="font-weight: bold;">Full name: </span> <?php echo $order['client_name']; ?></li>
                                                                <li><span style="font-weight: bold;">Phone number: </span><?php echo $order['client_phone']; ?></li>
                                                                <li><span style="font-weight: bold;">E-mail: </span><?php echo $order['client_email']; ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                            echo "</td>";
                                            echo "<td>";
                                                echo $order['delivery_address'];
                                            echo "</td>";
                                            echo "<td>";
                                                if($order['delivered'] == 1) echo "Yes";
                                                else echo "No";
                                            echo "</td>";
                                            echo "<td>";
                                                if($order['canceled'] == 1) echo "Yes";
                                                else echo "No";
                                            echo "</td>";
                                            echo "<td>";
                                                echo $order['cancellation_reason'];
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            <?php
            }


        /* FOOTER BOTTOM */

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>