<?php session_start();?>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://static.stackmob.com/js/stackmob-js-0.9.2-bundled-min.js"></script>
<script src="key.js"></script> 
</head>
<body>
<h1>Login Page</h1>
<form name="loginForm" action="login.php" method="POST">
    <br/>Username: <input type="text" name="username" id="username">
    <br/>Password: <input type="password" name="password" id="password">
    <br/><button type="submit">Login</button>
</form>
<p><?php echo $message?></p>
</body>
</html>
<?php 
/*<script>
// use stackMob Javascript function to check if logged in
// Not sure if this is correct, should change to check session
// instead of Javascipt

$(document).ready(function(){
    StackMob.init({
        publicKey: publicKey,
        apiVersion: 0
    });
    StackMob.isLoggedIn({
        yes: function() {
            window.location.href="main.php";
            return;
        },
        no: function() {
            // not logged in 
        }
    });    
});

</script>*/
?>