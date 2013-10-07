<?php
function user_login($username, $password){
	$body="username=".$username."&password=".$password."&token_type=mac";
	$curl = curl_init ( "http://api.stackmob.com/user/accessToken" );
	curl_setopt ( $curl, CURLOPT_HEADER, true );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $body);
	curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
	    "Content-Type:application/x-www-form-urlencoded",
	    "Accept: application/vnd.stackmob+json; version=0",
	    "X-stackMob-API-Key: ".KEY

	    )
	);

	// run crul
	$response = curl_exec ( $curl );
	//list( $header, $body ) = explode ( "\r\n\r\n", $response, 2 );
	//$decoded = json_decode ( $body );
	$status = curl_getinfo ($curl);
	//$b = curl_multi_getcontent($curl);
	//var_dump($decoded->stackmob->user);
    $decoded = get_http_body ($response);
	if($status['http_code']=="401"){
	    
	    return FALSE;
	}else{
		session_start();
		$_SESSION['user']=$decoded->stackmob->user->username;
		$_SESSION['photo']=$decoded->stackmob->user->photo;
		$_SESSION['areacode']=$decoded->stackmob->user->areacode;
		//var_dump($_SESSION);
		return TRUE;
		
	    
	}
}
function update_areacode($code){

	$body=array("areacode"=>$code);
	$curl = curl_init ( "http://api.stackmob.com/user/".$_SESSION['user'] );
    curl_setopt ( $curl, CURLOPT_HEADER, true );
    curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $curl, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
        "Accept: application/vnd.stackmob+json; version=0",
        "X-stackMob-API-Key: ".KEY,
        'Content-Length: '.strlen(json_encode($body)),
        "Content-Type: application/json"
    ));
    $response = curl_exec ( $curl );
    //var_dump($response);
    //list( $header, $body ) = explode ( "\r\n\r\n", $response, 2 );
	//$decoded = json_decode ( $body );
    $decoded = get_http_body ($response);
	$status = curl_getinfo ($curl);
	//$b = curl_multi_getcontent($curl);
	//var_dump($decoded);
	if($status['http_code']=="401"){
	    
	    return FALSE;
	}else{
		$_SESSION['user']=$decoded->username;
		$_SESSION['photo']=$decoded->photo;
		$_SESSION['areacode']=$decoded->areacode;
		//var_dump($_SESSION);
		return TRUE;
		
	    
	}
}

function process_photo(){
	if($_FILES["photo"]["error"]>0){
	    $mesg= "Error: ". $_FILES["photo"]["error"] . "<br>";
	    return FALSE;
    }
    $str="Content-Type: img/jpg\nContent-Disposition: attachment;";
    $str.=" filename=photo.jpg\nContent-Transfer-Encoding: base64\n\n";
    $str.=base64_encode(file_get_contents($_FILES["photo"]["tmp_name"]));
    $body=array(
    	"username"=>$_SESSION['user'],
    	"photo"=>$str
    );
	$curl = curl_init ( "http://api.stackmob.com/user/".$_SESSION['user'] );
    curl_setopt ( $curl, CURLOPT_HEADER, true );
    curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $curl, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
        "Accept: application/vnd.stackmob+json; version=0",
        "X-stackMob-API-Key: ".KEY,
        "Content-Length: ".strlen(json_encode($body)),
        "Content-Type: application/json"
    ));
    $response = curl_exec ( $curl );
    //var_dump($response);
    //$resMesg= new HttpMessage($response);
    //list( $header, $h2,$rbody ) = explode ( "\r\n\r\n", $response, 3 );
    //$decoded = json_decode ( $resMesg->getBody() );
    //$decoded = json_decode ( $rbody );
    $decoded = get_http_body ($response);
	$status = curl_getinfo ($curl);
	if($status['http_code']=="401"){
	    return FALSE;
	}else{
		$_SESSION['user']=$decoded->username;
		$_SESSION['photo']=$decoded->photo;
		$_SESSION['areacode']=$decoded->areacode;
		//var_dump($_SESSION);
		return TRUE;
	}
}
function get_http_body ($response){
    if(($pos=strpos($response,"{"))!==false) { 
        $body=substr($response,$pos);
        $array = explode("\r\n\r\n", $body);
        $j=json_decode($array[0]);
        return $j;
    } 
}