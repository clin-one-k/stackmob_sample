<?php
/*
 * Main page
 * 2013/10/07
 */
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );session_start();

// if not loggin, send back to login page
if(!isset($_SESSION['user'])){
    header( "Location: login.php" );
}
?>
<html>
<body>
    <h1>Main page</h1>
    <a href="changeAreacode.php">Edit Area Code</a> | 
    <a href="changePhoto.php">Change Photo</a> | 
    <a href="logout.php">Logout</a>
    <br/>
    Your photo: 
    <div>
        <?php if (isset($_SESSION['photo'])):?>
        	<img src="<?php echo $_SESSION['photo']?>">
        <?php endif;?>
        </div>
    <div>Your name: <?php echo $_SESSION['user'];?></div>
    <div>Your areacode: <?php if(isset($_SESSION['areacode'])) echo $_SESSION['areacode'];?></div>
</body>
</html>