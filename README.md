# Phad

Formatter for fixed length data.

## require

php 5.2 or higher

## sample

```php
<?php
require_once './src/Phad.php';

$config = array(
	'id' => array(
		'length' => 10,
		'string' => '0'
		'type'   => Phad::TYPE_LEFT,
	),
	'name' => array(
		'length' => 10,
		'string' => ' '
		'type'   => Phad::TYPE_RIGHT,
	),
);



$phad = new Phad($config);

$data[] = array(
	'id' => 123,
	'name' => 'foo',
);
$data[] = array(
	'id' => 4567,
	'name' => 'テスト',
);

foreach ($data as $d) {
	var_dump(implode($phad->format($d), ''));
}

// "0000000123foo       "
// "0000004567テスト    "


```