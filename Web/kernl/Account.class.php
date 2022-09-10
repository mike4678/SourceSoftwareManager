<?php
/* ---------------------------------------------------- */
/* 程序名称: 账户函数库
/* 程序功能: 账户加解密函数库
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2019-01-01
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */

class Account {
	
	function PwdEnc($data, $key) 
	{ 
		$key = md5($key);
    	$x  = 0;
    	$len = strlen($data);
    	$l  = strlen($key);
    	for ($i = 0; $i < $len; $i++)
    	{
			if ($x == $l) 
        	{
				$x = 0;
        	}
        		$char .= $key{$x};
        	$x++;
    	}
    	for ($i = 0; $i < $len; $i++)
    	{
        	$str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
		}
		
    	return base64_encode($str);
	} 

	function decrypt($data, $key) 
	{ 
		$key = md5($key);
    	$x = 0;
    	$data = base64_decode($data);
    	$len = strlen($data);
    	$l = strlen($key);
    	for ($i = 0; $i < $len; $i++)
    	{
        	if ($x == $l) 
        	{
				$x = 0;
        	}
			$char .= substr($key, $x, 1);
        	$x++;
		}
    	for ($i = 0; $i < $len; $i++)
    	{
			if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        	{
				$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        	}
        	else
        	{
            	$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
			}
		}
    	return $str;
	} 	
}	
?>