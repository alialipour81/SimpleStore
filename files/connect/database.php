<?php
ob_start();
session_start();


class database
{
    protected $dbConnect;
    private $dbName;
    private $dbUser;
    private $dbPass;

    public function __construct($dbName,$dbUser,$dbPass)
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbConnect = new PDO('mysql:host=localhost;dbname='.$this->dbName,$this->dbUser,$this->dbPass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"]);
    }
}
class action extends database
{
    public function inud($query,$values=[])
    {
        $result = $this->dbConnect->prepare($query);
        foreach ($values as $key=>$value){
            $result->bindValue($key+1,$value);
        }
        $result->execute();
    }

    public function select($query,$values=[],$fetch='fetch')
    {
        $result = $this->dbConnect->prepare($query);
        foreach ($values as $key=>$value){
            $result->bindValue($key+1,$value);
        }
        $result->execute();
        if ($fetch == "fetch"){
            return $result->fetch(PDO::FETCH_OBJ);
        }else{
            return $result->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function SecuriyInput($value)
    {
        return trim(htmlspecialchars(strip_tags(addslashes($value))));
    }

    public function DateToSHamsi($date)
    {
        $date1 = explode('-',$date);
        return gregorian_to_jalali($date1[0],$date1[1],$date1[2],'/');
    }
}
$action = new action('store_amuzeshtak','root','');