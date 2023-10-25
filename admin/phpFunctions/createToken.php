<?php
    function createToken() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+-!';
        $code = '';
        $length = strlen($characters);
    
        for ($i = 0; $i < 32; $i++) {
            $index = random_int(0, $length - 1);
            $code .= $characters[$index];
        }
    
        return $code;
    }
?>