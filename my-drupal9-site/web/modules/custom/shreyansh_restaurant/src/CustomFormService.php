<?php

namespace Drupal\shreyansh_restaurant;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;

/**
* Prepares the salutation to the world.
*/
class CustomFormService {

  /**
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory->get('codeduck_restaurant.config_form');
  }

	//function to check term if exist or not. If doesn't exist than create one by item name given through form 
  //and return term_id.
  function checkterm($form_values){

    //get form values by key.
		$name = $form_values['item'];
		$voc = $form_values['menu'];

    //check $name & $voc means form values are entered or not if entered than put them in array called properties. 
    if (!empty($name)) {
      $properties['name'] = $name;
    }
    if (!empty($voc)) {
      $properties['vid'] = $voc;
    } 
		
    //load term by using the properties.
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties($properties);

    //reseting pointer of term to start.
    $term = reset($terms);

    //run loop if $term get somthing in it.(if term exists)
    if ($term == null) {

      //creating new term.
      $term = Term::create([
        'name' => $name,
        'vid' => $voc
      ]);

      //getting item_price from config form saved in configFactory.
      $item_price = $this->configFactory->get($voc);

      //set field item_price in new term.
      $term->field_shreyansh_price = $item_price;

      $term->save();
    }

    //get term_id using id() function.
    $item_id = $term->id();

    return $item_id;
		
  }


  //function to check if node of restaurant exist or not. If not than create new and return id of it.
  public function checkRestaurantNode($form_values) {

    //get values from form.
    $restaurant_name = $form_values['restaurant_name'];
		$rest_phone = $form_values['rest_phone'];
		$rest_city = $form_values['rest_city'];
		$rest_add1 = $form_values['rest_add1'];
		$rest_add2 = $form_values['rest_add2'];
		$restaurant_type = $form_values['restaurant_type'];
		
    //check list of nodes if it has node that user has given.
		$nids = \Drupal::entityQuery('node')
    ->condition('title', $restaurant_name)
    ->sort('nid', 'DESC')
    ->execute();
    // dump($restaurant_type);

    //run loop if node of restaurant doesn't exist.
    if(empty($nids)){
			$address = [
				'country_code' => 'IN',
				'address_line1' => $rest_add1,
				'address_line2' => $rest_add2,
				'locality' => $rest_city,
				'administrative_area' => 'GUJRAT',
			];
      $node = Node::create([
        'type'=> 'restaurant',
        'uid'=>1,
        'langcode'=>'en',
        'status'=>1,
        'title'=> $restaurant_name,
        'field_restaurant_address'=> $address,
        'field_restaurant_type'=>$restaurant_type,
      ]);
      $node->save();
      
      //get id of new node.
      $nids = $node->id();
    }
    return $nids;
  }
  

  //function to create order node programetically.
	public function creatOrderNode($form_values, $term_id, $rest_id) {

    //get values from form.
		$customer_name = $form_values['customer_name'];
		$customer_number = $form_values['phone'];
		$item = $form_values['item'];
		$quantity = $form_values['quantity'];
		$menu = $form_values['menu'];

    //create node of type order.
		$node = Node::create([

			'type'=> 'shreyansh_chhatbar',
			'uid'=>1,
			'langcode'=>'en',
			'status'=>1,
			'title'=> $customer_name,
			'field_customer_mobile_no_'=>$customer_number,
			'field_'.$menu=>$term_id,
			'field_'.$menu.'_quantity'=>$quantity,
      'field_restaurant_name'=> $rest_id
      
		]);

		$node->save();

		return $node;
	}
}
