<?php

/**
 * Model Class for Countries
 */
class Country
{
    /*
     * Default ISO CODE
     *
     * @var $countries
     */
    const DEFAULT_ISO = 'PE';

    /**
     * @var $name
     */
    public $name;

    /**
     * @var $iso
     */
    public $iso;

    /**
     * @var $metaName
     */
    public $metaName;

    /**
     * @var $moneySymbol
     */
    public $moneySymbol;

    /**
     * @var $iso4217
     */
    public $iso4217;

    /**
     * @var $currency
     */
    public $currency;

    /**
     * All countries supported by the application.
     *
     * @var $countries
     */
    private $countries;


    /**
     * Bob 'the constructor' .____.
     */
    public function __construct()
    {
        // Set all countries
        $this->setCountries();

    }

    /**
     * Define all countries supported by application.
     */
    public function setCountries()
    {
        $this->countries = [
            'CL' => [
                'iso'            => 'CL',
                'name'           => 'Chile',
                'metaName'       => 'Chile',
                'moneySymbol'    => '$',
                'iso4217'        => 'CLP',
                'currency' => '$',
                'isCommerce'     => true
            ],
            'CO' => [
                'iso'            => 'CO',
                'name'           => 'Colombia',
                'metaName'       => 'Colombia',
                'moneySymbol'    => '$',
                'iso4217'        => 'COP',
                'currency' => '$',
                'isCommerce'     => true
            ],
            'MX' => [
                'iso'            => 'MX',
                'name'           => 'México',
                'metaName'       => 'Mexico',
                'moneySymbol'    => '$',
                'iso4217'        => 'MXN',
                'currency' => '$',
                'isCommerce'     => true
            ],
            'PE' => [
                'iso'            => 'PE',
                'name'           => 'Perú',
                'metaName'       => 'Peru',
                'moneySymbol'    => 'S/.',
                'iso4217'        => 'PEN',
                'currency' => 'S/',
                'isCommerce'     => true
            ],
            'BO' => [
                'iso'            => 'BO',
                'name'           => 'Bolivia',
                'metaName'       => 'Bolivia',
                'moneySymbol'    => 'US$',
                'iso4217'        => 'USD',
                'currency' => 'US$',
                'isCommerce'     => false
            ],
            'CR' => [
                'iso'            => 'CR',
                'name'           => 'Costa Rica',
                'metaName'       => 'CostaRica',
                'moneySymbol'    => '¢',
                'iso4217'        => 'CRC',
                'currency' => '¢',
                'isCommerce'     => false
            ],
            'EC' => [
                'iso'            => 'EC',
                'name'           => 'Ecuador',
                'metaName'       => 'Ecuador',
                'moneySymbol'    => '$',
                'iso4217'        => 'USD',
                'currency' => '$',
                'isCommerce'     => false
            ],
            'SV' => [
                'iso'            => 'SV',
                'name'           => 'El Salvador',
                'metaName'       => 'Salvador',
                'moneySymbol'    => '$',
                'iso4217'        => 'USD',
                'currency' => '$',
                'isCommerce'     => false
            ],
            'GT' => [
                'iso'            => 'GT',
                'name'           => 'Guatemala',
                'metaName'       => 'Guatemala',
                'moneySymbol'    => 'Q',
                'iso4217'        => 'GTQ',
                'currency' => 'Q',
                'isCommerce'     => false
            ],
            'PA' => [
                'iso'            => 'PA',
                'name'           => 'Panamá',
                'metaName'       => 'Panama',
                'moneySymbol'    => 'B/.',
                'iso4217'        => 'PAB',
                'currency' => 'B/',
                'isCommerce'     => false
            ],
            'DO' => [
                'iso'            => 'DO',
                'name'           => 'República Dominicana',
                'metaName'       => 'RepDominicana',
                'moneySymbol'    => 'RD$',
                'iso4217'        => 'DOP',
                'currency' => 'RD$',
                'isCommerce'     => false
            ],
            'PR' => [
                'iso'            => 'PR',
                'name'           => 'Puerto Rico',
                'metaName'       => 'PuertoRico',
                'moneySymbol'    => '$',
                'iso4217'        => 'USD',
                'currency' => '$',
                'isCommerce'     => false
            ]
        ];
    }

    /**
     * @param [string] $name
     */
    private function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param [string] $iso
     */
    private function setIso($iso)
    {
        $this->iso = $iso;
    }

    /**
     * @param mixed $metaName
     */
    private function setMetaName($metaName)
    {
        $this->metaName = $metaName;
    }

    /**
     * @param mixed $moneySymbol
     */
    private function setMoneySymbol($moneySymbol)
    {
        $this->moneySymbol = $moneySymbol;
    }

    /**
     * @param mixed $iso4217
     */
    private function setIso4217($iso4217)
    {
        $this->iso4217 = $iso4217;
    }

    /**
     * @param mixed $currency
     */
    private function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get all supported countries
     *
     * @return array
     */
    public function all()
    {
        return $this->countries;
    }

    /**
     * Find a specific country by iso code
     *
     * @param $iso
     * @return Country $this
     */
    public function find($iso)
    {
        if ($iso) {
            $iso = strtoupper($iso);
            if (array_key_exists($iso, $this->countries)) {
                $this->setIso($this->countries[$iso]['iso']);
                $this->setName($this->countries[$iso]['name']);
                $this->setMetaName($this->countries[$iso]['metaName']);
                $this->setMoneySymbol($this->countries[$iso]['moneySymbol']);
                $this->setIso4217($this->countries[$iso]['iso4217']);
                $this->setCurrency($this->countries[$iso]['currency']);
            }
        }

        return $this;
    }

    /**
     * Check if a given iso code is supported by application
     *
     * @param $iso
     * @return bool
     */
    public function support($iso)
    {
        if ($iso) {
            $iso = strtoupper($iso);
            return array_key_exists($iso, $this->countries);
        }

        return false;
    }

}