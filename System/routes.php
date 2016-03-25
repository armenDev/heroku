<?php
class System_routes{
    private $parts;
    function __construct($x){
        $this->parts = explode("/",$x);
        $this->run();
    }
    private function run(){

        if(!empty($this->parts[0])){
            $ctrl = $this->parts[0];
            
            if($ctrl == "search" || $ctrl == "import_camp" || $ctrl == "search_auto"){
                $class_name = 'Matching';
            }else{
                $class_name = ucfirst($ctrl);
            }
            include ($class_name.'.php');

            if(class_exists($class_name)){
                $ctrl_obj = new $class_name;
                switch ($ctrl) {
                    case "campaign":
                        $x = isset($_GET['x']) ? $_GET['x'] : 0;
                        $y = isset($_GET['y']) ? $_GET['y'] : 0;
                        $z = isset($_GET['z']) ? $_GET['z'] : 0;
                        var_dump($ctrl_obj->createCampaign($x,$y,$z));
                        break;
                    case "user":
                        var_dump($ctrl_obj->createUser());
                        break;
                    case "import_camp":
                        if(isset($_FILES["file"]["tmp_name"])){
                            $file_name = $_FILES["file"]["tmp_name"];
                            var_dump($ctrl_obj->importCamp($file_name));
                        }else{
                            echo 'File not found.';
                        }
                        break; 
                    case "search_auto":
                        var_dump($ctrl_obj->search());
                        break; 
                    case "search":
                        if(isset($_POST['user'])){
                            $user = $_POST['user'];
                            var_dump($ctrl_obj->search_user($user));
                        }else{
                            echo "User info not found";
                        }
                        break; 
                    default:
                        echo "Not found the function";
                }
            }else{
                echo "Class not found";
            } 
        }else{
            return true;
        }
        
    }
    
}

