<?php

class Mysql{

    private $host;    
    private $user;
    private $pwd;
    private $dbName;
    private $conn;
    private $charset;

//初始化
    public function __construct(){
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pwd = '';
        $this->dbName = 'bootstrap';
        $this->charset = "set names 'utf8'";
//调用链接方法
        $this->connection($this->host,$this->user,$this->pwd,$this->dbName);
//调用字符方法
        $this->setChar();
    }

//链接数据库
    private function connection($h,$u,$p,$db){
        $this->conn = mysqli_connect($h,$u,$p,$db);
    }
//字符方法方法
    private function setChar(){
        $this->query($this->charset);
    }
//查询语句方法
    public function query($sql){
        return mysqli_query($this->conn,$sql);  
    }
//得到数据方法
    public function getAll($sql){
        $data = [];
        $res = $this->query($sql);
        if(!$res){
            return false;
        }else{
           while($result = mysqli_fetch_assoc($res)){
               $data[] = $result;
           }  
           return $data; 
           $this->freeResult($res); 
           $this->freeConn();
        }
    }
//释放资源
    private function freeResult($res){
        mysqli_free_result($res);
    }

//关闭数据库
    private function freeConn(){
        mysqli_close($this->conn);
    }
}



// $mysql = new Mysql();
// $sql = "select * from tbcourse where stu_id = 10";
// $query = $mysql->getAll($sql);
// if($query){
//     var_dump($query);
// }else{
//     echo "没有数据";
// }
// $sql1 = "insert into tbstudent(stu_rollno,stu_name) value(8,'李八')";
// if($mysql->query($sql1)){
//     echo "成功";
// }else{
//     echo "失败";
// }



?>