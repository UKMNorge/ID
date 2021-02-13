<?php

namespace UKMNorge\OAuth2\ID;

use Exception;
use UKMNorge\OAuth2\ServerMain;

class UserVerification {

    
    private static $verificationTimeout = 5*60; // 5 min
    private static $passwordChangeTimeout = 1*60; // 5 min
    private static $alphabet = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Æ', 'Ø', 'Å'];
    
    public function __construct() {
        
    }

    public static function generateVerificationCode() : string {
        $from = 0;
        $to = count(static::$alphabet)-1;

        $code = static::$alphabet[rand($from, $to)] . static::$alphabet[rand($from, $to)] . static::$alphabet[rand($from, $to)];
        return $code;
    }

    // Start the verification
    // This method saves tel_nr to be used as key for verification
    public static function startVerification(string $tel_nr) : string {
        static::cleanSession();

        $vCode = static::generateVerificationCode(); 
        SessionManager::setWithTimeout('verification_code', $vCode, static::$verificationTimeout);
        SessionManager::set('verification_code_count', 3);
        SessionManager::set('verification_tel_nr', $tel_nr);

        return $vCode;
    }

    public static function triesLeft() {
        return SessionManager::get('verification_code_count');
    }

    public static function useTry() {
        $count = SessionManager::get('verification_code_count');

        if($count == null) {
            return null;
        }

        SessionManager::set('verification_code_count', $count-1);

        return SessionManager::get('verification_code_count');
    }

    // Activate change password for current session with tel_nr
    public static function setChangePasswordActive($telNr) {
        // Set waiting time to 5 min for password change
        SessionManager::setWithTimeout('changeUserPassword', $telNr, static::$passwordChangeTimeout);
    }

    // Verify the code and login
    // Returns tel_nr if the verification is accepted or it returns false
    // In case login is provided as true, it returns nothing but the login function is triggered
    public static function verify(string $telNrUser, string $userCode, $password, $login = false) {
        // Timeout
        if(!SessionManager::verifyTimeout('verification_code')) {
            static::cleanSession();
            throw new Exception('Timeout');
        }
        
        if(static::triesLeft() < 1) {
            static::cleanSession();
            throw new Exception('Brukeren har prøvd å verifisere sms-koden 3 ganger');
        }

        $telNr = SessionManager::get('verification_tel_nr');
        if($telNrUser != $telNr) {
            static::cleanSession();
            throw new Exception('Mobiltelefonnummber er feil!');
        }
        
        if (SessionManager::verify('verification_code', $userCode, true)) {
            // If login, call UserManager and login otherwise just return true
            if($login) {
                UserManager::setUserVerifyAndLogin($telNr, $password);
            }
            static::cleanSession();
            // The verification is accepted, return tel_nr
            return $telNr;
        }
        
        // If there
        static::useTry();

        return false;
    }

    // Remove the code, count and tel_nr from session
    private static function cleanSession() {
        SessionManager::remove("verification_code");
        SessionManager::remove('verification_code_count');
        SessionManager::remove('verification_tel_nr');
    }

    public static function isVerificationCompleted() : bool {
        return false;
    }

    // Add sms forward verification to DB through PDO
    public static function addSMSForwardVerification(string $telNr, string $generatedCode) : bool {
        return ServerMain::getStorage()->addSMSForward($telNr, $generatedCode);
    }

}