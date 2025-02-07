<?php
declare(strict_types=1);
/**
 * This file is part of WebStone\Redkit.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebStone\Redkit;

class Response
{
    const PARSE_ASSOC_ARRAY = 1;
    const PARSE_INTEGER     = 2;
    const PARSE_TIME        = 3;
    const PARSE_INFO        = 4;
    const PARSE_GEO_ARRAY   = 5;
    const PARSE_CLIENT_LIST = 6;

    public static function parse($type, $response)
    {
        switch ($type) {
            case self::PARSE_ASSOC_ARRAY:
                return self::parseAssocArray( $response );
            case self::PARSE_INTEGER:
                return self::parseInteger( $response );
            case self::PARSE_TIME:
                return self::parseTime( $response );
            case self::PARSE_INFO:
                return self::parseInfo( $response );
            case self::PARSE_GEO_ARRAY:
                return self::parseGeoArray( $response );
            case self::PARSE_CLIENT_LIST:
                return self::parseClientList( $response );
            default:
                return $response;
        }
    }

    public static function parseAssocArray($response)
    {
        if (!is_array( $response )) {
            return $response;
        }
        $array = [];
        for ($i = 0, $count = count( $response ); $i < $count; $i += 2) {
            $array[$response[$i]] = $response[$i + 1];
        }

        return $array;
    }

    public static function parseClientList($response)
    {
        if (!is_string( $response )) {
            return $response;
        }
        $array = [];
        foreach (explode( "\n", trim( $response ) ) as $client) {
            $c = [];
            foreach (explode( ' ', trim( $client ) ) as $param) {
                $args = explode( '=', $param, 2 );
                if (isset( $args[0], $args[1] ) && ($key = trim( $args[0] ))) {
                    $c[$key] = trim( $args[1] );
                }
            }
            if ($c) {
                $array[] = $c;
            }
        }

        return $array;
    }

    public static function parseGeoArray($response)
    {
        if (!is_array( $response )) {
            return $response;
        }
        $array = [];
        for ($i = 0, $count = count( $response ); $i < $count; $i += 1) {
            $array[array_shift( $response[$i] )] = $response[$i];
        }

        return $array;
    }

    public static function parseInfo($response)
    {
        if (!$response) {
            return $response;
        }
        $response = trim( (string)$response );
        $result   = [];
        $link     = &$result;
        foreach (explode( "\n", $response ) as $line) {
            $line = trim( $line );
            if (!$line) {
                $link = &$result;
                continue;
            } elseif ($line[0] === '#') {
                $section          = trim( $line, '# ' );
                $result[$section] = [];
                $link             = &$result[$section];
                continue;
            }
            list( $key, $value ) = explode( ':', $line, 2 );
            $link[trim( $key )] = trim( $value );
        }
        if (count( $result ) === 1 && isset( $section )) {
            return $result[$section];
        }

        return $result;
    }

    public static function parseInteger($response)
    {
        return (int)$response;
    }

    public static function parseTime(array $response)
    {
        if (is_array( $response ) && count( $response ) === 2) {
            if (($len = strlen( $response[1] )) < 6) {
                $response[1] = str_repeat( '0', 6 - $len ).$response[1];
            }

            return implode( '.', $response );
        }

        return $response;
    }
}

/* End of file Response.php */
