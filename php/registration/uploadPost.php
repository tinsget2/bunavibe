<?php
    require_Once "../../plugin/api/Custom/Database/Sequredquery/sequre_Query_Include.php";

    header('Content-Type: application/json');
    // Turn off all error reporting
    // error_reporting(0);

    $jwt = new JWT_Data();

    $response = json_decode($jwt->get_JWT());
    //Token response code
    $status = $response->Status;
    //Token message or data
    $jwtToken = $response->Message;
    //issues at time
    $jwtToken_iat = $response->iat;

    //token data check comment out the rest of the code and uncomment print_r
    // print_r($jwtToken);
    //Token datas
    $token = $jwt->decript_256($jwtToken->token, true);
    $phone = $jwt->decript_256($jwtToken->phone, true);
    $authorization = $jwt->decript_256($jwtToken->authorization, true);
    $email = $jwt->decript_256($jwtToken->email, true);
    $alies = $jwt->decript_256($jwtToken->alies, true);
    $name = $jwt->decript_256($jwtToken->name, true);
    $iat = $jwtToken->iat;

    //Token create mostly from uniquedatafromjwttoken+iat+secrettokenkey
    $createdToken = $email.$phone.URL.$iat.$authorization;

    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Select');

    $query = "SELECT COUNT(`alies`) AS 'count' FROM `posts` WHERE `alies`=?";
    $value = array($alies);
    $type = 's';
    $res = $sql_Query->data_Validate($query, $value, $type);

    $cnt = 8;
    if($res[0]['count'] < $cnt){   

        $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');
        $path = upload_Media();    

        $query = "INSERT INTO `posts`(`alies`, `name`, `path`) VALUES (?,?,?)";
        $value = array($alies, $path['Name'], $path['Path']);
        $type = 'sss';

        $result = $sql_Query->data_Validate($query, $value, $type);

        
        if(!($result == "") || !($result == null)){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>$result));
        }else{
            unlink($path['Path']);
        }

    }else{
        http_response_code(FORBIDDEN);
        echo json_encode(array('Status'=>FORBIDDEN, 'Message'=>'Can\'t upload morethan '.$cnt.' media files'));
    }

    function upload_Media(){
        $filename = basename($_FILES['file']['name']);

        $target = PATH2;
        $location = $target.$filename;  
        $uploadOk = 1;
        $imageFileType =  strtolower(pathinfo($location,PATHINFO_EXTENSION));

        $time = time();
        $name = 'CV'.$time.rand(0,9999).'.'.$imageFileType;

        if(file_exists($location) ){
            $uploadOk =  0;
            $mesgs = 'Upload Failed, File Already Existes';
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "mp4" && $imageFileType != "gif") {
            $uploadOk = 0;
            $mesgs = 'Upload Failed, Please only upload jpg, png, jpeg, mp4, gif files';    
        }

        if ($_FILES["file"]["size"] > 5000000) {
            $uploadOk = 0;
            $mesgs = "Upload Failed, your file is more than 5MB.";
            
        }

        if($uploadOk == 0){
                // echo $mesgs;
            http_response_code(NOT_ACCEPTEBLE);
            echo json_encode(array('Status'=>NOT_ACCEPTEBLE, 'Message'=>$mesgs));
        }else{
            /* Upload file */

            if(move_uploaded_file($_FILES['file']['tmp_name'],$target.$name)){    
                // upload_To_DB($name, $email, $post); 
                return array('Path'=>$target.$name, 'Name'=>$name);
            }else{
                //.$_FILES['file']['error']
                    
                http_response_code(NOT_ACCEPTEBLE);
                echo json_encode(array('Status'=>NOT_ACCEPTEBLE, 'Message'=>'File upload failed'));
            }
        }
    }


?>