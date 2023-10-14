<?php
// Designed by Deep Marsonia.
class login
{
	public $AFTER_LOGIN_SUCCESS_URL = "index.php";

	public $LOGIN_PAGE_URL = "login.php";
	public $conn;
	public $username;
	public $md5password;


	function __construct()
	{
		session_start();
		//setcookie('PHPSESSID', session_id(), time() + (60 * 5), '/');
		$this->conn =  mysqli_connect("127.0.0.1", "root" , "" , "stockmanager") or die("CAN NOT CONNECT TO DB");
	}

	function doLogin($username , $password)
	{
		$this->username = $this->sanitize($username);
		$this->md5password = md5($this->sanitize($password));

		$qry = mysqli_query($this->conn , "SELECT * FROM login WHERE username='$this->username' AND password='$this->md5password'" );

		if(mysqli_num_rows($qry) >=1)
		{
			$_SESSION["isLoggedIn"] = 1;
			$_SESSION["username"] = $username;
			header("Location: $this->AFTER_LOGIN_SUCCESS_URL");
		}
		else{
			header("Location: $this->LOGIN_PAGE_URL?msg=nomatch");
		}
	}

	// TO check if user currenty logged in or not. 
	// Returns 1 if logged in. Ohterwise Redirects to login page.
	function validateLoggedIn()
	{
		if($_SESSION['isLoggedIn'] == 1)
		{
			return 1;
		}
		else
		{
			header("Location: $this->LOGIN_PAGE_URL?msg=loggedout");
		}
	}

	function redirectHomeIfLoggedin()
	{
		if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1)
		{
			header("Location: $this->AFTER_LOGIN_SUCCESS_URL");
		}
		else
		{
			return 0;
		}
	}

	function doLogout()
	{
		$_SESSION['isLoggedIn'] = 0;
		session_destroy();
		//setcookie('PHPSESSID', "", time() -100, '/');
		header("Location: $this->LOGIN_PAGE_URL?msg=loggedout");
	}

	function createUser($username , $password)
	{
		// return 0 if user exists
		// return 1 if everything ok and user created
		// return 2 if username or password length not enough
		
		if(strlen($username) < 5 || strlen($password) <6)
		{
			return 2;
		}

		$qry = mysqli_query($this->conn , "SELECT * FROM login where username='$username'");

		if(mysqli_num_rows($qry) >=1)
		{
			return 0;
		}

		else
		{
			$u = $this->sanitize($username);
			$p = md5($this->sanitize($password));
			$qry = mysqli_query($this->conn , "INSERT into login(username , password) values('$u' , '$p')");

			return 1;
		}

	}

	//Sanitize input form SQL INJECTION or any HTML Escape Strings
	function sanitize($input)
	{
		$output = mysqli_real_escape_string($this->conn, htmlspecialchars($input));
		return $output;
	}



}

?>