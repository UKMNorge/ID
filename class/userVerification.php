<?php

namespace UKMNorge\OAuth2\ID;

use Exception;

class UserVerification {
    private static $alphabet = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Æ', 'Ø', 'Å'];
    
    public function __construct() {
        
    }

    private static function generateVerificationCode() : string {
        $from = 0;
        $to = count(static::$alphabet)-1;

        $code = static::$alphabet[rand($from, $to)] . static::$alphabet[rand($from, $to)] . static::$alphabet[rand($from, $to)];
        return $code;
    }

    // Start the verification
    // This method saves tel_nr to be used as key for verification
    public static function startVerification(string $tel_nr) : string {
        $vCode = static::generateVerificationCode();
        $_SESSION['verification_code'] = $vCode;
        // Hvor mange ganger bruker kan prøve koden
        $_SESSION['verification_code_count'] = 3;
        $_SESSION['verification_tel_nr'] = $tel_nr;

        return $vCode;
    }

    public static function getVerificationTelNr() {
        return isset($_SESSION['verification_tel_nr']) ? $_SESSION['verification_tel_nr'] : null;
        
    }

    public static function triesLeft() : int {
        if(isset($_SESSION['verification_code_count'])) {
            return $_SESSION['verification_code_count'];
        }
        return -1;
    }

    public static function useTry() : int {
        if(isset($_SESSION['verification_code_count'])) {
            $_SESSION['verification_code_count'] = $_SESSION['verification_code_count'] - 1;
            return $_SESSION['verification_code_count'];
        }
        return -1;
    }

    // Verify the code and login
    public static function verify(string $userCode, $password, $login = false) : bool {
        if(static::triesLeft() == 0) {
            throw new Exception('Brukeren har prøvd å verifisere sms-koden 3 ganger');
            static::cleanSession();
        }

        // Check if verification_code exists, userCode has 3 chars and is equals to verification_code
        if (isset($_SESSION['verification_code']) && strlen($userCode) > 2 && $_SESSION['verification_code'] == $userCode) {
            // If login, call UserManager and login otherwise just return true
            if($login) {
                UserManager::setUserVerifyAndLogin($_SESSION['verification_tel_nr'], $password);
            }
            static::cleanSession();
            // Login
            return true;
        }
        
        // If there are tries
        if(static::triesLeft() > 0) {
            static::useTry();
        }

        return false;
    }

    // Remove the code, count and tel_nr from session
    private static function cleanSession() {
        unset($_SESSION["verification_code"]);
        unset($_SESSION['verification_code_count']);
        unset($_SESSION['verification_tel_nr']);
    }

    public static function isVerificationCompleted() : bool {
        return false;
    }

}