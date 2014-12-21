<?php
require_once(dirname(__FILE__) . '/Phad/Phad_Config.php');
require_once(dirname(__FILE__) . '/Phad/Phad_Formatter.php');

class Phad
{
    /**
     * @var Phad_Config
     */
    private $config;

    /**
     * @var Phad_Formatter
     */
    private $formatter;

    const TYPE_RIGHT = 1;
    const TYPE_LEFT  = 2;

    public function __construct($config)
    {
        try {
            $this->config = new Phad_Config($config);
        } catch (Exception $e) {
            throw $e;
        }

        $this->formatter = new Phad_Formatter($this->config);
    }

    public function format($values)
    {
        $result = array();
        foreach ($values as $k => $v) {
            $result[] = $this->formatter->format($k, $v);
        }

        return $result;
    }
}
