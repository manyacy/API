/* This is the main connection class
Modify at your own risk. This class is required for 
validate_test.php to funtion */
<?php
class Dvapi_connect
{
    private $apikey;
    private $http_status = false;
    private $location = false;
    private $format = "json";
    public $response;
    
    public function __construct($apikey = false)
    {
        $this->apikey = $apikey;
    }
    
    public function validateEmail($email = "")
    {
        $email_body = '{"settings":[],"emails":[{"email":"'.$email.'"}]}';
        $c = curl_init("http://dvapi.com/email/validate");
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $email_body);
        curl_setopt($c, CURLOPT_HEADER, TRUE);
        curl_setopt($c, CURLOPT_HTTPHEADER, array("apikey:{$this->apikey}","Content-Type: text/plain"));
        curl_setopt($c, CURLOPT_VERBOSE, 1);
        curl_setopt($c, CURLOPT_TIMEOUT, 1500);
        $response = curl_exec($c);
        $this->http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if ((integer) $this->http_status == 201):
            preg_match('/Location:(.*?)\n/', $response, $matches);
            $this->location = trim(array_pop($matches));
        endif;
        curl_close($c);
    }
    
    public function getValidationResult()
    {
        if ($this->location):
            $c = curl_init("{$this->location}.{$this->format}");
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_GET, 1);
            curl_setopt($c, CURLOPT_HTTPHEADER, array("apikey:{$this->apikey}"));
            curl_setopt($c, CURLOPT_VERBOSE, 1);
            curl_setopt($c, CURLOPT_TIMEOUT, 1500);
            $this->response = curl_exec($c);
            $this->http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            curl_close($c);
            if ((integer) $this->http_status == 200):
                return true;
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }
    public function getHttpStatus()
    {
        return (integer) $this->http_status;
    }
    public function getLocation()
    {
        return (string) $this->location;
    }
    public function setLocation($location = false)
    {
        $this->location = $location; 
    }
    public function setFormat($format = "json")
    {
        $this->format = $format;
    }
    public function getFormat()
    {
        return (string) $this->format;
    }
}