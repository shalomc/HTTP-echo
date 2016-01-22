<?php 
/**
  *			 Copyright 2016 Shalom Carmel
  *			Licensed under the Apache License, Version 2.0 (the "License");
  *			you may not use this file except in compliance with the License.
  *			You may obtain a copy of the License at
  *
  *			http://www.apache.org/licenses/LICENSE-2.0
  *
  *			Unless required by applicable law or agreed to in writing, software
  *			distributed under the License is distributed on an "AS IS" BASIS,
  *			WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  *			See the License for the specific language governing permissions and
  *			limitations under the License.
  *
**/
require_once('./Lib/GeoIP/GeoIP.php');
 
 // Instruct browsers, proxies and CDN to not cache
 header('Cache-Control: private, no-cache'); 
 // Allow usage with AJAX 
 header('Access-Control-Allow-Origin: *'); 

// Output json by default, output text only if instructed to by an appropriate header or a query string item. 
if ( empty($_SERVER['HTTP_X_ECHO_TYPE']) && empty($_GET['x-echo-type'] ) ) {
	$json=true; 
} elseif ($_SERVER['HTTP_X_ECHO_TYPE'] == 'text' ) {
	$json = false;
} elseif ($_GET['x-echo-type'] == 'text' ) {
	$json = false;
} else {
	$json = true;
}

// By default do not fetch and output geoip, unless instructed to by an appropriate header or a query string item. 
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
	$response["meta"]["description"]='HTTP echo service';
	$response["meta"]["author"]='Shalom Carmel 2016';
	$response["meta"]["version"]='1.5';
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
    $HTTP_body = file_get_contents('php://input');
	
	$response["body"]= $HTTP_body; 
	echo json_encode($response, JSON_PRETTY_PRINT) ; 
    echo PHP_EOL;	
	
} else {
	header('Content-Type: text/plain');
	echo $_SERVER['REQUEST_METHOD'] .' '.  $_SERVER['REQUEST_URI']. ' ' . $_SERVER['SERVER_PROTOCOL'] . PHP_EOL;

    $headers = apache_request_headers();
    foreach ($headers as $header => $value) {
       echo "$header: $value" ;
	   echo PHP_EOL;
    }

    $HTTP_body = file_get_contents('php://input');
    echo PHP_EOL;
    echo "$HTTP_body" ;
    echo PHP_EOL;	
}


 
if( !function_exists('apache_request_headers') ) {
    function apache_request_headers() {
        $out_array = array();
        $rx_http = '/\AHTTP_/';

		// Look only for $_SERVER keys that look like HTTP_SOMETHING
        foreach($_SERVER as $key => $val) {
            if( preg_match($rx_http, $key) ) {
                // Convert something like this "HTTP_X_FORWARDED_FOR"
				//  into something like this "X-Forwarded-For"
                $out_array_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
                $rx_matches = explode('_', $out_array_key);

                if( count($rx_matches) > 0 and strlen($out_array_key) > 2 ) {
                    foreach($rx_matches as $ak_key => $ak_val) {
                        $rx_matches[$ak_key] = ucfirst($ak_val);
                    }

                    $out_array_key = implode('-', $rx_matches);
                }

                $out_array[$out_array_key] = $val;
            }
        }

        return( $out_array );
    }
}

?>