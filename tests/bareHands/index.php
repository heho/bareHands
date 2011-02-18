<?php
require_once '../../library/bareHands/Menu.php';
require_once '../../library/bareHands/MenuElement.php';



$testElement1 = new bareHands\MenuElement();
$testElement1->setId('1')
		->setClass('button')
		->setName('Button1')
		->setText('A Button');

$menu = new bareHands\Menu('TestMenu');
$menu->addMenuElement($testElement1);

echo "<pre>";
print_r($menu);

