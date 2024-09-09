<?php
include 'components/connection.php';
session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0) {
               
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];

              
                header('Location: home.php');
               
            }
            else{
            	$massage[] = 'incorrect username or password';
            }
}

?>

<style type="text/css">
<?php include 'style.css'; ?>	
</style>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Green Tea Cafe -login now</title>
</head>
<body>
	<div class="form-container">
		<div class="title">
			<img src="img/download.png">
			<h1>login now</h1>
			<p>****************************************</p>
		</div>
		<form action="" method="post">	
			<div class="input-field">
				<p>your email </p>
				<input type="email" name="email" required placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="input-field">
				<p>your password </p>
				<input type="password" name="pass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<input type="submit" name="submit" value="login now" class="btn">
			<p>do not have an account?</p><a href="register.php">register now</a>
		</form>
	</div>
	<script type="components/sweetalert.js"></script>
	<script type="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>