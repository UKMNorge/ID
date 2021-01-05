<?php

if(!isset($_SESSION)) {
    session_start(); 
}

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
    public static function startVerification() : string {
        $vCode = static::generateVerificationCode();
        $_SESSION['verification_code'] = $vCode;

        return $vCode;
    }

    // Verify the code
    public static function verify(string $userCode) : bool {
        // Check if verification_code exists, userCode has 3 chars and is equals to verification_code
        if (isset($_SESSION['verification_code']) && strlen($userCode) === 3 && $_SESSION['verification_code'] === $userCode) {
            // Remove the verification_code from session
            unset($_SESSION["verification_code"]);
            return true;
        }
        // Remove the verification_code from session, so trying the code again is impossible
        // 3 times
        unset($_SESSION["verification_code"]);
        return false;
    }

}