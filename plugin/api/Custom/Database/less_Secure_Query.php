<?php
    include_once 'sql_query.php';

    class Less_Sequre_Query{
        private $requestMethod;
        private $cred;

        function __construct($requestMethod, $cred)
        {
            $this->requestMethod = $requestMethod;
            $this->cred = $cred;
        }
        
        function less_Sequre($getQuery, $getValue, $getType){
            $sql = new SQL_Query();
            $jwt = new JWT_Data();                

                try{
                    if($_SERVER['REQUEST_METHOD'] === $this->requestMethod){
                            
                            if($this->cred == "Select" || $this->cred == 'select' || $this->cred == 'SELECT'){
                                $result = $sql->sql_Select($getQuery, $getValue, $getType);
                                return $result;
                            }else if($this->cred == "Insert" || $this->cred == 'insert' || $this->cred == 'INSERT'){
                                $result = $sql->sql_InsertDeleteUpdate($getQuery, $getValue, $getType);
                                return $result;
                            }else if($this->cred == "Delete" || $this->cred == 'delete' || $this->cred == 'DELETE'){
                                $result = $sql->sql_InsertDeleteUpdate($getQuery, $getValue, $getType);
                                return $result;
                            }else if($this->cred == "Update" || $this->cred == 'update' || $this->cred == 'UPDATE'){
                                $result = $sql->sql_InsertDeleteUpdate($getQuery, $getValue, $getType);
                                return $result;
                            }
                         
                    }else{
                        $status = EXPECTATION_FAILED;
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>'Request method not valid'));
                    }
                    
                }catch(Exception $e){
                    $err = $e->getMessage();
                    $conflict = 'Duplicate entry';
                    $columnNull = 'cannot be null';
                    $columnOtherType1 = 'Data truncated';
                    $columnOtherType2 = 'Incorrect';
                    if($err == ""){                
                        $status = FILE_NOT_FOUND_ERROR;                
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>"File not found"));
                    }else if(preg_match("/{$conflict}/i", $err)){
                        $status = CONFLICT;                
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>"Duplicate entry"));
                    }else if(preg_match("/{$columnNull}/i", $err)){
                        $status = PRECONDITION_FAILED;                
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>"Required input is null"));
                    }else if(preg_match("/{$columnOtherType1}/i", $err) || preg_match("/{$columnOtherType2}/i", $err)){
                        $status = PRECONDITION_FAILED;                
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>"Type mismatch"));
                    }else{
                        $status = BAD_REQUEST;
                        http_response_code($status);
                        echo json_encode(array('Status'=>$status, 'Message'=>$err));
                    }
                } 
        }
    }
    
?>