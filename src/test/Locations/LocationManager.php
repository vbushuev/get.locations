<?php  namespace vsb\Locations;
use vsb\Locations\Exceptions\Exception as LocationException;
use Log;
class LocationManager {
    public function handle(){
        $content = $this->import();
        $response = $this->toJson($content);
        return $response->data->locations;
    }
    protected function import(){
        $headers = config('locations.curl.header');
        $url = config('locations.curl.url');
        $ch = curl_init();
        $chOpts = [
            CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_HEADER=>1,
            CURLOPT_FOLLOWLOCATION=>true,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_CONNECTTIMEOUT =>8,
            CURLOPT_TIMEOUT => 16,
            CURLOPT_URL=>$url
        ];
        if( !is_null($headers) && is_array($headers) && count($headers) ){
            $chOpts[CURLOPT_HTTPHEADER]=$headers;
        }
        curl_setopt_array($ch, $chOpts);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($errno)throw new LocationException(curl_error($ch),$errno);
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
        if(!isset($response->success)) throw new LocationException('RESPONSE: Incorrect JSON format',500);
        if(!isset($response->data)) throw new LocationException('RESPONSE: Incorrect JSON format no data',500);
        if(!isset($response->data->locations)) throw new LocationException('RESPONSE: Incorrect JSON format no locations',500);
        if(!$response->success) throw new LocationException('Response:'.(isset($response->data) && isset($response->data->message))?$response->data->message:'no error response message',(isset($response->data) && isset($response->data->code))?$response->data->code:-500);
        return $response;
    }
};
?>
