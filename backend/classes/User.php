<?php 

class User{
    private $pdo;
    private $errorArray=[];


    public function __construct(){
        $this->pdo=Database::instance();
    }

    public function userData($user_id){
        return $this->get("users",["*"],array("user_id"=>$user_id));
    }

    public function create($tableName,$fields=array()){
      $columns=implode(', ',array_keys($fields));
      $values=':'.implode(', :',array_keys($fields));
      $sql="INSERT INTO {$tableName} ({$columns}) VALUES ({$values})";
      if($stmt=$this->pdo->prepare($sql)){
          foreach($fields as $key =>$values){
              $stmt->bindValue(":".$key,$values);
          }
          $stmt->execute();
          return $this->pdo->lastInsertId();
      }
    }

    public function get($tableName,$columnName=array(),$fields=array()){
        $targetColumns=implode(', ',array_values($columnName));
        
        $columns="";
        $i=1;
        foreach($fields as $name =>$value){
            $columns .="{$name}=:{$name}";
           
            if($i <count($fields)){
                $columns .=" AND ";
            }
            $i++;
            
        }
        $sql="SELECT {$targetColumns} FROM `{$tableName}` WHERE {$columns}";
         //var_dump($sql);
         if($stmt=$this->pdo->prepare($sql)){
             foreach($fields as $key =>$values){
                 $stmt->bindValue(":".$key,$values);
             }
             $stmt->execute();
             return $stmt->fetch(PDO::FETCH_ASSOC);
         }
    }
}


?>