<?php
require_once("dvapi_connect.php");

$apikey = "[your_api_key]";
$email = "[email_address@domain.com]";
$format = "csv";//json,xml

$validation = new Dvapi_connect($apikey);
$validation->validateEmail($email);
if ($validation->getHttpStatus() == 201):
    $validation->setFormat($format);
    if ($validation->getValidationResult()):
        switch($format):
            case "json":
                $response = json_decode($validation->response);
                echo "validation status: {$response->code}, validation message: {$response->message}";
                break;
            case "xml":
                $response = simplexml_load_string($validation->response);
                echo "validation status: {$response->code}, validation message: {$response->message}";
                break;
            case "csv":
                var_export($validation->response);
                break;
            default:
                echo "Not a valid format";
        endswitch;
    else:
        echo "Response code: ".$validation->getHttpStatus();
    endif;
endif;