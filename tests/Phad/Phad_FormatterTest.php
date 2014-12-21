<?php
class Phad_FormatterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $config = array(
            'data1' => array(
                'length' => 10,
                'string' => '0',
                'type'   => Phad::TYPE_RIGHT,
            ),
        );
        $this->formatter = new Phad_Formatter(new Phad_Config($config));
    }

    /**
     * @test
     * @dataProvider getLengthProvider
     */
    public function getLength($string, $expect)
    {
        $clazz = new ReflectionClass('Phad_Formatter');
        $method = $clazz->getMethod('getLength');
        $method->setAccessible(true);

        $this->assertSame($method->invoke($this->formatter, $string), $expect);
    }

    public function getLengthProvider()
    {
        return array(
            array('abcdefg', 7),
            array('あいうえお', 10),
            array('aあbいcうdえeお', 15),
        );
    }

    /**
     * @test
     * @dataProvider truncateProvider
     */
    public function truncate($value, $length, $expect)
    {
        $clazz = new ReflectionClass('Phad_Formatter');
        $method = $clazz->getMethod('truncate');
        $method->setAccessible(true);

        $this->assertSame($method->invoke($this->formatter, $value, $length), $expect);
    }

    public function truncateProvider()
    {
        return array(
            array('abcdefg', 3, 'abc'),
            array('あいうえお', 4, 'あい'),
            array('あいうえお', 5, 'あい'),
            array('abcdefg', 7, 'abcdefg'),
            array('あいうえお', 10, 'あいうえお'),
        );
    }

    /**
     * @test
     * @dataProvider paddingProvider
     */
    public function padding($value, $length, $string, $type, $expect)
    {
        $clazz = new ReflectionClass('Phad_Formatter');
        $method = $clazz->getMethod('padding');
        $method->setAccessible(true);

        $this->assertSame($method->invoke($this->formatter, $value, $length, $string, $type), $expect);
    }

    public function paddingProvider()
    {
        return array(
            array('abc', 10, ' ', Phad::TYPE_RIGHT, 'abc       '),
            array('あいう', 10, '0', Phad::TYPE_LEFT, '0000あいう'),
            array('abc', 3, ' ', Phad::TYPE_RIGHT, 'abc'),
            array('あいう', 6, '0', Phad::TYPE_LEFT, 'あいう'),
        );
    }
}
