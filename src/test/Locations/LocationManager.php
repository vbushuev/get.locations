<?php  namespace vsb\Locations;
use vsb\Locations\Exceptions\Exception as LocationException;
class LocationManager {
    public function handle(){
        $content = $this->import();
        $response = $this->toJson($content);
        return $response->data->locations;
    }
    protected function import(){
        $headers = config('locations.header');
        $url = config('locations.url');
        $ch = curl_init();
        $chOpts = [
            CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_HEADER=>1,
            CURLOPT_FOLLOWLOCATION=>true,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_CONNECTTIMEOUT =>8,
            CURLOPT_TIMEOUT => 16,
            CURLOPT_HTTPHEADER=>$headers,
            CURLOPT_URL=>$url
        ];
        curl_setopt_array($ch, $chOpts);
        $response = curl_exec($ch);
        $errno = curl_errno();
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($errno)throw new LocationException(curl_error(),$errno);
        if($httpcode<200 || $httpcode>=400) throw new LocationException('HTTP error response', $httpcode);
        $header = substr($response, 0, $header_size);
        $content = substr($response, $header_size);
        return $content;
    }
    protected function toJson($content){
        $response = json_decode($content);
        $jsonCode = json_last_error();
        // Let's do checks
        if($jsonCode!=JSON_ERROR_NONE) throw new LocationException('JSON:'.json_last_error_msg(),$jsonCode);
        if(!isset($respose->success)) throw new LocationException('RESPONSE: Incorrect JSON format',500);
        if(!$respose->success) throw new LocationException('Response:'.(isset($response->data) && isset($response->data->message))?$response->data->message:'no error response message',(isset($response->data) && isset($response->data->code))?$response->data->code:-500);
    }
};
?>
