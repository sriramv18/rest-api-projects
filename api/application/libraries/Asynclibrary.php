<?php 
 
class Asynclibrary
{
 
    public function __construct()
    {
        $this->ci =& get_instance();
    }
 
    function do_in_background($url, $params)
    {
		//echo "\n\nURL\n\n";
		//print_r($url);
		///echo "\n\params\n\n";
		//print_r($params);
		
        $post_string = http_build_query($params);
        $parts = parse_url($url);
		
		// echo "\n\post_string\n\n";
		// print_r($post_string);
		// echo "\n\parts\n\n";
		// print_r($parts);
		
            $errno = 0;
        $errstr = "";
 
       //Use SSL & port 443 for secure servers
       //Use otherwise for localhost and non-secure servers
       //For secure server
        //$fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);

        //For localhost and un-secure server
       $fp = fsockopen($parts['host'], isset($parts['port']) ? 9999 : 9999, $errno, $errstr, 30);
	 //  echo "FP";print_r($fp);
        if(!$fp)
        {
            echo "Something Went Wrong";   
        }
        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Authorization:"."sparqvenba2018"."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
		//print_r($out);
        if (isset($post_string)) $out.= $post_string;
		//echo "isset";
        fwrite($fp, $out);
		// while (!feof($fp)) {
		// echo fgets($fp, 128);
		// }
		
        fclose($fp);
  }
}
?>