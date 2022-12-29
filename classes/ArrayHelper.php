<?php

namespace Meta\Classes;

class ArrayHelper
{
    public static function getWithoutFirstElement($array)
    {
        array_shift($array);
        return $array;
    }
}
