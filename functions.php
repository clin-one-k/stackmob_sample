<?php
//login 
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
	$status = curl_getinfo ($curl);
	if($status['http_code']=="401"){
		//login failed
	    return FALSE;
	}else{
		session_start();
		$decoded = get_http_body ($response);
		$_SESSION['user']=$decoded->stackmob->user->username;
		$_SESSION['photo']=$decoded->stackmob->user->photo;
		$_SESSION['areacode']=$decoded->stackmob->user->areacode;
		return TRUE;  
	}
}

//update area code
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
    $decoded = get_http_body ($response);
	$status = curl_getinfo ($curl);
	if($status['http_code']=="401"){
	    //failed
	    return FALSE;
	}else{
		$_SESSION['user']=$decoded->username;
		$_SESSION['photo']=$decoded->photo;
		$_SESSION['areacode']=$decoded->areacode;
		return TRUE;	    
	}
}

//update or add photo (file)
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
    $decoded = get_http_body ($response);
	$status = curl_getinfo ($curl);
	if($status['http_code']=="401"){
	    return FALSE;
	}else{
		$_SESSION['user']=$decoded->username;
		$_SESSION['photo']=$decoded->photo;
		$_SESSION['areacode']=$decoded->areacode;
		return TRUE;
	}
}

// get http response body
// Use HttpResponse Object is easier, 
// but PECL lib is not install on this server
function get_http_body ($response){
    if(($pos=strpos($response,"{"))!==false) { 
        $body=substr($response,$pos);
        $array = explode("\r\n\r\n", $body);
        $j=json_decode($array[0]);
        return $j;
    } 
}