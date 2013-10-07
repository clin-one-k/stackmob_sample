<?php
/*
 * A simple set of functions using StackMob REST library.
 * Chen Lin clin@one-k.com
 * 2013/10/6
 */
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );

// key setup
include ( "key.php" );
include ( "functions.php");
$key = KEY ;
$message = "";
if( !isset( $_POST[ "username" ]) || !isset( $_POST[ "password" ])){
    $message = "mssing username or password.";
    include "login_view.php";
    return;
}

$username = $_POST[ "username" ];
$password = $_POST[ "password" ];

//call login function
$r=user_login( $username, $password );

if($r){
	//login success, forward to main page.
    session_write_close();
    header( "Location: main.php" );
}else{
	//login failed, stay in this page.
    $message = "Login failed.";
    include "login_view.php";
}
?>
