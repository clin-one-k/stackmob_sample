<?php 
session_start(); //this has to be on the top
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );
include( "key.php" );
include("functions.php");
$str="no file";
$message="";
if(isset($_FILES["photo"])){
   $str=process_photo();
}else{
  $str="no file posted.";
}

?>
<html>
<body>
<h1>Change photo</h1>
<a href="main.php">Back to Main Page</a>
<br/>
Your current photo: 
<?php if (isset($_SESSION['photo'])):?>
	<img src="<?php echo $_SESSION['photo']?>">
<?php endif;?>
<form action="changePhoto.php" method="POST" enctype="multipart/form-data">
	new photo: <input type="file" name="photo" id="photo">
	<button type="submit">change</button>
</form>
<?php echo $message;?>
<?php echo "File: ".$str;?>
</body>
</html>
<?php session_write_close();?>
