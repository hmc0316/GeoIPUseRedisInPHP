<?php
/*
* Usage: give the ip address, you can get then geoip location from redis.
*
* 
*
*
*/

$redis = new Redis();
$redis_ip = $GLOBALS['memcache_ip'];        
$redis->connect($redis_ip);
$thisiplong = sprintf("%u",ip2long(user_ip()));
$res = $redis->zRangeByScore('etip:index', $thisiplong , '+inf', array('limit' => array(0, 1)));
$redis_key =  "etip:".$res[0];
$redis_arr = $redis->hmGet($redis_key,array("code","country"));

setcookie ('et_client_country',$redis_arr['code'],time()+3600*24*7,"/","ettoday.net" );//do ³£¦³
$GLOBALS['et_client_country'] = $redis_arr['code'];    
$redis->close();