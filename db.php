<?php

class DB
{
    private $link;
    public $err;

    public function connect()
    {
        $this->link = new mysqli(
            Config::$server, Config::$user, Config::$pwd, Config::$db
        );
        if(!$this->link)
        {
            return false;
        }
        $this->runQuery("SET NAMES 'UTF-8'");
        return true;
    }

    public function disconnect()
    {
        $this->link->close();
        unset($this->link);
    }

    public function runQuery($sql)
    {
        if(!$this->link)
        {
            $this->connect();
        }
        $res = $this->link->query($sql);
        if(!$res)
        {
            $this->err = $this->link->error;
        }
        return $res;
    }

    public function getArrayFromQuery($sql)
    {
        $res_arr = [];
        $rs = $this->runQuery($sql);
        while($row = $rs->fetch_assoc())
        {
            $res_arr[] = $row;
        }
        return $res_arr;
    }

}