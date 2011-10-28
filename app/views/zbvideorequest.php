<?php
header("HTTP/1.1 200 OK", true, 200);
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
// content type set to JSON
header("Content-type: application/json", false, 200);

// if request was to delete expired chat requests, return number deleted
if ($type == 'del_expired')
{
	echo '{"numexpired":' . $result . '}';
}

// if request was to delete a specific chat request, return number deleted
if ($type == 'del_single')
{
	echo '{"numdeleted":' . $result . '}';
}

// if request was to delete all chat requests of a user, return number deleted
if ($type == 'del_all')
{
	echo '{"numdeleted":' . $result . '}';
}

// if request was a lookup, encode result array ($data) to json and send
if ($type == 'lookup_by_target')
{
	echo json_encode($result);
}

// if request was to create a chat requests to a user, return number of requests created
// 0 if error, 1 if this is a new request, 2 if an existing request was updated
if ($type == 'request')
{
	echo '{"numrequested":' . $result . '}';
}


// if request was to update the updatetime of a registration return status (1 success, 0 not found or error, 2 error)
if ($type == 'update_registration')
{
	if (empty($result))
	{
		echo '{"status":2}';
	}
	else
	{
		echo '{"status":' . $result . '}';
	}
}

?>