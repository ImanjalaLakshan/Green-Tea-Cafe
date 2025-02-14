<?php
include 'components/connection.php';
session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $id = unique_id();  
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0) {
        $message[] = 'email already exists';
        echo 'email already exists';
    } else {
        if($pass != $cpass){
            $message[] = 'Passwords do not match. Please confirm your password.';
            echo 'Passwords do not match. Please confirm your password';
        } else {
          
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email, password) VALUES (?, ?, ?, ?)");
            $insert_user->execute([$id, $name, $email, $hashed_pass]);
            header('location: home.php');
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_user->execute([$email]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            if($select_user->rowCount() > 0) {
               
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];

              
                header('Location: home.php');
                exit;
            }
        }
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
	<title>Green Tea Cafe -register now</title>
</head>
<body>
	<div class="form-container">
		<div class="title">
			<img src="img/download.png">
			<h1>register now</h1>
			<p>****************************************</p>
		</div>
		<form action="" method="post">
			<div class="input-field">
				<p>your name </p>
				<input type="text" name="name" required placeholder="enter your name" maxlength="50">
			</div>
			<div class="input-field">
				<p>your email </p>
				<input type="email" name="email" required placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="input-field">
				<p>your password </p>
				<input type="password" name="pass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<div class="input-field">
				<p>confirm password </p>
				<input type="password" name="cpass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
			</div>
			<input type="submit" name="submit" value="register now" class="btn">
			<p>already have an account?</p><a href="login.php">login now</a>
		</form>
	</div>
	<script type="components/sweetalert.js"></script>
	<script type="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>