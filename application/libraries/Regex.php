<?php

final class Regex
{

    function _genRegex($post, $type)
    {

        switch ($type) {
            case 'RGXINT': // just for integer type
                $rx = '/[^0-9]/';
                break;
            case 'RGXFLOAT':
                $rx = '/[^0-9.]/';
                break;
            case 'RGXAZ': // for alphabhet
                $rx = '/[^a-zA-Z]/';
                break;
            case 'RGXALNUM':
                $rx = '/[^a-zA-Z0-9]/';
                break;
            case 'RGXALNUMDOT':
                $rx = '/[^a-zA-Z0-9.]/';
                break;
            case 'RGXQSL':
                $rx = "/[\"'\\\\]/";
                break;
            case 'RGXFILENAME':
                $rx = "/[^a-zA-Z0-9._]/";
                break;

            default:
                $rx = "/[\"'\\\\]/";
                break;
        }

        $post = preg_replace($rx, "", $post);

        return $post;


    }
}