<?php
/*
* please let this 
* import the geoip information to redis, do it once.
*
*/

require_once 'Csv.class.php';
$redis = new Redis();
$redis->connect('127.0.0.1');
$readfile = "ip-to-country.csv";

if (file_exists($readfile))
{

	// read file line by line
	$csv = new Csv($readfile);
	$i=0;
	foreach($csv as $lines)
	{
		$data = explode(",",$lines);
		
		$i++;
		echo $data[0].'-'.$data[1].'-'.$data[2].'-'.$data[3].'-'.$data[4]."\n";
		$hkey = "etip:".$i;
		$hval = array("begin_ip"	=> (int)$data[0],
						"end_ip"	=> (int)$data[1],
						"code"		=> $data[2],
						"lcode"		=> $data[3],
						"country"	=> mb_convert_encoding($data[4], "UTF-8", "BIG-5")
						);
		$redis->hMset($hkey, $hval);
		$redis->zadd("etip:index", (int)$data[1], $i);

	}
	echo "total: $i \n";
}


