<?php

namespace app\components;

class Json
{
    public static function encode($elem)
    {
        return self::toJson($elem);
    }

    private static function toJson($elem, $jsonString = ''){
        switch (gettype($elem)) {
            case 'array':
                $count = count($elem);
                $index = 0;

                $jsonString  = $jsonString . '[ ';
                foreach($elem as $key => $value){
                    $jsonString = $jsonString .
                        (gettype($key) !== 'integer'
                            ? self::toJson($key) . ': '
                            : ''
                        ) .
                        self::toJson($value);

                    $index < $count-1
                        ? $jsonString = $jsonString . ', '
                        : $jsonString = $jsonString . ' ';

                    $index++;
                }
                $jsonString = $jsonString . ' ]';
                break;
            case 'object':
                $count = count((array)$elem);
                $index = 0;

                $jsonString  = $jsonString . '{ ';
                foreach($elem as $key => $value){
                    $jsonString = $jsonString .
                        self::toJson($key) . ': ' .
                        self::toJson($value);

                    $index < $count-1
                        ? $jsonString = $jsonString . ', '
                        : $jsonString = $jsonString . ' ';

                    $index++;
                }
                $jsonString = $jsonString . ' }';
                break;
            default:
                $jsonString = $jsonString . '"' . (string)$elem . '"';
                break;
        }

        return $jsonString;
    }

}