<?php
require_once(dirname(__FILE__) . '/Phad_InvalidConfigException.php');

class Phad_Config
{
    /**
     * @var Array
     */
    private $parameter_keys = array(
        'length',
        'string',
        'type',
    );

    /**
     * @var Phad_Config
     */
    private $config;

    public function __construct($config)
    {
        $this->isValid($config);
        $this->config = $config;
    }

    private function isValid($config)
    {
        foreach ($config as $name => $format) {
            $this->isSupportedParameter(array_keys($format));
            $this->isValidLength($format);
            $this->isValidString($format);
        }

        return true;
    }

    private function isSupportedParameter($names)
    {
        if (is_array($names) === false) {
            $names = array($names);
        }

        foreach ($names as $n) {
            if (in_array($n, $this->parameter_keys) === false) {
                throw new Phad_InvalidConfigException("{$n} is not supported.");
            }
        }

        return true;
    }

    private function isValidLength($format)
    {
        if (isset($format['length']) === false) {
            throw new Phad_InvalidConfigException("'length' is required.");
        }

        if ($format['length'] <= 0) {
            throw new Phad_InvalidConfigException("'length' must be an integer of 1 or more.");
        }

        return true;
    }

    private function isValidString($format)
    {
        // 'string' is optional.
        if (isset($format['string']) === false) {
            return true;
        }

        if (strlen($format['string']) !== 1 || mb_strlen($format['string']) !== 1) {
            throw new Phad_InvalidConfigException("'string' must be a single byte character.");
        }

        return true;
    }

    public function getLength($key)
    {
        return $this->config[$key]['length'];
    }

    public function getString($key)
    {
        if (isset($this->config[$key]['string']) && $this->config[$key]['string'] !== '') {
            return $this->config[$key]['string'];
        }

        return ' ';
    }

    public function getType($key)
    {
        if (isset($this->config[$key]['type']) && $this->config[$key]['type'] !== '') {
            return $this->config[$key]['type'];
        }

        return Phad::TYPE_RIGHT;
    }
}
