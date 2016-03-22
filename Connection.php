<?php
/**
 * Class Connection
 *
 * @author Armen Zaqaryan <armen.zaqaryan1959@gmail.com>
 */
class Connection
{
    public static $db = false;
    private $database_type = 'pgsql';
    private $database_host = 'ec2-54-83-22-48.compute-1.amazonaws.com';
    private $database_user = 'utibzgtbmplids';
    private $database_pass = 'LlddNxBVwVNK9sI2uyvKPlmyNe';
    private $database_db = 'deon71i4ffevud';

    function __construct()
    {
        if (self::$db === false) {
            $this->connect();
        }
    }

    private function connect()
    {
        $dsn = $this->database_type . ":dbname=" . $this->database_db . ";host=" . $this->database_host;
        try {
            self::$db = new PDO($dsn, $this->database_user, $this->database_pass);
        } catch (PDOException $e) {
            die ('DB Error');
        }
    }
}
new Connection();

