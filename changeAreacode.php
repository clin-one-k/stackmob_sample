<?php 
session_start(); //this has to be on the top
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );

if(!isset($_SESSION['user'])){
    header( "Location: login.php" );
}

include( "key.php" );
include("functions.php");
$message="";
if(isset($_POST['areacode'])){
	if(update_areacode($_POST['areacode'])){
		$mesg="Update success.";
	}else{
		$mesg="Update failed.";
	}
}
?>
<html>
<body>
<h1>Change area code</h1>
<a href="main.php">Back to Main Page</a>
<br/>
Your current area code: <?php echo $_SESSION['areacode'];?>
<form action="changeAreacode.php" method="POST">
	new area code: <input type="text" name="areacode" value="<?php echo $_SESSION['areacode'];?>">
	<button type="submit">change</button>
</form>
<?php echo $message;?>
</body>
</html>
<?php session_write_close();?>