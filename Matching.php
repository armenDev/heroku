<?php
include_once 'Connection.php';
include_once 'User.php';
/**
 * Class Users
 *
 * @author Armen Zaqaryan <armen.zaqaryan1959@gmail.com>
 */
class Matching
{
    protected $connection;
    protected $users;

    function __construct()
    {
        $this->connection = Connection::$db;
        $this->users = new User();
    }

    /**
     * @param $tmp_name
     * @return bool
     */
    public function importCamp($tmp_name)
    {
        $content = json_decode(file_get_contents($tmp_name));

        if(!$content)
            return false;

        foreach($content as $key => $value)
        {
            $stmt = $this->connection->prepare("INSERT INTO campaign(compaign_name, price, target_list) VALUES (:compaign_name, :price, :target_list)");
            $stmt->bindParam(':compaign_name', $value->compaign_name, PDO::PARAM_STR, 100);
            $stmt->bindParam(':price', $value->price, PDO::PARAM_STR, 100);
            $stmt->bindParam(':target_list', serialize($value->target_list),PDO::PARAM_LOB);
            $stmt->execute();
        }
        return true;
    }

    /**
     * @return void
     */
    public function getCamp()
    {
        $res = $this->connection->prepare("SELECT * FROM campaign ORDER  BY  campaign.price DESC;");
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param
     * @return mixed
     */
    public function search()

    {
        // this is the right version
        // $user = json_decode($this->users->createUser());

        // this is for testing, it has corresponding data with db
        $user = new  stdClass();
        $user->user = 'u3';
        //$user->profile = ['attr_A'=>'A12','attr_B'=>'B20','attr_C'=>'C5'];
        $user->profile = ['attr_A'=>'A1','attr_B'=>'B10'];

        $campaigns = $this->getCamp();
       
        foreach($campaigns as $key => $value)
        {
            $bool = true;
            $target_list = unserialize($value['target_list']);
            foreach($target_list as $target_key => $target_value)
            {
                if(array_key_exists($target_value->target,$user->profile)){
                    if(!in_array($user->profile[$target_value->target],$target_value->attr_list))
                    {
                        $bool = false;
                    }
                }
            }
            if($bool){
                return json_encode(array('winner' => $value['compaign_name']));
            }
       }

        return null;
    }
}
