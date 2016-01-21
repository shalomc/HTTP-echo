<?php 

if ( empty($_SERVER['HTTP_X_ECHO_TYPE']) && empty($_GET['x-echo-type'] ) ) {
	$json=true; 
} elseif ($_SERVER['HTTP_X_ECHO_TYPE'] == 'text' ) {
	$json = false;
} elseif ($_GET['x-echo-type'] == 'text' ) {
	$json = false;
} else {
	$json = true;
}

 header('Cache-Control: private, no-cache'); 
 header('Access-Control-Allow-Origin: *'); 
if ($json) { 
	header('Content-Type: application/json');
} else {
	header('Content-Type: text/plain');
}

if( !function_exists('apache_request_headers') ) {
    function apache_request_headers() {
        $arh = array();
        $rx_http = '/\AHTTP_/';

        foreach($_SERVER as $key => $val) {
            if( preg_match($rx_http, $key) ) {
                $arh_key = preg_replace($rx_http, '', $key);
                $rx_matches = array();
           // do some nasty string manipulations to restore the original letter case
           // this should work in most cases
                $rx_matches = explode('_', $arh_key);

                if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                    foreach($rx_matches as $ak_key => $ak_val) {
                        $rx_matches[$ak_key] = ucfirst($ak_val);
                    }

                    $arh_key = implode('-', $rx_matches);
                }

                $arh[$arh_key] = $val;
            }
        }

        return( $arh );
    }
}
if ($json) { 
	$response = array ();
	date_default_timezone_set("UTC");
	$time = time(); 
	$response["meta"]["description"]='Globaldots echo service';
	$response["meta"]["author"]='Shalom Carmel 2016';
	$response["meta"]["version"]='1.0';
	$response["request"]["timestamp"]=$time;
	$response["request"]["date"]=date('Y-m-d h:i:s',$time);
	$response["request"]["server"]= $_SERVER["SERVER_NAME"] ;
	$response["request"]["port"]= $_SERVER["SERVER_PORT"] ;
	$response["request"]["protocol"]= $_SERVER["SERVER_PROTOCOL"] ;
	$response["request"]["client_ip"]= $_SERVER["REMOTE_ADDR"] ;
	$response["request"]["method"]= $_SERVER["REQUEST_METHOD"] ;
	$response["request"]["uri"]= $_SERVER["REQUEST_URI"] ;
	$response["request"]["query_string"]= $_SERVER["QUERY_STRING"] ;
	$response["request"]["https"]= $_SERVER["HTTPS"] ;
	$response["request"]["remote_user"]= $_SERVER["REMOTE_USER"] ;	
} else {
	echo $_SERVER['REQUEST_METHOD'] .' '.  $_SERVER['REQUEST_URI']. ' ' . $_SERVER['SERVER_PROTOCOL'] . PHP_EOL;
}
    


    $headers = apache_request_headers();

if ($json) {
	$response["headers"]= $headers; 
} else {
    foreach ($headers as $header => $value) {
       echo "$header: $value \n";
    }
}

    $entityBody = file_get_contents('php://input');
if ($json) {
	$response["body"]= $entityBody; 
	echo json_encode($response, JSON_PRETTY_PRINT) ; 
} else { 
    echo PHP_EOL;
    echo "$entityBody" ;
}
    echo PHP_EOL;
 


// curl -v -X PUT "http://onapp.cdn.test.danidin.net/method.php" -d "fruit=melon" -d "quantity=10" 

?>