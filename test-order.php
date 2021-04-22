<?php
include_once 'app/Order.php';

$order = new Order();

$order->addItem('B01', 2);
$order->addItem('R01', 3);

echo $order->total();