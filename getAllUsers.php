<?php
// for debug
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );

// key setup
include( "key.php" );
$key = KEY ;

// error message
$error_message = "";

// prepare for command-line URL tool
$curl = curl_init ( "http://api.stackmob.com/user" );
curl_setopt ( $curl, CURLOPT_HEADER, true );
curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
    "Accept: application/vnd.stackmob+json; version=0",
    "X-stackMob-API-Key: ".$key
    )
);

// run crul
$response = curl_exec ( $curl );

// process return
//$j=json_decode(curl_exec($curl),true);
$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ( !$response && $statusCode !== 200 ) {
     $response = curl_error ( $curl );
     curl_close ( $curl );
     $error_message="curl failed.";
} else {
    list( $header, $body ) = explode ( "\r\n\r\n", $response, 2 );
    $_response = $body;
    $_results = null;
    $decoded = json_decode ( $body );
}
curl_close ( $curl );

?>
<h1>Get all usrs</h1>
<p>Use REST for PHP to retrieve all the user from stackMob. 
    https://developer.stackmob.com/rest-api/api-docs#a-get_-_read_objects and 
    https://github.com/jobiwankanobi/stackmobphp</p>
<table border>
<tr><th>username</th><th>profession</th></tr>
<?php foreach ($decoded as $r):?>
    <tr><td><?php echo $r->username?></td><td><?php echo $r->profession?></td></tr>
<?php endforeach;?>
</table>
<?php echo $error_message;?>