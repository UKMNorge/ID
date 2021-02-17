<?php

namespace UKMNorge\OAuth2\ID;

use Exception;

class SessionManager {
    public function __construct() {
        
    }

    /**
     * Get variable from SESSION
     *
     * @param string $key
     * @return string|null
    */
    public static function get(string $key) {
        return static::isSet($key) ? $_SESSION[$key] : null;
    }

    /**
     * Get variable from SESSION of type (SMType) 'timeout'
     *
     * @param string $key
     * @return array('SMType' => string, 'value' => string, 'timeout' => int) | null
    */
    public static function getWithTimeout(string $key) {
        if(static::isSMTypeTimeout($key)) {
            return static::get($key);
        }

        return null;
    }

    public static function getValueWithTimeout(string $key) {
        // Not found
        if(!static::isSet($key)) {
            return null;
        }

        if(static::verifyTimeout($key)) {
            return static::getWithTimeout($key)['value'];
        }
        throw new Exception('The variable is not available because of timeout');
    }


    /**
     * Add variable to SESSION
     *
     * @param string $key
     * @param string|bool|int $value
     * @return void
    */
    public static function set(string $key, $value) : void {
        $_SESSION[$key] = $value;
    }

    /**
     * Set variable into SESSION with timeout
     * Format saved in SESSION: SESSION[key] = [SMType, value, timestamp, timeout]
     * SMType - SessionManager Type = 'timeout'
     *
     * @param string $key
     * @param string|bool|int $value
     * @param int $timeout
     * @return void
    */
    public static function setWithTimeout(string $key, $value, int $timeout) : void {
        $_SESSION[$key] = array(
            'SMType' => 'timeout',
            'value' => $value,
            'timestamp' => $_SERVER['REQUEST_TIME'],
            'timeout' => $timeout
        );
    }

    /**
     * Remove variable from SESSION
     *
     * @param string $key
     * @return void
    */
    public static function remove($key) : void {
        unset($_SESSION[$key]);
    }

    /**
     * Compare saved and received value. Timeout can also be used.
     * To verify with timeout, the timeout must be true
     *
     * @param string $key
     * @param string|bool|int $valueToCompare
     * @param bool $timeout
     * @return bool
    */
    public static function verify(string $key, $valueToCompare, bool $timeout = false) : bool {
        $sesVar = static::get($key);
        
        // It is verification with timeout
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

    /**
     * Checks if the variable is array
     *
     * @param string $key
     * @return bool
    */
    private static function isArray(string $key) : bool {
        return is_array(static::get($key));
    }

    /**
     * Checks if the variable is of type 'timeout'
     *
     * @param string $key
     * @return bool
    */
    private static function isSMTypeTimeout(string $key) : bool {
        return isSet($key) && static::get($key)['SMType'] && static::get($key)['SMType'] == 'timeout'; 

    }

    /**
     * Checks if the variable exists in SESSION
     *
     * @param string $key
     * @return bool
    */
    public static function isSet(string $key) : bool {
        return isset($_SESSION[$key]);
    }

    /**
     * Verifies if the variable is still available based on 'timeout' attribute
     * The variable must pass the isSMTypeTimeout() with true value
     *
     * @param string $key
     * @return bool
    */
    public static function verifyTimeout($key) : bool {
        if(static::isSMTypeTimeout($key)) {
            $sesVar = static::getWithTimeout($key);
            $now = $_SERVER['REQUEST_TIME'];
            $timeout = $sesVar['timeout'];

            return $timeout >= ($now - $sesVar['timestamp']);
        }
        return false;
    }
}