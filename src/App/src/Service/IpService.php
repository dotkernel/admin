<?php

declare(strict_types=1);

namespace Frontend\App\Service;

/**
 * Class AdminService
 * @package Frontend\App\Service
 */
class IpService
{
    /**
     * @param array $server
     * @return array|false|mixed|string
     */
    public static function getUserIp(array $server): mixed
    {
        if (!empty($server)) {
            // check if HTTP_X_FORWARDED_FOR is public network IP
            if (isset($server['HTTP_X_FORWARDED_FOR']) && self::validIp($server['HTTP_X_FORWARDED_FOR']) == 'public') {
                $realIp = $server['HTTP_X_FORWARDED_FOR'];
            // check if HTTP_CLIENT_IP is public network IP
            } elseif (isset($server['HTTP_CLIENT_IP']) && self::validIp($server['HTTP_CLIENT_IP']) == 'public') {
                $realIp = $server['HTTP_CLIENT_IP'];
            } else {
                $realIp = $server['REMOTE_ADDR'];
            }
        } else {
            // check if HTTP_X_FORWARDED_FOR is public network IP
            if (getenv('HTTP_X_FORWARDED_FOR') && self::validIp(getenv('HTTP_X_FORWARDED_FOR')) == 'public') {
                $realIp = getenv('HTTP_X_FORWARDED_FOR');
            // check if HTTP_CLIENT_IP is public network IP
            } elseif (getenv('HTTP_CLIENT_IP') && self::validIp(getenv('HTTP_CLIENT_IP')) == 'public') {
                $realIp = getenv('HTTP_CLIENT_IP');
            } else {
                $realIp = getenv('REMOTE_ADDR');
            }
        }

        return $realIp;
    }

    /**
     * @param string $ip
     * @return false|string
     */
    public static function validIp(string $ip): bool|string
    {
        // special cases that return private are the loopback address and IPv6 addresses
        if ($ip == '127.0.0.1' || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 'private';
        }

        // check if the ip is valid
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // check wether it's private or not
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
                return 'public';
            }

            return 'private';
        }

        // not a valid ip
        return false;
    }
}
