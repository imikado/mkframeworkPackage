<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
/** 
* plugin_restClient classe pour gerer un serveur REST
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_restServer{


	/*
	$parameters = array();

	// first of all, pull the GET vars
	if (isset($_SERVER['QUERY_STRING'])) {
	    parse_str($_SERVER['QUERY_STRING'], $parameters);
	}

	// now how about PUT/POST bodies? These override what we got from GET
	$body = file_get_contents("php://input");
	$content_type = false;
	if(isset($_SERVER['CONTENT_TYPE'])) {
	    $content_type = $_SERVER['CONTENT_TYPE'];
	}
	switch($content_type) {
	    case "application/json":
	        $body_params = json_decode($body);
	        if($body_params) {
	            foreach($body_params as $param_name => $param_value) {
	                $parameters[$param_name] = $param_value;
	            }
	        }
	        $this->format = "json";
	        break;
	    case "application/x-www-form-urlencoded":
	        parse_str($body, $postvars);
	        foreach($postvars as $field => $value) {
	            $parameters[$field] = $value;

	        }
	        $this->format = "html";
	        break;
	    default:
	        // we could parse other supported formats here
	        break;
	}
	*/

}