<?php

namespace App\Utils;


class Generate
{
    /**
     * generate Code
     *
     * @return void
     */
    public static function generateCode($length = 6, $type = 'int')
    {
        $int = '0123456789';
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($type == 'int') {
            return substr(str_shuffle(str_repeat($int, 5)), 0, $length);
        } else {
            return substr(str_shuffle(str_repeat($char, 5)), 0, $length);
        }
    }

   
}
