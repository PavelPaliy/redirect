<?php


namespace redirect\src\Models;
include($_SERVER['DOCUMENT_ROOT']."/config.php");

class Generator
{
    public static function generate(){
        $symvols = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        $str = '';
        for($i=0; $i<4; $i++)
        {
            $rand = rand(0, 51);
            $str .= $symvols[$rand];
        }
        return $str;
    }
    public function addAlias($link)
    {
        try {
            $dbh = new \PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PASS);
            $str = self::generate();
            $stmtAl = $dbh->prepare("SELECT * from links where alias= :str;");
            $stmtAl->execute(['str' => $str]);
            while ($stmtAl->rowCount() != 0) {
                $str = self::generate();
                $stmtAl = $dbh->prepare("SELECT * from links where alias= :str;");
                $stmtAl->execute(['str' => $str]);
            }
            $stmt = $dbh->prepare("INSERT INTO links (link, alias) values (?, ?)");
            $stmt->execute([$link, $str]);
            echo $_SERVER['SERVER_NAME']."/-".$str;

        }catch (\PDOException $e)
        {
            echo "Ошибка выполнения запроса".$e->getMessage();
        }
    }
    public function validateLink($link)
    {
        try {
            $dbh = new \PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PASS);
            $stmt = $dbh->prepare("SELECT * from links where link= :link;");
            $stmt->execute(['link' => $link]);
            return $stmt->rowCount();
        }catch (\PDOException $e)
        {
            echo "Ошибка выполнения запроса".$e->getMessage();
        }
    }
    public function getAlias($link)
    {
        try {
            $dbh = new \PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PASS);
            $stmt = $dbh->prepare("SELECT * from links where link= :link;");
            $stmt->execute(['link' => $link]);
            return $_SERVER['SERVER_NAME']."/-".$stmt->fetch()['alias'];
        }catch (\PDOException $e)
        {
            echo "Ошибка выполнения запроса".$e->getMessage();
        }
    }
    public function redirect($alias){
        try{
            $connect = new \PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PASS);
            $stmt = $connect->prepare("Select link from links where alias= :alias;");
            $stmt->execute(['alias' => $alias]);
            header("location:".$stmt->fetch()['link']);

        } catch (\PDOException $e)
        {
            echo "Ошибка выполнения запроса".$e->getMessage();
        }
    }
}