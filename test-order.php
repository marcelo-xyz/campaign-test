<?php
include_once 'app/Order.php';

try{

  $order = new Order();

  $order->addItem('B01', 2);
  $order->addItem('R01', 3);

  echo 'Order Total: $'. $order->total();

}catch(\Throwable $e){
  echo 'Unexpected error.. '. $e->getMessage();
}