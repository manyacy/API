/* CURL command line examples for accesing the API */

# Validating a single e-mail address:

curl -H "apikey:[apikeyclient]" -X POST -d '{"settings":[],"emails":[{"email":"john.doe@domain.com","custom_id":12,"custom_name":"John Doe","custom_address":"Test Street nr 12"}]}' http://dvapi.com/email/validate

/* Ok now that long command can be a little intimidating so lets break it down:
*   curl -H "apikey:
*   is where we pass our api key for authenticatin
*   -X POST is defining the type of request we are making 
*   and now -d our payload 
*   {
*  				"settings":[],
*					"emails": 
*					[	
*						{
*							"email":"email@example.com"
*						}	
*					]
*				}
* That is actually the minimum json information you have to pass in order to get a result. 
* You can however as in our cli example pass upto 3 custom fields with the e-mail. 
* They can be named anything you want and they simply follow the e-mail. 
* "email":"john.doe@domain.com","custom_id":12,"custom_name":"John Doe","custom_address":"Test Street nr 12"
*
*/

# Validating up to 500 e-mails in a list

curl -H "apikey:[apikeyclient]" -X POST -d '{"settings":[],"emails":[{"email":"john.doe1@domain.com1","custom_id":12,"custom_name":"John Doe1","custom_address":"Test Street nr 12"},{"email":"john.doe2@domain.com","custom_id":15,"custom_name":"John Doe2","custom_address":"Test Street nr 12"},{"email":"john.doe3@domain.com","custom_id":19,"custom_name":"John Doe3","custom_address":"Test Street nr 12"}]}' http://dvapi.com/email/validate

/* It is possible to send up to 500 e-mails in a list to be validated without having to upload a file. 
* The syntax is identical to validating a single e-mail you simply pass more elements in your json. 
* Lists of up to 500 are put in for processing instantly so this is usefull when you have a small batch of 
* emails you need back quickly
*/

# Uploading a file to be validated 

curl -H "apikey:[apikeyclient]" -H "Expect:" -X PUT --upload-file file.[format] http://dvapi.com/email/file.[format]

/* Lets break id down:
* We pass the api key with curl -H "apikey:
* -H "Expect:" is just a parameter the server needs to know it should expect a file upload 
* -X PUT identifies the action type
* --upload-file tells curl to upload a file
* file.[format] is the name and extension (csv,json,xml) of the file on your local machine youa are uploading
* remmeber to provide the /full/path/to/yourfile.csv 
* http://dvapi.com/email/file.[format] tells curl where to PUT the file 
* Please remember the the .[format] for your file and of the url you are publishing to have to match:
* if your file is myfile.csv then your url is http://dvapi.com/email/file.csv
* /

# Retriveving Results

/* Every time you request an e-mail , list , or file to be valdiated you are given back a response with the location
*where the results can be retrieved:
*
* HTTP/1.1 201 Created
* Access-Control-Allow-Origin: *
* Date: Wed, 27 Jun 2012 09:30:57 GMT
* Content-Length: 0
* Location: http://dvapi.com/email/657518
* Content-Type: text/html
* Connection: close
* X-Powered-By: PHP/5.3.2-1ubuntu4.14
* Server: lighttpd/1.4.
* 
* the Location: http://dvapi.com/email/657518 is what tells you where you can retrieve the results of your validation request. 
* If you are not seeing this full response when issuing a PUT or POST with curl make sure to put -v at the end of yoru 
* curl command to turn on verbose. 

# Retrieving results for a single e-mail

curl -H "apikey:[apikeyclient]" http://dvapi.com/email/[email_id].[format]

/* the .[format] can be selected by you. Regardless of what format you posted your request in. 
* You can ask for the results to come back in json,xml,csv
* By default json is used for single e-mails and small lists
* /

# Retrieving a list 

curl -H "apikey:[apikeyclient]" http://dvapi.com/list/[list_id].[format]

# Retriving and saving a list or file
curl -H "apikey:[apikeyclient" -o your_validated_file.csv http://dvapi.com/list/[list_id]

/* This will save the desired list into a file on yoru local machine */



