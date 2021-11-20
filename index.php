<!-- PHP INCLUDES -->

<?php

    include "connect.php";

?>

<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="css/order_style.css">

	<link href="https://fonts.googleapis.com/css family=Crimson+Text|Work+Sans:400,700" rel="stylesheet">

	<script src="https://kit.fontawesome.com/ee5b22327f.js" crossorigin="anonymous"></script>
</head>
<?php

            if(isset($_POST['submit_order_food_form']) && $_SERVER['REQUEST_METHOD'] === 'POST')
            {
                // Selected Menus

                $selected_menus = $_POST['selected_menus'];

                $con->beginTransaction();
                try
                {
                    $stmtgetCurrentOrderID = $con->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'pos_system' AND TABLE_NAME = 'placed_orders'");
            
                    $stmtgetCurrentOrderID->execute();
                    $order_id = $stmtgetCurrentOrderID->fetch();
                    
                    $stmt_table = $con->prepare("Select table_id from tables");
                    $stmt_table->execute();
                    $table = $stmt_table->fetchAll();
                    
                    $stmt_order = $con->prepare("insert into placed_orders(order_time, client_id, table_id) values(?, ?, ?)");
                    $stmt_order->execute(array(Date("Y-m-d H:i"),$table[0]));

                    foreach($selected_menus as $menu)
                    {
                        $stmt = $con->prepare("insert into in_order(order_id, menu_id, quantity) values(?, ?, ?)");
                        $stmt->execute(array($order_id[0],$menu,____));
                    }
                    
                    echo '<div class = "alert alert-success">';
                        echo 'Great! Your order has been created successfully.';
                    echo '</div>';

                    $con->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    echo '<div class = "alert alert-danger">'; 
                        echo $e->getMessage();
                    echo '</div>';
                }
            }

 ?>

<body>

	<aside>
		<div id="nav">
			<input type="checkbox" id="check">
			<label for="check">
				<i class="fas fa-bars sticky" id="btn"></i>
				<i class="fas fa-times" id="cancel"></i>
			</label>
			<div id="sidemenu">
				<header>My App</header>
				<ul>
					<li><a href="#"><i class="far fa-user-circle fa-lg"></i>Profile</a></li>
					<li><a href="#"><i class="far fa-calendar-minus fa-lg"></i>Menu</a></li>
					<li><a href="#"><i class="fas fa-comment-dots fa-lg"></i>Contact</a></li>
					<li><a href="#"><i class="fas fa-tags fa-lg"></i>Voucher</a></li>
					<li><a href="#"><i class="fas fa-cogs fa-lg"></i>Setting</a></li>
					<li><a href="#"><i class="fas fa-ellipsis-h fa-lg"></i>About</a></li>
				</ul>
			</div>
		</div>
	</aside>

	<section id="promotion">
		<div class="slogan">
			<h1>Restaurant</h1>
			<p>What do you want to eat today ?</p>
		</div>	
	</section>
	<section id="searchbox">
		<div id="search_bar">
			<div class="search_btn">
				<i class="fas fa-search"></i>
			</div>
			<input placeholder="What would you like to eat ?" type="text">
			<div class="filter_btn">
				<i class="fas fa-sliders-h"></i>
			</div>
		</div>

		<div id="category-head">
			<div class="category active" id="all">
				<div class="category_icon">
					<object type="image/svg+xml" data="image/icon/all.svg">
					</object>
				</div>
				<p>All</p>
			</div>
			<div class="category" id="Noodle">
				<div class="category_icon">
					<object type="image/svg+xml" data="image/icon/noodles.svg">
					</object>
				</div>
				<p>Noodle</p>
			</div>
			<div class="category" id="Rice">
				<div class="category_icon">
					<object type="image/svg+xml" data="image/icon/rice-bowl.svg">
					</object>
				</div>
				<p>Rice</p>
			</div>
			<div class="category" id="Soup">
				<div class="category_icon">
					<object type="image/svg+xml" data="image/icon/soup.svg">
					</object>
				</div>
				<p>Soup</p>
			</div>
			<div class="category" id="Dessert">
				<div class="category_icon">
					<object type="image/svg+xml" data="image/icon/ice-cream.svg">
					</object>
				</div>
				<p>Dessert</p>
			</div>
		</div>
	</section>

	<form method="post" id="order_food_form" action="order_food.php">

		<main>
			<div class="item">
				<?php
					$stmt_menu = $con->prepare("Select * from menus");
				    $stmt_menu->execute();
					$rows = $stmt_menu->fetchAll();

					foreach($rows as $row)
					{	
						$stmt_category = $con->prepare("Select category_name from menu_categories where category_id = ?");
				    	$stmt_category->execute(array($row['category_id']));
						$category = $stmt_category->fetch();

						
						$type = $category[0];
						$image = $row['menu_image'];
						$price = $row['menu_price'];
						$name = $row['menu_name'];

						echo '<div class="card all '.$type; echo '">';
							echo '<div class="icon_section">';
								echo '<object type="image/svg+xml" data="image/heart.svg"></object>';
							echo '</div>';
							echo '<div class="image">';
								$source = "image/food_image/".$image;
								echo '<img src= '; echo $source; echo'>';
							echo '</div>';
							echo '<div class="content">';
								echo '<p><strong>'; echo  $price; echo'$</strong></p>';
								echo '<h3>'; echo $name; echo '</h3>';
								echo '<div class="star">';
									echo '<i class="fas fa-star"></i>';
									echo '<i class="fas fa-star"></i>';
									echo '<i class="fas fa-star"></i>';
									echo '<i class="fas fa-star"></i>';
									echo '<i class="fas fa-star"></i>';
								echo '</div>';
							echo '</div>';
						echo '</div>';

					}

				?>
				

			</div>

			<div class="info">

				<?php
					$stmt_menu = $con->prepare("Select * from menus");
				    $stmt_menu->execute();
					$rows = $stmt_menu->fetchAll();

					foreach($rows as $row)
					{
						$id = "info".strval($row['menu_id']);
						echo '<div class="information" id="'; echo $id; echo'">';
							echo '<div class="header_icon">';
								echo '<i class="fas fa-chevron-circle-left fa-2x back_home"></i>';
								echo '<i class="far fa-heart fa-2x heart_info"></i>';
							echo '</div>';

							echo '<div class="main_image">';
								$source = "image/food_image/".$row['menu_image'];
								echo '<img src= '; echo $source; echo'>';
							echo '</div>';

							echo '<div class="top_information">';
								echo '<div class="price">';
									echo '<p><strong>'; echo $row['menu_price']; echo'$</strong></p>';
									echo '<div class="quantity">';
										echo '<span class="minus">-</span>';
										echo '<span class="num">01</span>';
										echo '<span class="plus">+</span>';
									echo '</div>';
								echo '</div>';
								echo '<h1>'; echo $row['menu_name']; echo'</h1>';
								echo '<div class="big_star">';
									echo '<i class="fas fa-star fa"></i>';
									echo '<i class="fas fa-star fa"></i>';
									echo '<i class="fas fa-star fa"></i>';
									echo '<i class="fas fa-star fa"></i>';
									echo '<i class="fas fa-star fa"></i>';
								echo '</div>';
								echo '<p class="description">'; echo $row['menu_description']; echo'</p>';
							echo '</div>';
							
							echo '<div class="option">';
								echo '<h3 class="option_name">Options</h3>';
								echo '<div class="option_list">';
									echo '<div class="topping">';
										echo '<p>Size</p>';
										echo '<div class="quantity">';
											echo '<span class="minus">-</span>';
											echo '<span class="num">01</span>';
											echo '<span class="plus">+</span>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<div class="option_list">';
									echo '<div class="topping">';
										echo '<p>Extra topping</p>';
										echo '<div class="quantity">';
											echo '<span class="minus">-</span>';
											echo '<span class="num">01</span>';
											echo '<span class="plus">+</span>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';

							echo '<div class="Add_to_cart">';
								echo '<button>Add to cart</button>';
							echo '</div>';

							echo '<div class="holder">';
								echo '<div class="round"></div>';
								echo '<div class="rec"></div>';
							echo '</div>';
						echo '</div>';
					}
						
				?>
				

			
		</main>

	</form>

	<section id="cart">
			<div id="right_icon" onclick="openFunction()">
				<p>3</p>
				<div class="order">
					<img src="image/icon/cloche.png">
				</div>
			</div>
			<i class="fas fa-chevron-circle-left fa-2x" id="back" onclick="closeFunction()"></i>
			
			
			<header>My order</header>
			<div class="bill"></div>
			<div class="total">
				<div class="amount">
					<p class="name">Total</p>
					<p class="number"><strong>10$</strong></p>
				</div>
				<div class="coupon_btn">
					<i class="fas fa-ticket-alt"></i>
					<p>Add coupon</p>
				</div>
			</div>
			<div class="confirm">
				<div class="confirm_btn">
					<p><strong>Confirm order</strong></p>
				</div>
			</div>
	</section>
	

<script src="js/order_script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js" integrity="sha512-eP6ippJojIKXKO8EPLtsUMS+/sAGHGo1UN/38swqZa1ypfcD4I0V/ac5G3VzaHfDaklFmQLEs51lhkkVaqg60Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>	
<script>
	
	const open = document.querySelectorAll(".card");
	const close = document.querySelectorAll(".fa-chevron-circle-left.back_home");
	const t1 = [];

	for(let i = 0; i < open.length; i++){
		t1[i] = gsap.timeline();
		t1[i].pause();
	}
	for(let i = 0; i < open.length; i++){
		t1[i].to("#info"+ String(i), {opacity: 1, y:0, scale:1, duration: .3, pointerEvents: 'auto'});
	}

	for(let i = 0; i < open.length; i++){
		open[i].addEventListener('click',function(){
			t1[i].play();
		})
		close[i].addEventListener('click',function(){
			t1[i].reverse();
		})
	}
</script>
</body>