<?php 
require 'vendor/autoload.php';

class UserInfo
{
    private $api_key = "API_KEY", $password = "1234";
    public $ch, $url, $yourdomain = "YOUR_DOMAIN";

    public function ConnectionSettings(){
        curl_setopt($this->ch, CURLOPT_HEADER, true);
        curl_setopt($this->ch, CURLOPT_USERPWD, "$this->api_key:$this->password");
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

}

class Output extends UserInfo{
    public $server_output, $info, $header_size, $headers, $response, $fp, $list;

    public function GetHeaders() {
        $this->headers = substr($this->server_output, 0, $$this->header_size);
        return $this->headers;
    }
    public function GetResponse() {
        $this->response = substr($this->server_output, $this->header_size);
        return $this->headers;
    }

    public function TicketOut(){
        $this->fp = fopen('file.csv', 'w');
        for ($i = 0; $i < 9999; $i++) {
            $this->list = array(
                array($this->headers[$i]),
                array($this->response[$i])
            );
            fputcsv($this->fp, $this->list);
        }
        fclose($this->fp);
    }
}


$out = new Output();

$out->url = "https://$out->yourdomain.freshdesk.com/api/v2/tickets?";
$out->ch = curl_init($out->url);
$out->ConnectionSettings();

$out->server_output = curl_exec($out->ch);
$out->info = curl_getinfo($out->ch);
$out->header_size = curl_getinfo($out->ch, CURLINFO_HEADER_SIZE);
$out->GetHeaders();
$out->GetResponse();


if ($out->info['http_code'] == 200)
    {
    echo "Tickets fetched successfully, the response is given below \n";
    $out->TicketOut();
    }
else
    {
        echo "Error \n";
    }

curl_close($out->ch);
?>