<?php

/**
 * Plugin Name: Redirección Home
 * Plugin URI:  http://www.altimea.com
 * Description: Realiza la redirección al país lo antes posible
 * Author:      Altimea
 * Author URI:  http://www.altimea.com
 * Version:     1.0.
 **/

require __DIR__.'/libraries/vendor/autoload.php';

use GeoIp2\Database\Reader;

/**
 * Class SiteCountryRedirect
 */
class SiteCountryRedirect
{
    private $clientIP;

    protected $availableCodes;
    protected $host;

    protected $cookieBlogName = 'countryIso';
    protected $cookieDays = 1;

    /**
     * SiteCountryRedirect constructor.
     */
    public function __construct()
    {
        global $appCountries;

        $this->host                 = $_SERVER['HTTP_HOST'];
        $this->availableCodes       = array_keys($appCountries->all());
        $this->clientIP             = $this->getClientIP();

    }

    /**
     * @return array $availableCodes
     */
    public function getAvailableCodes()
    {
        return $this->availableCodes;
    }

	/**
	 * Get client IP based on $_SERVER values.
	 *
	 * @param null|string $fake_ip IP String to fake geolocation
	 *
	 * @return string
	 */
    public function getClientIP($fake_ip = null)
    {
    	if($fake_ip) {
		    return $fake_ip;
	    }

	    if ($_SERVER) {
		    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
		    } else {
			    $ip_address = $_SERVER['REMOTE_ADDR'];
		    }
	    } else {
		    if (getenv('HTTP_X_FORWARDED_FOR')) {
			    $ip_address = getenv('HTTP_X_FORWARDED_FOR');
		    } elseif (getenv('HTTP_CLIENT_IP')) {
			    $ip_address = getenv('HTTP_CLIENT_IP');
		    } else {
			    $ip_address = getenv('REMOTE_ADDR');
		    }
	    }
        /**
         * List ips test
         * SV - 190.87.45.143
         * MX - 189.189.181.30
         * PA - 201.221.224.230
         * CL - 186.104.79.21
         * CO - 186.170.185.35
         */

        return $ip_address;
    }

    /**
     * Based on the geo location IP, find the country and return as ISO code.
     *
     * @param $clientIP
     * @return string
     */
    public function getCountryISOCode($clientIP)
    {
        global $appCountries;
        $iso    = $appCountries::DEFAULT_ISO;
        if (!empty($clientIP) || $clientIP !== '127.0.0.1') {
            try {
                $reader = new Reader(__DIR__.'/geoip-database/GeoLite2-Country.mmdb');
                $record = $reader->country($clientIP);

                if (!empty($record) && is_object($record) && !in_array($record->country->isoCode, $this->getAvailableCodes())) {
                    $iso = $iso;
                } elseif (!empty($record) && in_array($record->country->isoCode, $this->getAvailableCodes())) {
                    $iso = $record->country->isoCode;
                }
            } catch (Exception $e) {
                error_log($e);
            }
        }

        $this->setCountryIsoCookie($iso, true);

        return strtolower($iso);
    }

    /**
     * Set countries ISO code
     *
     * @param $countryIso
     */
    private function setCountryIsoCookie($countryIso, $upper = false)
    {
        $_countryIso = strtolower($this->validateCountryIso($countryIso));
        $_name = $this->cookieBlogName;
        if(!empty($upper)){
            $_countryIso = $this->validateCountryIso($countryIso);
        }

        setcookie($_name, $_countryIso, time() + (86400 * $this->cookieDays), '/');
    }

    /**
     * If countryIso is '404', return default value
     *
     * @param $countryIso
     *
     * @return mixed
     */
    public function validateCountryIso($countryIso){
        global $appCountries;

        return $countryIso === '404' ? $appCountries::DEFAULT_ISO : $countryIso;
    }
}

global $appCountries;

$siteCountryRedirect = new SiteCountryRedirect();

/*
 * Define global client IP.
 * @var $clientIp
 */
global $clientIp;

/*
 * Define global country ISO code.
 * @var $countryIso
 */
global $countryIso;


global $blogCountries;

/* set client IP */
$clientIp = $siteCountryRedirect->getClientIP();

/* set country ISO */
$countryIso = $siteCountryRedirect->validateCountryIso($siteCountryRedirect->getCountryISOCode($clientIp));

$blogCountries = $appCountries->all();