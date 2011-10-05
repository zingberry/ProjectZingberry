<?php
header("HTTP/1.1 200 OK", true, 200);
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-type: text/xml", false, 200);
echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
echo "<result>";

if ($type == 'registration')
{	
	if (isset($queryresult) && (!is_null($queryresult)) && ($queryresult > 0))
	{	
		echo "<update>true</update>";		
	}
	else
	{
		echo "<update>false</update>";		
	}	
}
elseif($type == 'deregistration')
{		
	// Modified so that it always returns true when disconnecting
	
	//if (isset($queryresult) && (!is_null($queryresult)) && ($queryresult > 0))
	//{
		echo "<update>true</update>";
	//}
	//else
	//{
	//	echo "<update>false</update>";		
	//}
}
elseif($type == 'lookup')
{
	echo "<friend>";
	echo "<user>" . $user . "</user>";
	if (isset($identity) && !is_null($identity))
	{
		// user is available, send their identity
		echo "<identity>" . $identity->m_identity . "</identity>";
	}
	echo "</friend>";
}

echo "</result>";

?>