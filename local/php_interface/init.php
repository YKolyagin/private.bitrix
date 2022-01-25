<?php
if(!function_exists('printr'))
{
    function printr($array)
    {
        GLOBAL $USER;
        if(!$USER->IsAdmin())
            return false;
        $args = func_get_args();
        if(count($args) > 1)
        {
            foreach($args as $values)
                printr($values);
        }
        else
        {
            if(is_array($array) || is_object($array))
            {
                echo "<pre>";
                print_r($array);
                echo "</pre>";
            }
            else
            {
                echo $array;
            }
        }
        return true;
    }
}
