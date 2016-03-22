<?php
/**
 * Class Campaign
 *
 * @author Armen Zaqaryan <armen.zaqaryan1959@gmail.com>
 */
class Campaign{
    private $alphabet = [];

    function __construct()
    {
        $this->alphabet = range('A', 'Z');
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $z
     * @return mixed
     */
    public function createCampaign($x = 100,$y = 26,$z = 10000)
    {
        if($x > 100 || $y > 26 || $z > 10000)
            return false;
        $campaigns = [];
        for($i = 0; $i < $z; ++$i)
        {
            $target_list = [];
            for($j = 0; $j < rand(0,$y); ++$j)
            {
                $attr_list = [];
                for($k = 0; $k < rand(0,$x); ++$k)
                {
                    array_push ($attr_list,$this->alphabet[$j].$k);
                }
                $target = new  stdClass();
                $target->target = 'attr_'.$this->alphabet[$j];
                $target->attr_list = $attr_list;
                array_push ($target_list,$target);
            }

            $campaign = new  stdClass();
            $campaign->compaign_name = 'compaign_name'.$i;
            $campaign->price = rand();
            $campaign->target_list = $target_list;
            array_push ($campaigns,$campaign);
        }

        return json_encode($campaigns);
    }
}