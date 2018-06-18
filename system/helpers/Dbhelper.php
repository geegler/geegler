<?php

namespace System\Helpers;
use \PDO;

class DbHelper
{

    protected $dbcon;
    public function __construct($dbcredits = array())
    {
        //require_once('db_config.php');
        if (is_array($dbcredits))
        {
            $host = $dbcredits['host'];
            $db_name = $dbcredits['dbname'];
            $db_user = $dbcredits['dbuser'];
            $db_pass = $dbcredits['dbpass'];
        }

        try
        {
            $this->dbcon = new PDO('mysql:host=' . $host . ';dbname=' . $db_name .
                ';charset=utf8', $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));

            $this->dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            //echo 'connected';
            return true;

        }
        catch (PDOException $e)
        {
            return false;
            die('There is a connection error: ' . $e->getMessage());
        }
    }

    public function setConnection()
    {
        if ($this->dbcon)
        {
            return $this->dbcon;
        } else
        {
            return false;
        }
    }
}
