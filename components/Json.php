<?php

namespace app\components;

class Json
{
    public static function encode($elem)
    {
        return self::toJson($elem);
    }

    private static function toJson($elem, $jsonString = '')
    {
        if (gettype($elem) === 'array' && self::hasNonIntegerKeys($elem)) {
            $elem = (object)$elem;
        }

        switch (gettype($elem)) {
            case 'array':
                $count = count($elem);
                $index = 0;

                $jsonString = $jsonString . '[ ';
                foreach ($elem as $key => $value) {
                    $jsonString = $jsonString .
                        self::toJson($value) .

                        ($index < $count - 1
                            ? ', '
                            : ' ');

                    $index++;
                }
                $jsonString = $jsonString . ' ]';
                break;
            case 'object':
                $count = count((array)$elem);
                $index = 0;

                $jsonString = $jsonString . '{ ';
                foreach ($elem as $key => $value) {
                    $jsonString = $jsonString .
                        self::toJson($key) . ': ' .
                        self::toJson($value) .

                        ($index < $count - 1
                            ? ', '
                            : ' ');

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

    private static function hasNonIntegerKeys($arr)
    {
        foreach (array_keys($arr) as $item) {
            if (gettype($item) !== 'integer') {
                return true;
            }
        }

        return false;
    }
}