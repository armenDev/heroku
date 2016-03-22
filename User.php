<?php
include_once 'Connection.php';
/**
 * Class Users
 *
 * @author Armen Zaqaryan <armen.zaqaryan1959@gmail.com>
 */
class User
{
    protected $connection;
    private $alphabet = [];

    function __construct()
    {
        $this->connection = Connection::$db;
        $this->alphabet = range('A', 'Z');
    }

    /**
     * @return int
     */
    private function getCurrentCount()
    {
        $res = $this->connection->prepare("SELECT * FROM settings WHERE name = 'counter'");
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $this->connection->prepare("UPDATE settings SET value = ".$row['value']." + 1 WHERE name = 'counter'")->execute();
        return intval($row['value']);
    }

    /**
     * @param int $currentCount
     * @return int
     */
    private function getProfileCount($currentCount)
    {
        $ProfileCount = $currentCount - intval($currentCount/26)*26;
        return ($ProfileCount == 0)?26:$ProfileCount;
    }

    /**
     * @return JSON
     */
    public function createUser()
    {
        $currentCount = $this->getCurrentCount();
        $profileCount = $this->getProfileCount($currentCount);

        $profile = [];
        for($i = 0; $i < $profileCount; ++$i)
        {
            $profile['attr_'.$this->alphabet[$i]] = $this->alphabet[$i].rand(0,200);
        }

        $user = new  stdClass();
        $user->user = 'u'.$currentCount;
        $user->profile = $profile;

        return json_encode($user);
    }
}