<?php
    function createToken() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+-!$%ùò/à*';
        $code = '';
        $length = strlen($characters);
    
        for ($i = 0; $i < 64; $i++) {
            $index = random_int(0, $length - 1);
            $code .= $characters[$index];
        }
    
        return $code;
    }
?>