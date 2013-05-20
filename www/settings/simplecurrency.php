<?
##################### WARNING #########################
// Do not change anything below this comment 
// unless you know what you are doing.
#######################################################

function generateGuid($include_braces = false) {
	if (function_exists('com_create_guid')) {
		if ($include_braces === true) {
			return com_create_guid();
		} else {
			return substr(com_create_guid(), 1, 36);
		}
	} else {
		mt_srand((double) microtime() * 10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
	   
		$guid = substr($charid,  0, 8) . '-' .
				substr($charid,  8, 4) . '-' .
				substr($charid, 12, 4) . '-' .
				substr($charid, 16, 4) . '-' .
				substr($charid, 20, 12);
 
		if ($include_braces) {
			$guid = '{' . $guid . '}';
		}
   
		return $guid;
	}
}

function simplecurrency_do_post_request($found) {
    $params = array('http' => array(
            'method' => 'POST',
            'content' => implode(',', $found)
            ));
    if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
    }
    $ctx = stream_context_create($params);
    $timeout = 15;
    $old = ini_set('default_socket_timeout', $timeout);
    $fp = @fopen(SIMPLECURRENCY_SERVICE_URL, 'rb', false, $ctx);
    ini_set('default_socket_timeout', $old);
    if ($fp) {
        stream_set_timeout($fp, $timeout);
        stream_set_blocking($fp, 3);
    } else
        //throw new Exception("Problem with " . SIMPLECURRENCY_SERVICE_URL . ", $php_errormsg");
        return false;
    $response = @stream_get_contents($fp);
    if ($response === false) {
        //throw new Exception("Problem reading data from " . SIMPLECURRENCY_SERVICE_URL . ", $php_errormsg");
    }
    return $response;
}
?>