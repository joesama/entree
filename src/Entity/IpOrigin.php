<?php

namespace Joesama\Entree\Entity;

/**
 * Retrieves the best guess of the client's actual IP address.
 * Takes into account numerous HTTP proxy headers due to variations
 * in how different ISPs handle IP addresses in headers between hops.
 *
 * @author joesama
 **/
class IpOrigin
{
    /**
     * Retrieves the best guess of the client's actual IP address.
     * Takes into account numerous HTTP proxy headers due to variations
     * in how different ISPs handle IP addresses in headers between hops.
     *
     * @return string
     *
     * @author joesama
     **/
    public function ipOrigin()
    {
        $server = collect($_SERVER);

        $ips = $server->get('HTTP_CLIENT_IP') ??
        $server->get('HTTP_X_FORWARDED_FOR') ??
        $server->get('HTTP_X_FORWARDED') ??
        $server->get('HTTP_X_CLUSTER_CLIENT_IP') ??
        $server->get('HTTP_FORWARDED_FOR') ??
        $server->get('HTTP_FORWARDED') ??
        $server->get('SERVER_ADDR');

        if (strpos($ips, ',') !== false) {
            $iplist = explode(',', $ips);

            foreach ($iplist as $ip) {
                if ($this->validate_ip($ip)) {
                    return $ip;
                }
            }
        } else {
            if ($this->validate_ip($ips)) {
                return $ips;
            } else {
                return $server->get('REMOTE_ADDR');
            }
        }
    }

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range.
     */
    protected function validate_ip($ip)
    {
        if (strtolower($ip) === 'unknown') {
            return false;
        }
        // generate ipv4 network address
        $ip = ip2long($ip);

        // if the ip is set and not equivalent to 255.255.255.255
        if ($ip !== false && $ip !== -1) {
            // make sure to get unsigned long representation of ip
            // due to discrepancies between 32 and 64 bit OSes and
            // signed numbers (ints default to signed in PHP)
            $ip = sprintf('%u', $ip);
            // do private network range checking
            if ($ip >= 0 && $ip <= 50331647) {
                return false;
            }
            if ($ip >= 167772160 && $ip <= 184549375) {
                return false;
            }
            if ($ip >= 2130706432 && $ip <= 2147483647) {
                return false;
            }
            if ($ip >= 2851995648 && $ip <= 2852061183) {
                return false;
            }
            if ($ip >= 2886729728 && $ip <= 2887778303) {
                return false;
            }
            if ($ip >= 3221225984 && $ip <= 3221226239) {
                return false;
            }
            if ($ip >= 3232235520 && $ip <= 3232301055) {
                return false;
            }
            if ($ip >= 4294967040) {
                return false;
            }
        }

        return true;
    }
} // END class IpOrigin
