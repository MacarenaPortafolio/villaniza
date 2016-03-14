<?php
	//Clase conexion mysql
class mysql {
	
	//produccion
	private static $server = "localhost";
    private static $user = "villaniza";
    private static $pass = "nhlwfwfrnvz5981m6nuo";
    private static $data_base = "villaniza";
    private static $conexion;
    private static $flag = false;
    private static $error_conexion = "Error en la conexion a MYSQL";
   
   
    public function connect(){
            self::$conexion = @mysql_connect(self::$server,self::$user,self::$pass) or die(self::$error_conexion);
            self::$flag = true;
            @mysql_query("SET NAMES utf8");
            return self::$conexion;
    }
    
    public function close(){
        if(self::$flag == true){
            @mysql_close(self::$conexion);
        }
    }
    
    public function query($query){
        $data = array();
        self::connect();
        
        $rs = @mysql_db_query(self::$data_base,$query); 
        
        if (count($rs) == 0){
            return false;
        }else{
			if(stripos($query,"insert")===0){
				$data=mysql_insert_id();
			} else {
				while ($row = @mysql_fetch_array($rs)){
					array_push($data, $row);
			   }
			}
            return $data;
        }
        self::close();
    }
    
    public function execute($query){
        $data = array();
        self::connect();
        
        @mysql_db_query(self::$data_base,$query); 
        
        self::close();
    }
    
    public function f_obj($query){
        return @mysql_fetch_object($query);
    }

    public function f_array($query){
        return @mysql_fetch_assoc($query);
    }

    public function f_num($query){
        return @mysql_num_rows($query);
    }
    
    public function select($db){
        $result = @mysql_select_db($db,self::$conexion);
        if($result){
            self::$data_base = $db; 
            return true;
        }else{
            return false;
        }
    }
    
    public function free_sql($query){
        mysql_free_result($query);
    }
}
?>