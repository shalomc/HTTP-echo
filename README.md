# HTTP echo

A simple PHP script to echo back the request coming to the server. 

## Reasoning
I often have to debug all types of HTTP requests.  Standard requests coming from a browser, API calls, AJAX requests, and CDN requests to the origin. 

This script will echo back everything it receives, including request metadata, all headers, and the request body. 
## Simple Usage
Standard usage is simply to invoke from curl or a browser. You will get a JSON response. 

` curl "http://yourserver/somepath/somefile?somequerystring"`

## Options

###Find and output Geo IP data
The geoip information is fetched in real time from http://www.geoplugin.net/
**********************************************************
****           Use with caution.                      ****
**********************************************************

Set the config file to include this line to see the geo information of the client based on the IP address. It is very handy when debugging CDN connections to the origin. 
` resolve-geoip=true `

Alternatively, add the "x-echo-geoip" header to the request.

` curl "http://yourserver/somepath/somefile?somequerystring"  -H "x-echo-geoip: on" `

Alternatively, add a "x-echo-geoip=on" query string parameter - it is case sensitive. 

` curl "http://yourserver/somepath/somefile?somequerystring&x-echo-geoip=on" `

###Output as text
By default the results are returned as JSON. 

You can add this line to the config file to have a text response instead of a json response. 

` response-type=text `

Alternatively, add the "x-echo-type" header.

` curl "http://yourserver/somepath/somefile?somequerystring"  -H "x-echo-type: text" `

Alternatively, add a "x-echo-type=text" query string parameter - it is case sensitive. 

` curl "http://yourserver/somepath/somefile?somequerystring&x-echo-type=text" `

###Support CDN True client IP headers
When used behind a CDN, the IP address as seen by the script is not the client IP but the CDN IP. 

You can add this line to the config file to use a specific HTTP header with the real client IP. In this case - it is configured for Fastly.

` override-clientip=Fastly-Client-IP `

Alternatively, add the "x-override-clientip" header.

` curl "http://yourserver/somepath/somefile?somequerystring"  -H "x-override-clientip: Fastly-Client-IP" `

Alternatively, add a "x-override-clientip=Fastly-Client-IP" query string parameter.

` curl "http://yourserver/somepath/somefile?somequerystring&x-override-clientip=Fastly-Client-IP" `

## Example output 
Debugging Akamai connections to my server 
```
{
    "meta": {
        "description": "HTTP echo service",
        "author": "Shalom Carmel 2016",
        "version": "1.9.1"
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
    "body": null
}
```
## Installation 
### Simple installation
Just drop everything into a folder on your web server. As simple as that.  
Use composer to verify that you have the latest Mobile detect library. 

### Installation from scratch
Assuming you have a new AWS server, you need php 5.4 and Apache to run this tool. 

The install.sh script in the setup folder installs all of the prerequisites, downloads the repository, and puts everything in place. 

Modify it to remove parts that were done manually. 


### CloudFormation Installation
The HttpEchoService.json file is an AWS CloudFormation template to start an EC2 server and automatically configure it to use the echo service.

## To do
* Add Nginx support

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