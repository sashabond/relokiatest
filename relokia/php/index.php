<?php 
require 'vendor/autoload.php';
$api_key = "API_KEY";
$password = "1234";
$yourdomain = "YOUR_DOMAIN";

$url = "https://$yourdomain.freshdesk.com/api/v2/tickets?";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);
 
if($info['http_code'] == 200) {
  echo "Tickets fetched successfully, the response is given below \n";
  $fp = fopen('file.csv', 'w');
	for($i=0;$i<9999;$i++){
		$list = array (
			array($headers[$i]),
			array($response[$i])
		);
	fputcsv($fp, $list);
	} 
else {
    echo "Error \n";
}
curl_close($ch);
fclose($fp);

?>