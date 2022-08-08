<?php 

require("config.php");
$DSN="mysql:host=$host;dbname=$dbname;";
class connect {
    public static function connection($DSN,$user,$password){
      try{
   $options=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
      return new PDO($DSN,$user,$password,$options);
      }catch(PDOException $e){
        die($e->getMessage());
      }
    }
}
return connect::connection($DSN,$user,$password);

?>