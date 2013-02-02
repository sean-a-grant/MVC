<?php 
class Singleton {
    private static $_instances = array();
    
    public static function get(){
        $classname = get_called_class();
        if(!isset(self::$_instances[$classname])){
            self::$_instances[$classname] = new static();
        }
        return self::$_instances[$classname];
    }
}
?>