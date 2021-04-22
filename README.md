# Acme Widget Co

Acme Widget Co are the leading provider of made up widgets and they’ve contracted you to create a proof of concept for their new sales system.

They sell three products –

To incentivise customers to spend more, delivery costs are reduced based on the amount spent. Orders under $50 cost $4.95. 

For orders under $90, delivery costs $2.95. Orders of $90 or more have free delivery.

They are also experimenting with special offers. 

The initial offer will be “buy one red widget, get the second half price”.

## How it works

You will find a class at [**app/Order.php.js**](app/Order.php)

Upon instantiation of the class `Order` you can add items (`OrderItem`) via method `Order::addItem(<item_code>, <quantity to add>)`.

Once you have loaded items into Order, you can get the total via method `Order::total()`.   

Here's an example:

``` php
include_once 'app/Order.php';

try{

  $order = new Order();

  $order->addItem('B01', 2);
  $order->addItem('R01', 3);

  echo 'Order Total: $'. $order->total();

}catch(\Throwable $e){
  echo 'Unexpected error.. '. $e->getMessage();
}

```

## License

Free of charge!