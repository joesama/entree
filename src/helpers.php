<?php

if (!function_exists('ip_origin')) {

    /**
     * Get Origin IP.
     *
     *
     * @return string
     */
    function ip_origin()
    {
        return app('Joesama\Entree\Entity\IpOrigin')->ipOrigin();
    }
}
