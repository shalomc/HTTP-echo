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

## Installation 
Drop the echo.php file and the .htaccess file into a folder on an Apache server. 

## To do
* Add Nginx support
* Add WURFL device data to the output

## License
Copyright 2011 Scott Merrill

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.