<?php

namespace UKMNorge\OAuth2\ID;

use Exception;

class SessionManager {
    function __construct() {
        if(!isset($_SESSION)) { 
            session_start(); 
        }
    }

    public static function get(string $key) {
        return static::isSet($key) ? $_SESSION[$key] : null;
    }

    public static function getWithTimeout(string $key) {
        if(static::isWithTimeout($key)) {
            return static::get($key);
        }

        throw new Exception("Variabel er ikke tilgjengelig eller er har ikke 'timeout' type");
    }

    public static function set(string $key, $value) : void {
        $_SESSION[$key] = $value;
    }

    // Set with timeout is a variable of type array with this format:
    /*
        SESSION[key] = [SMType, value, timestamp, timeout]
        SMType - SessionManager Type - timeout
        timeout in seconds
    */
    public static function setWithTimeout(string $key, $value, int $timeout) : void {
        $_SESSION[$key] = array(
            'SMType' => 'timeout',
            'value' => $value,
            'timestamp' => $_SERVER['REQUEST_TIME'],
            'timeout' => $timeout
        );
    }

    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    // Compare saved and received value. Timeout can also be used.
    public static function verify(string $key, $valueToCompare, bool $timeout = false) : bool {
        $sesVar = static::get($key);
        
        // It is verification with timeout
        var_dump(static::verifyTimeout($key));
        if($timeout && static::verifyTimeout($key)) {
            return $sesVar['value'] == $valueToCompare;
        }
        else if(static::isArray($key) && !$timeout) {
            return $sesVar['value'] == $valueToCompare;
        }
        else if(!$timeout) {
            return $sesVar == $valueToCompare;
        }
        
        return false;
    }

    // Return true if the variable is array
    private static function isArray(string $key) : bool {
        return is_array(static::get($key));
    }

    // Return true if the variable is with timeout
    private static function isWithTimeout(string $key) : bool {
        return isSet($key) && static::get($key)['SMType'] && static::get($key)['SMType'] == 'timeout'; 

    }

    // Return true if the variable is created
    private static function isSet(string $key) : bool {
        return isset($_SESSION[$key]);
    }

    // Return true if the variable is still available based on timeout
    private static function verifyTimeout($key) : bool {
        if(static::isWithTimeout($key)) {
            $sesVar = static::getWithTimeout($key);
            $now = $_SERVER['REQUEST_TIME'];
            $timeout = $sesVar['timeout'];

            return $timeout >= ($now - $sesVar['timestamp']);
        }
        return false;
    }


}