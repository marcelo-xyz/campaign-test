<?php
declare(strict_types=1);
/**
 * Web app file for handling made up basket routines of Acme Widget Co.
 *
 * @author     marcelo.xyz
 * @category   Server-Side
 * @package    MVC-SiteFile
 * @subpackage Shop
 * @since      1.0.0
 */
namespace App\AcmeWidget;

/**
 * The main basket of all.
 *
 * @author     marcelo.xyz
 * @category   Server-Side
 * @package    Shop
 * @subpackage Essential
 * @since      1.0.0
 */
final class Order{
  /**
   * @var array Delivery cost ranges per order's total.
   */
  private static $delivery_charge = [
    'R00' => ['total'=>0.01, 'cost'=>4.95],
    'R01' => ['total'=>50,   'cost'=>2.95],
    'R03' => ['total'=>90,   'cost'=>0],
  ];

  /**
   * @var OrderItem[] $basket
   * @since 1.0.0
   */
  private array $basket;

  /**
   * Order constructor.
   *
   * For the sake of brevity of this application/test, a class Customer has not been created.
   *
   * @throws \Throwable
   */
  public function __construct(){
    try{

    }catch(\Throwable $e){
      throw $e;
    }
  }
  /**
   * Add one or more items to the basket.
   *
   * @param string $item_code
   * @param int $qty The quantity to add of the $item.
   *
   * @throws \Throwable
   */
  public function addItem($item_code, int $qty=1){
    try{

      if (empty($qty) || $qty < 0) $qty = 1;
      for ($i=0; $i < $qty; $i++)
        $this->basket[] = new OrderItem($item_code);

    }catch(\Throwable $e){
      throw $e;
    }
  }
  /**
   * Returns the total of the order, including any discounts and/or fees.
   *
   * @return float
   * @throws \Throwable
   */
  public function total() : float{
    try{

      $discount_count = [];
      $total          = 0.00;
      $delivery_cost  = 0.00;

      foreach ($this->basket as $item){

        if ($item->discountSecondUnit() != 0.00){

          if (!isset($discount_count[$item->code()]))
            $discount_count[$item->code()] = ['qty'=>0, 'item'=>$item];

          $discount_count[$item->code()]['qty']++ ;
        }

        $total += $item->price();
      }


      // Apply discount for second units purchased of each product defined as having discount in the class OrderItem.
      foreach ($discount_count as &$discount_info){
        if ($discount_info['qty'] > 1){
          $total += round(
            floor($discount_info['qty'] / 2) *
            ($discount_info['item']->discountSecondUnit() * $discount_info['item']->price()),
            2
          );
        }
      }

      foreach (self::$delivery_charge as &$range_info){
        if ($total >= $range_info['total']) $delivery_cost = $range_info['cost'];
      }

      return round($total + $delivery_cost, 2);

    }catch(\Throwable $e){
      throw $e;
    }
  }
}
/**
 * Shop item for sale.
 *
 * @author     marcelo.xyz
 * @category   Server-Side
 * @package    Shop
 * @subpackage Essential
 * @since      1.0.0
 */
class OrderItem{
  /**
   * @var array Purchasable items/products.
   * @since 1.0.0
   */
  private static $items = [
    'B01' => ['name' => 'Blue Widget',  'price' => 7.95,  'discount_2nd_unit' => 0],
    'G01' => ['name' => 'Green Widget', 'price' => 24.95, 'discount_2nd_unit' => 0],
    'R01' => ['name' => 'Red Widget',   'price' => 32.95, 'discount_2nd_unit' => -0.5]
  ];
  /**
   * @var string The item/product code being handled by $this.
   */
  private $sel_code = NULL;
  /**
   * @var array Reference to the item dataset being handled by $this, which is defined upon OrderItem instantiation.
   */
  private $selected = NULL;

  /**
   * OrderItem constructor.
   *
   * @param string|NULL $item_code
   *
   * @throws \Throwable
   * @since 1.0.0
   */
  public function __construct(string $item_code=NULL){
    try{

      if (isset(self::$items[$item_code])){
        $this->sel_code = $item_code;
        $this->selected =& self::$items[$item_code];
      }else
        throw new \Exception(
          'The item id informed does not exists. Please contact the site admin.'
        );

    }catch(\Throwable $e){
      throw $e;
    }
  }
  /**
   * Returns the initial/basic price of the item.
   *
   * @return string
   * @since 1.0.0
   */
  public final function code() : string{
    return $this->sel_code;
  }
  /**
   * Returns the initial/basic price of the item.
   *
   * @return float
   * @since 1.0.0
   */
  public final function price() : float{
    return $this->selected['price'];
  }
  /**
   * Returns the discount that should be applied for every second unit purchased within same Order.
   *
   * @return float
   * @since 1.0.0
   */
  public final function discountSecondUnit() : float{
    return $this->selected['discount_2nd_unit'];
  }
  /**
   * Returns the item name.
   *
   * @return string
   * @since 1.0.0
   */
  public function name() : string{
    return $this->selected['name'];
  }
}