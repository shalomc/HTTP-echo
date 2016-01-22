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

 
 // Instruct browsers, proxies and CDN to not cache

function get_geoip_info($ip) {
        $out_array = array();
        $rx_geoip = '/geoplugin_/';
		$geoinfo=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));


        foreach($geoinfo as $key => $val) {
            if( preg_match($rx_geoip, $key) ) {
                $out_array_key = preg_replace($rx_geoip, '', $key);
                $out_array[$out_array_key] = $val;
            }
        }

        return( $out_array );
    }

