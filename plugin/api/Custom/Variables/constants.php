<?php 
	//Change the path in the following directory

	$root = $_SERVER['DOCUMENT_ROOT'];
	$pathRoot = $root."/bunavibe";

	define('ROOT_DICTORY', $pathRoot);

	define('URL', 'tinsae.com');
	/*Security*/

	//Local
	//DB config 
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'bunavibe');

	//Hosted
	//DB config 
	// define('DB_HOST', 'localhost');
	// define('DB_USER', 'id19588600_bunauser');
	// define('DB_PASS', 'testBuna@2015');
	// define('DB_NAME', 'id19588600_bunavibe');


	//To encript json web token
	define('SECRETE_KEY', 'tEST123');
	//To encipt datas entered to database
	define('ENCRIPTION_KEY', 'tEST1234');
	//secret token key
	define('SECRETE_TOKEN_KEY', 'TEST123');
	
	//coockie name
	define('USER_COOCKIE_NAME', 'Bunavibe');


	//File location for media upload
	define('PATH1', $pathRoot.'/dist/cv/');
	define('PATH2', $pathRoot.'/dist/posts/');
	define('PATH3', '');
	define('PATH4', '');
	define('PATH5', '');
	define('PATH6', '');
	
	/*Data Type*/
	define('BOOLEAN', 	'1');
	define('INTEGER', 	'2');
	define('STRING', 	'3');

	/*Error Codes*/
	define('REQUEST_METHOD_NOT_VALID',		        100);
	define('REQUEST_CONTENTTYPE_NOT_VALID',	        101);
	define('REQUEST_NOT_VALID', 			        102);
    define('VALIDATE_PARAMETER_REQUIRED', 			103);
	define('VALIDATE_PARAMETER_DATATYPE', 			104);
	define('API_NAME_REQUIRED', 					105);
	define('API_PARAM_REQUIRED', 					106);
	define('API_DOST_NOT_EXIST', 					107);
	define('INVALID_USER_PASS', 					108);
	define('USER_NOT_ACTIVE', 						109);

	define('SUCCESS_RESPONSE', 						200);//used for success messages
	define('CREATED',	 							201);
	define('ACCEPTED',	 							202);
	define('NO_CONTENT',	 						204);
	

	/*Server Errors*/

	define('JWT_PROCESSING_ERROR',					300);//used for jwt errors 
	define('ATHORIZATION_HEADER_NOT_FOUND',			301);
	define('ACCESS_TOKEN_ERRORS',					302);//used for coockie not found 
	

	// User Errors
	define('BAD_REQUEST', 							400);//used for unknown erors
	define('UNAUThORIZED', 							401);//used for autorization
	define('PAYMENT_REQUIRED',						402);
	define('FORBIDDEN', 							403);//used for forbidden rules
	define('FILE_NOT_FOUND_ERROR',					404);//used for files not found	
	define('NOT_ACCEPTEBLE',						406);//Used for file upload
	define('REQUEST_TIMEOUT',						408);
	define('CONFLICT',								409);//used for duplicate entry
	define('PRECONDITION_FAILED',					412);//used for input errors(type mis match and required inputs)
	define('UNSUPPORTED_MEDIA_TYPE',				415);
	define('EXPECTATION_FAILED',					417);//used for http request method
	define('TOO_MANY_REQUESTS',						429);
?>