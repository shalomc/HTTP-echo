# HTTP echo

A simple PHP script to echo back the request coming to the server. 

## Reasoning
I often have to debug all types of HTTP requests.  Standard requests coming from a browser, API calls, AJAX requests, and CDN requests to the origin. 

This script will echo back everything it receives, including request metadata, all headers, and the request body. 
## Usage
Standard usage is simply to invoke from curl or a browser. You will get a JSON response. 

` curl "http://yourserver/somepath/somefile?somequerystring"`

You can add the "x-echo-type" header to have a text response instead of a json response. 

` curl "http://yourserver/somepath/somefile?somequerystring"  -H "x-echo-type: text" `

Alternatively, add a "x-echo-type=text" query string parameter - it is case sensitive. 

` curl "http://yourserver/somepath/somefile?somequerystring&x-echo-type=text" `
## Example output 
Debugging Akamai connections to my server 
```
{
    "meta": {
        "description": "Globaldots echo service",
        "author": "Shalom Carmel 2016",
        "version": "1.0"
    },
    "request": {
        "timestamp": 1453377461,
        "date": "2016-01-21 11:57:41",
        "server": "echo.globaldots.com",
        "port": "80",
        "protocol": "HTTP\/1.1",
        "client_ip": "165.254.92.135",
        "method": "GET",
        "uri": "\/index.html?x=887",
        "query_string": "x=887",
        "https": null,
        "remote_user": null
    },
    "headers": {
        "Accept": "text\/html,application\/xhtml+xml,application\/xml;q=0.9,*\/*;q=0.8",
        "Accept-Encoding": "gzip",
        "Accept-Language": "en-US,en;q=0.5",
        "Akamai-Origin-Hop": "1",
        "Cache-Control": "no-cache, max-age=0",
        "Connection": "TE, keep-alive",
        "Host": "echo.globaldots.com",
        "Pragma": "akamai-x-cache-remote-on, akamai-x-check-cacheable, akamai-x-get-nonces, akamai-x-get-ssl-client-session-id, akamai-x-get-true-cache-key, akamai-x-serial-no, no-cache",
        "Te": "chunked;q=1.0",
        "User-Agent": "Mozilla\/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko\/20100101 Firefox\/43.0",
        "Via": "1.1 akamai.net(ghost) (AkamaiGHost)",
        "X-Akamai-Config-Log-Detail": "true",
        "X-Akamai-Device-Characteristics": "brand_name=Firefox;device_os=Windows NT;is_mobile=false",
        "X-Akamai-Edgescape": "georegion=175,country_code=PL,city=WARSAW,lat=52.25,long=21.00,timezone=GMT+1,continent=EU,throughput=vhigh,bw=5000,asnum=47273,location_id=0",
        "X-Akamai-Staging": "EdgeSuite",
        "X-Forwarded-For": "185.15.80.161"
    },
    "body": ""
}
```
## Installation 
Drop the echo.php file and the .htaccess file into a folder on an Apache server. 

## To do
* Add Nginx support
* Add WURFL device data to the output

## License
Copyright 2016 Shalom Carmel

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.