<?php
class Phad_ConfigTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $config = array(
            'data1' => array(
                'length' => 10,
                'string' => '0',
                'type'   => Phad::TYPE_LEFT,
            ),
            'data2' => array(
                'length' => 10,
            ),
        );
        $this->config = new Phad_Config($config);
    }

    /**
     * @test
     * @expectedException Phad_InvalidConfigException
     */
    public function isSupportedParameter()
    {
        $clazz = new ReflectionClass('Phad_Config');
        $method = $clazz->getMethod('isSupportedParameter');
        $method->setAccessible(true);

        $method->invoke($this->config, 'invalid');
    }

    /**
     * @test
     * @expectedException Phad_InvalidConfigException
     */
    public function isValidLength()
    {
        $clazz = new ReflectionClass('Phad_Config');
        $method = $clazz->getMethod('isValidLength');
        $method->setAccessible(true);

        $format = array('length' => 0);
        $method->invoke($this->config, $format);
    }

    /**
     * @test
     * @expectedException Phad_InvalidConfigException
     */
    public function isValidString()
    {
        $clazz = new ReflectionClass('Phad_Config');
        $method = $clazz->getMethod('isValidString');
        $method->setAccessible(true);

        $format = array('string' => 'あ');
        $method->invoke($this->config, $format);
    }

    /**
     * @test
     */
    public function getLength()
    {
        $this->assertSame($this->config->getLength('data1'), 10);
    }

    /**
     * @test
     */
    public function getString()
    {
        $this->assertSame($this->config->getString('data1'), '0');
        $this->assertSame($this->config->getString('data2'), ' ');
    }

    /**
     * @test
     */
    public function getType()
    {
        $this->assertSame($this->config->getType('data1'), Phad::TYPE_LEFT);
        $this->assertSame($this->config->getType('data2'), Phad::TYPE_RIGHT);
    }
}
