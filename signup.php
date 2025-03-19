<?php
// signup.php

require 'config.php';

$error = '';
$message = '';

if (isset($_POST["signup"])) {
    // Validate input fields
    if (empty($_POST["name"])) {
        $error = 'Please enter your full name';
    } else if (empty($_POST["username"])) {
        $error = 'Please enter a username';
    } else if (empty($_POST["password"])) {
        $error = 'Please enter a password';
    } else {
        // Check if the username already exists in the "users" table
        $query = "SELECT * FROM users WHERE username = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$_POST["username"]]);
        if ($statement->rowCount() > 0) {
            $error = 'Username already exists. Please choose another one.';
        } else {
            // Hash the password
            $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            
            // Insert the new user into the "users" table
            $query = "INSERT INTO users (name, username, password) VALUES (?, ?, ?)";
            $statement = $pdo->prepare($query);
            if ($statement->execute([$_POST["name"], $_POST["username"], $hashed_password])) {
                $message = 'Registration successful. You can now log in.';
            } else {
                $error = 'Error during registration. Please try again.';
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<title>Sign Up using PHP</title>
</head>
<body>
	<div class="container">
		<h1 class="text-center mt-5 mb-5">Sign Up</h1>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<?php
				if ($error !== '') {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
				if ($message !== '') {
					echo '<div class="alert alert-success">' . $message . '</div>';
				}
				?>
				<div class="card">
					<div class="card-header">Sign Up</div>
					<div class="card-body">
						<form method="post">
							<div class="mb-3">
								<label>Full Name</label>
								<input type="text" name="name" class="form-control" placeholder="Enter your full name" required />
							</div>
							<div class="mb-3">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Enter a username" required />
							</div>
							<div class="mb-3">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Enter a password" required />
							</div>
							<div class="text-center">
								<input type="submit" name="signup" class="btn btn-primary" value="Sign Up" />
							</div>
						</form>
						<p class="mt-3 text-center">Already have an account? <a href="index.php">Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
