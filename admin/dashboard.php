<?php
	
	//Start session
    session_start();

    //Set page title
    $pageTitle = 'Dashboard';

    //PHP INCLUDES
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php';

    //TEST IF THE SESSION HAS BEEN CREATED BEFORE

    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
    {
    	include 'Includes/templates/navbar.php';

    	?>

            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";

            </script>

            <!-- TOP 4 CARDS -->

            <div class="row">
                <!--
                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-green ">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php //echo countItems("client_id","clients")?></span></div>
                                    <div>Total Clients</div>
                                </div>
                            </div>
                        </div>
                        <a href="clients.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                -->
                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-utensils fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php echo countItems("menu_id","menus")?></span></div>
                                    <div>Total Menus</div>
                                </div>
                            </div>
                        </div>
                        <a href="menus.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class=" col-sm-6 col-lg-3">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="far fa-calendar-alt fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span>32</span></div>
                                    <div>Total Appointments</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class=" col-sm-6 col-lg-3">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-pizza-slice fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php echo countItems("order_id","placed_orders")?></span></div>
                                    <div>Total Orders</div>
                                </div>
                            </div>
                        </div>
                        <a href="orders.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- START ORDERS TABS -->

            <div class="card">

                <!-- TABS BUTTONS -->

                <div class="card-header tab" style="padding:0px;">
                    <!--
                    <button class="tablinks_orders active" onclick="openTab(event, 'preorders','tabcontent_orders','tablinks_orders')">Confirm order</button>
                    <button class="tablinks_orders" onclick="openTab(event, 'recent_orders','tabcontent_orders','tablinks_orders')">Confirm payment</button>
                    -->
                    <button class="tablinks_orders active" onclick="openTab(event, 'completed_orders','tabcontent_orders','tablinks_orders')">Paid Orders</button>
                </div>

                <!-- TABS CONTENT -->
                
                <div class="card-body">
                    <div class='responsive-table'>

                        <!-- CONFIRM PAYMENT -->

                        <table class="table X-table tabcontent_orders" id="preorders" style="display:table">
                            <thead>
                                <tr>
                                    <th>
                                        Order Time Created
                                    </th>
                                    <th>
                                        Total Price
                                    </th>
                                    <th>
                                        Table
                                    </th>
                                    <th>
                                        Confirm order
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , tables t
                                                    WHERE
                                                        po.table_id = t.table_id
                                                    AND po.confirmed = 0
                                                    ORDER BY order_time;
                                                    ");
                                    $stmt->execute();
                                    $placed_orders = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    
                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your recent orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($placed_orders as $order)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $order['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $order['total'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $order['table_id'];
                                                echo "</td>";

                                                $order_data = "confirm_order".$order["order_id"];
                                                echo "<td>";
                                                ?>
                                                <ul class="list-inline m-0">

                                                    <!-- Confirm PayPal Payment BUTTON -->
                                                    
                                                    <li class="list-inline-item" data-toggle="tooltip" title="Confirm order">
                                                        <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $order_data; ?>" data-placement="top">
                                                            <i class="fas fa-truck"></i>
                                                        </button>

                                                        <!-- CONFIRM MODAL -->
                                                        <div class="modal fade" id="<?php echo $order_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $order_data; ?>" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm order</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Confirm this order and send to the kitchen?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        <button type="button" data-id = "<?php echo $order['order_id']; ?>" class="btn btn-info order_confirm">
                                                                            Yes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                </ul>
                                                <?php
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- CONFIRM PAYMENT -->

                        <table class="table X-table tabcontent_orders" id="recent_orders">
                            <thead>
                                <tr>
                                    <th>
                                        Order Time Created
                                    </th>
                                    <th>
                                        Total Price
                                    </th>
                                    <th>
                                        Table
                                    </th>
                                    <th>
                                        Confirm PayPal payment
                                    </th>
                                    <th>
                                        Confirm cash payment
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , tables t
                                                    WHERE
                                                        po.table_id = t.table_id
                                                    AND po.confirmed = 1
                                                    AND po.paid = 0
                                                    ORDER BY order_time;
                                                    ");
                                    $stmt->execute();
                                    $placed_orders = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    
                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your recent orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($placed_orders as $order)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $order['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $order['total'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $order['table_id'];
                                                echo "</td>";

                                                $paypal_data = "pay_with_paypal".$order["order_id"];
                                                $cash_data = "pay_by_cash".$order["order_id"];
                                                echo "<td>";
                                                ?>
                                                <ul class="list-inline m-0">

                                                    <!-- Confirm PayPal Payment BUTTON -->
                                                    
                                                    <li class="list-inline-item" data-toggle="tooltip" title="PayPal payment">
                                                        <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $paypal_data; ?>" data-placement="top">
                                                            <i class="fas fa-truck"></i>
                                                        </button>

                                                        <!-- CONFIRM MODAL -->
                                                        <div class="modal fade" id="<?php echo $paypal_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $paypal_data; ?>" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm payment</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Mark order as paid with PayPal?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        <button type="button" data-id = "<?php echo $order['order_id']; ?>" class="btn btn-info paid_with_paypal_confirm">
                                                                            Yes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                </ul>
                                                <?php
                                                echo "</td>";
                                                echo "<td>";
                                                    ?>
                                                    <ul class="list-inline m-0">

                                                        <!-- Confirm Cash Payment BUTTON -->
                                                        
                                                        <li class="list-inline-item" data-toggle="tooltip" title="Cash payment">
                                                            <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $cash_data; ?>" data-placement="top">
                                                                <i class="fas fa-truck"></i>
                                                            </button>

                                                            <!-- CONFIRM MODAL -->
                                                            <div class="modal fade" id="<?php echo $cash_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $cash_data; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Confirm payment</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Mark order as paid by cash?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                            <button type="button" data-id = "<?php echo $order['order_id']; ?>" class="btn btn-info paid_by_cash_confirm">
                                                                                Yes
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                    <?php
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- COMPLETED ORDERS -->

                        <table class="table X-table tabcontent_orders" id="completed_orders">
                            <thead>
                                <tr>
                                    <th>
                                        Order Time Created
                                    </th>
                                    <th>
                                        Total price
                                    </th>
                                    <th>
                                        Table
                                    </th>
                                    <th>
                                        Payment method
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , tables t
                                                    WHERE 
                                                        po.table_id = t.table_id
                                                        AND
                                                        po.paid = 1
                                                    ORDER BY order_time;
                                                    ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your completed orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['total'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['table_id'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['payment_method'];
                                                echo "</td>";
                                                
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- CANCELED ORDERS -->
                        <!--
                        <table class="table X-table tabcontent_orders" id="canceled_orders">
                            <thead>
                                <tr>
                                    <th>
                                        Order Time Created
                                    </th>
                                    <th>
                                        Table
                                    </th>
                                    <th>
                                        Cancellation Reason
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    /*
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , tables t
                                                    where 
                                                        po.table_id = t.table_id
                                                    and 
                                                        paid = 0
                                                    order by order_time;
                                                    ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your canceled orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['table_id'];
                                                echo "</td>";
                                                echo "<td>";
                                                    
                                                    echo $row['cancellation_reason'];
                                                        
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    */
                                ?>

                            </tbody>
                        </table>
                        -->
                    </div>
                </div>
            </div>

            <!-- END ORDERS TABS -->

        <?php

    	include 'Includes/templates/footer.php';

    }
    else
    {
    	header("Location: index.php");
    	exit();
    }

?>

<!-- JS SCRIPTS -->

<script type="text/javascript">
    
    // WHEN DELIVER ORDER BUTTON IS CLICKED

    $('.paid_by_cash_confirm').click(function()
    {

        var order_id = $(this).data('id');
        var do_ = 'paid_by_cash';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data:{do_:do_,order_id:order_id,},
            success: function (data) 
            {
                $('#deliver_order'+order_id).modal('hide');
                swal("Order Paid","The order has been marked as paid by cash", "success").then((value) => 
                {
                    window.location.replace("dashboard.php");
                });
                
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
          });
    });

    // WHEN CANCEL ORDER BUTTON IS CLICKED

    $('.paid_with_paypal_confirm').click(function()
    {

        var order_id = $(this).data('id');
        var do_ = 'paid_with_paypal';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data:{do_:do_,order_id:order_id,},
            success: function (data) 
            {
                $('#deliver_order'+order_id).modal('hide');
                swal("Order Paid","The order has been marked as paid with paypal", "success").then((value) => 
                {
                    window.location.replace("dashboard.php");
                });
                
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
          });
    });

    $('.order_confirm').click(function()
    {

        var order_id = $(this).data('id');
        var do_ = 'order_confirm';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data:{do_:do_,order_id:order_id,},
            success: function (data) 
            {
                $('#deliver_order'+order_id).modal('hide');
                swal("Order Confirmed","The order has been confirmed and sent to the kitchen", "success").then((value) => 
                {
                    window.location.replace("dashboard.php");
                });
                
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
          });
    });

</script>