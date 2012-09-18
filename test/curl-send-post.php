<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?
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
  
  echo $result;
?>
</body>
</html>