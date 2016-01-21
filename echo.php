<?php 


 header('Cache-Control: private, no-cache'); 
 header('Access-Control-Allow-Origin: *'); 

if ( empty($_SERVER['HTTP_X_ECHO_TYPE']) && empty($_GET['x-echo-type'] ) ) {
	$json=true; 
} elseif ($_SERVER['HTTP_X_ECHO_TYPE'] == 'text' ) {
	$json = false;
} elseif ($_GET['x-echo-type'] == 'text' ) {
	$json = false;
} else {
	$json = true;
}


if ( empty($_SERVER['HTTP_X_ECHO_GEOIP']) && empty($_GET['x-echo-geoip'] ) ) {
	$geoip=false; 
} elseif ($_SERVER['HTTP_X_ECHO_GEOIP'] == 'on' ) {
	$geoip = true;
} elseif ($_GET['x-echo-geoip'] == 'on' ) {
	$geoip = true;
} else {
	$geoip = false;
}

if ($json) { 
	header('Content-Type: application/json');
	$response = array ();
	date_default_timezone_set("UTC");
	$time = time(); 
	$response["meta"]["description"]='Globaldots echo service';
	$response["meta"]["author"]='Shalom Carmel 2016';
	$response["meta"]["version"]='1.3';
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

    $headers = apache_request_headers();
	$response["headers"]= $headers; 
	
	if ($geoip) {
		$response["geoip_info"] = get_geoip_info( $_SERVER['REMOTE_ADDR'] ) ; 
	}
    $entityBody = file_get_contents('php://input');
	
	$response["body"]= $entityBody; 
	echo json_encode($response, JSON_PRETTY_PRINT) ; 
    echo PHP_EOL;	
	
} else {
	header('Content-Type: text/plain');
	echo $_SERVER['REQUEST_METHOD'] .' '.  $_SERVER['REQUEST_URI']. ' ' . $_SERVER['SERVER_PROTOCOL'] . PHP_EOL;

    $headers = apache_request_headers();
    foreach ($headers as $header => $value) {
       echo "$header: $value \n";
    }

    $entityBody = file_get_contents('php://input');
    echo PHP_EOL;
    echo "$entityBody" ;
    echo PHP_EOL;	
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

function get_geoip_info($ip) {
        $arh = array();
        $rx_geoip = '/geoplugin_/';
		$geoinfo=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));


        foreach($geoinfo as $key => $val) {
            if( preg_match($rx_geoip, $key) ) {
                $arh_key = preg_replace($rx_geoip, '', $key);
                $arh[$arh_key] = $val;
            }
        }

        return( $arh );
    }



// curl -v -X PUT "http://onapp.cdn.test.danidin.net/method.php" -d "fruit=melon" -d "quantity=10" 

?>