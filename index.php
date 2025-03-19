<?php
// index.php

require 'vendor/autoload.php';
use Firebase\JWT\JWT;
require 'config.php';
$error = '';

if (isset($_POST["login"])) {
    // Connect to the database "info_sec_mgmt"
    // Adjust the username and password as needed for your database
    $connect = new PDO("mysql:host=localhost;dbname=info_sec_mgmt;charset=utf8", "root", "");

    // Check if username and password fields are provided
    if (empty($_POST["username"])) {
        $error = 'Please enter a username';
    } else if (empty($_POST["password"])) {
        $error = 'Please enter a password';
    } else {
        // Search for the user in the "users" table
        $query = "SELECT * FROM users WHERE username = ?";
        $statement = $connect->prepare($query);
        $statement->execute([$_POST["username"]]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            // Verify the password (assumes that the password was hashed using password_hash)
            if (password_verify($_POST['password'], $data['password'])) {
                // Secret key for JWT (change this to a secure key)
                $key = 'your_secret_key_here';
                $token = JWT::encode(
                    array(
                        'iat'  => time(),             // Issued at
                        'nbf'  => time(),             // Not before
                        'exp'  => time() + 3600,        // Expiration time (1 hour)
                        'data' => array(
                            'id'       => $data['id'],
                            'name'     => $data['name'],
                            'username' => $data['username']
                        )
                    ),
                    $key,
                    'HS256'
                );
                // Save the token in a cookie for 1 hour
                setcookie("token", $token, time() + 3600, "/", "", true, true);
                header('Location: welcome.php');
                exit;
            } else {
                $error = 'Incorrect password';
            }
        } else {
            $error = 'Incorrect username';
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
    	<title>Login using JWT in PHP</title>
  	</head>
  	<body>
    	<div class="container">
    		<h1 class="text-center mt-5 mb-5">Login using JWT in PHP</h1>
    		<div class="row">
    			<div class="col-md-4"></div>
    			<div class="col-md-4">
    				<?php
    				if ($error !== '') {
    					echo '<div class="alert alert-danger">' . $error . '</div>';
    				}
    				?>
		    		<div class="card">
		    			<div class="card-header">Login</div>
		    			<div class="card-body">
		    				<form method="post">
		    					<div class="mb-3">
			    					<label>Username</label>
			    					<input type="text" name="username" class="form-control" placeholder="Enter username" />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password</label>
			    					<input type="password" name="password" class="form-control" placeholder="Enter password" />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-primary" value="Login" />
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>
  	</body>
</html>
