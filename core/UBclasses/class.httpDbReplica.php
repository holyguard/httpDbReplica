<?
// operational class Prices
class httpDbReplica{
	

	function query($query){
		    
		global $db;
		global $servers;
		
		$db->query($query);
		
		$myFile = $this->generateName();		
		$this->writeLog($myFile,$query);		
		
		foreach ($servers as $server) {
			if ($this->isDomainAvailible($server)){
				$this->sendSignal($server.'/httpDbReplica/receiver.php?l='.$myFile.'');
			} else {
				echo "Woops, nothing found there.";
			}
		}			 
    }
	
	
	
	function receive($myFile){
		
		global $db;
		global $servers;
		    
 		// get remote file		
		if (function_exists('curl_init')) {
		   
		   $ch = curl_init(); 	
		   curl_setopt($ch, CURLOPT_URL, 'http://www.google.com'); 		
		   curl_setopt($ch, CURLOPT_HEADER, 0); 		
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 		
		   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 		
		   $query = curl_exec($ch); 		
		   curl_close($ch); 
			
		} else {
		   // curl library is not installed so we better use something else
		}		

		// read it and execute query
		$db->query($query);	
		// save it in a specific dir
		$this->writeLog($myFile,$query);
		
		// propagate the file in the other servers		
		foreach ($servers as $server) {
			if ($this->isDomainAvailible($server)){
				$this->sendSignal($server.'/httpDbReplica/receiver.php?l='.$myFile.'');
			} else {
				echo "Woops, nothing found there.";
			}
		}		 
    }
	
	
	function generateName(){
		$name = time();
		return $name;
	}

	function writeLog($myFile,$query){		
		
		$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/logs/'.$myFile, 'w') or die("can't open file");		
		fwrite($fh, $query);
		fclose($fh);
	
	}
	
	function sendSignal($url){	

		$parts = parse_url($url);
		
		$fp = fsockopen($parts['host'], 
			  isset($parts['port'])?$parts['port']:80, 
			  $errno, $errstr, 30);
		
		if (!$fp) {
		  return false;
		   
		} else {
		  $out = "POST ".$parts['path']." HTTP/1.1\r\n";
		  $out.= "Host: ".$parts['host']."\r\n";
		  $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		  $out.= "Content-Length: ".strlen($parts['query'])."\r\n";
		  $out.= "Connection: Close\r\n\r\n";
		  if (isset($parts['query'])) $out.= $parts['query'];
		
		  fwrite($fp, $out);
		  fclose($fp);
		  return true;
		  
		}	
	}
	
	function sendData($url){
	
		 $curl_parameters = array(
			'param1' => 'ciccio',
			'param2' => 'bello'
		);
		
		$curl_options = array(
			CURLOPT_URL => "http://www.upbooking.com/httpDbReplica/test/curl-receive-post.php",
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query( $curl_parameters ),
			CURLOPT_HTTP_VERSION => 1.0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false
		);
		
		$curl = curl_init();
		curl_setopt_array( $curl, $curl_options );
		$result = curl_exec( $curl );
		
		curl_close( $curl );
	
	
	}
	
	
	//returns true, if domain is availible, false if not
	function isDomainAvailible($domain){
		//check, if a valid url is provided
		if(!filter_var($domain, FILTER_VALIDATE_URL)){ return false; }
		
		//initialize curl
		$curlInit = curl_init($domain);
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
		
		//get answer
		$response = curl_exec($curlInit);
		
		curl_close($curlInit);
		
		if ($response) return true;
		
		return false;
	}
	
	
}


//$opPrices = new opPrices();
//$opPrices->delete();