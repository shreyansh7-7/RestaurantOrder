<?php

namespace Drupal\shreyansh_restaurant;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\taxonomy\Entity\Term;

/**
* Prepares the salutation to the world.
*/
class RestaurantService {


  /**
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  public function getDesertPrice($tid, $qnt) {
    $desert_price = $this->getPrice($tid) * $qnt;
    return $desert_price;
  }

  public function getDrinkPrice($tid, $qnt) {
    $drink_price = $this->getPrice($tid) * $qnt;
    return $drink_price;
  }

  public function getStarterPrice($tid, $qnt) {
    $starter_price = $this->getPrice($tid) * $qnt;
    return $starter_price;
  }

  public function getRotiPrice($tid, $qnt) {
    $roti_price = $this->getPrice($tid) * $qnt;
    return $roti_price;
  }

  public function getSabjiPrice($tid, $qnt) {
    $sabji_price = $this->getPrice($tid) * $qnt;
    return $sabji_price;
  }

  public function getPrice($tid){
    $term = Term::load($tid);
    $price = $term->get('field_shreyansh_price')->getString();
    $addition = $term->get('field_additional_price')->getString();
   
    $configs = $this->configFactory->getEditable('shreyansh_restaurant.config_form');
    $discountCheck = $configs->get('checkbox');
    if($discountCheck == 1){
      $price += $addition;
    }
     return $price;
  }

  function getTotal($array){

    $field_total = array_sum($array);
    $configs = $this->configFactory->getEditable('shreyansh_restaurant.config_form');
    $gst_percentage = $configs->get('gst');
    $discountCheck = $configs->get('checkbox');
    $minimum_amount = $configs->get('minimum');
    $discount = $configs->get('discount');
		$final_total = $field_total + ($gst_percentage * $field_total / 100);

		//check if discount is applicable.
    if($discountCheck == 1){
      if($final_total >= $minimum_amount){
        $final_total -= $discount;
      }
    }

    return $final_total;
  }
  

  function checkterm($name = null, $voc){

    if (!empty($name)) {
      $properties['name'] = $name;
    }
    if (!empty($voc)) {
      $properties['vid'] = $voc;
    } 
		
			$terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties($properties);
    	$term = reset($terms);

    if ($term == null) {

      $term = Term::create([
        'name' => $name,
        'vid' => $voc
      ]); 

      $configs = $this->configFactory->getEditable('codeduck_restaurant.config_form');
    
      $item_price = $configs->get($voc);
    
      $term->field_shreyansh_price = $item_price;
      
      $term->save();

    }

      $item_id = $term->id();

      return $item_id;
		
  }
}