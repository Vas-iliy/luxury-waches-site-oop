<?php

namespace luxury;

class Registry
{
    use TSingleton;

    public static $properties = [];

    public static function getProperty($name)
    {
        if (isset(self::$properties[$name])) {
            return self::$properties[$name];
        }
        return null;
    }

    public function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    public function getProperties() {
        return self::$properties;
    }


}