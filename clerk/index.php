<?php 
	session_start();
	$pageTitle = 'Clerk Login';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		header('Location: dashboard.php');
	}
?>

<!-- PHP INCLUDES -->

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

	<!-- LOGIN FORM -->
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

		<!-- LOGO BUTTON -->

		<div class="login100-pic js-tilt" data-tilt>
			<img src="images/img-01.png" alt="IMG">
		</div>

		<form class="login-container validate-form" name="login-form" action="index.php" method="POST" onsubmit="return validateLoginForm()">
				<span class="login100-form-title">
						Clerk Login
				</span>
					
					<?php

					//Check if user click on the submit button

						if(isset($_POST['admin_login']))
						{
							$username = test_input($_POST['username']);
							$password = test_input($_POST['password']);
							$hashedPass = sha1($password);
							

							//Check if User Exist In database

							$stmt = $con->prepare("Select user_id, username, password from users where username = ? and password = ?");
							$stmt->execute(array($username,$hashedPass));
							$row = $stmt->fetch();
							$count = $stmt->rowCount();

							// Check if count > 0 which mean that the database contain a record about this username

							if($count > 0)
							{

								$_SESSION['username_restaurant_qRewacvAqzA'] = $username;
								$_SESSION['password_restaurant_qRewacvAqzA'] = $password;
								$_SESSION['userid_restaurant_qRewacvAqzA'] = $row['user_id'];
								header('Location: dashboard.php');
								die();
							}
							else
							{
								?>
								<div class="alert alert-danger">
									<button data-dismiss="alert" class="close close-sm" type="button">
													<span aria-hidden="true">×</span>
											</button>
									<div class="messages">
										<div>Username and/or password are incorrect!</div>
									</div>
								</div>
								<?php 
							}
						}
					?>

				<!-- USERNAME INPUT -->

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100" type="text" name="username" placeholder="Username">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
				</div>

				<!-- PASSWORD INPUT -->
		
				<div class="wrap-input100 validate-input" data-validate = "Password is required">
					<input class="input100" type="password" name="password" placeholder="Password">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>

				<!-- SIGNIN BUTTON -->
		
				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="admin_login">
						Login
					</button>
				</div>
				<!-- FORGOT PASSWORD PART -->

				<div class="text-center p-t-12">
					<span class="txt1">
						Forgot 
					</span>
					<a class="txt2" href="resetPassword.php">
						Username / Password?
					</a>
				</div>

			</form>

			<!-- GO BACK HOME -->

			<div class="text-center p-t-136">
				<a class="txt2" href="../index.php">
					Go back homepage
					<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
				</a>
			</div>

		
			</div>
		</div>
	</div>
	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>


