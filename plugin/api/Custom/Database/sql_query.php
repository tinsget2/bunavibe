<?php
    include_once 'db_Config.php';
    class SQL_Query extends Database{
        function sql_Select($query, $param, $type){
            $conn = Database::connect();
            $databaseData = array();
    
            $stmt = $conn->prepare($query);
            
            $params = array();
            $params[0] = &$type;   

            for($i=0; $i< count($param); $i++){
                $params[$i+1] = &$param[$i];
            }    
            
            call_user_func_array(array($stmt, 'bind_param'), $params);
            
            if($stmt->execute()){    
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $databaseData = $result->fetch_all(MYSQLI_ASSOC);  
                    return $databaseData;    
                }else{
                    $err = mysqli_error($conn);
                    throw new Exception($err);
                }
            }else{
                $err = $stmt->error;
                throw new Exception($err);
            }
        }

        public function sql_InsertDeleteUpdate($query, $param, $type){
            $conn = Database::connect();
            $stmt = $conn->prepare($query);
            
            $params = array();
            $params[0] = &$type;   
        
            for($i=0; $i< count($param); $i++){
              $params[$i+1] = &$param[$i];
            }    
            
            call_user_func_array(array($stmt, 'bind_param'), $params);
            
            if($stmt->execute()){
              return true;
            }else{
              $err = $stmt->error;
              throw new Exception($err);
            }
            
               
        }
    }
?>