<?php
class Phad_Formatter
{
    /**
     * @var Phad_Config
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function format($key, $value)
    {
        $length     = $this->config->getLength($key);
        $string     = $this->config->getString($key);
        $type       = $this->config->getType($key);

        if ($this->getLength($value) === (int)$length) {
            return $value;
        }

        if ($this->getLength($value) > (int)$length) {
            $value = $this->truncate($value, $length);
        }

        return $this->padding($value, $length, $string, $type);
    }

    private function getLength($value)
    {
        $length = 0;
        foreach ($this->splitToChars($value) as $char) {
            $length += (strlen($char) === 1) ? 1 : 2;
        }

        return $length;
    }

    private function truncate($value, $length)
    {
        $ret = '';
        foreach ($this->splitToChars($value) as $char) {
            if ($this->getLength($ret . $char) > $length) {
                return $ret;
            }

            $ret .= $char;
        }

        return $ret;
    }

    private function padding($value, $length, $string, $type)
    {
        while ($this->getLength($value) < $length) {
            if ($type === Phad::TYPE_LEFT) {
                $value = $string . $value;
            } else {
                $value .= $string;
            }
        }

        return $value;
    }

    private function splitToChars($value)
    {
        return preg_split('/(?<!^)(?!$)/u', $value, null, PREG_SPLIT_NO_EMPTY);
    }
}
