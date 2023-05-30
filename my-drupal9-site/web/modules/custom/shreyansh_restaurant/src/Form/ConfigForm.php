<?php

namespace Drupal\shreyansh_restaurant\Form;

use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Configuration form definition for the salutation message.
*/
class ConfigForm extends ConfigFormBase {
	/**
	* {@inheritdoc}
	*/
	protected function getEditableConfigNames() {
		return ['shreyansh_restaurant.config_form'];
	}
	/**
	* {@inheritdoc}
	*/
	public function getFormId() {
		return 'shreyansh_restaurant_configuration_form';
	}
	/**
	* {@inheritdoc}
	*/
	public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('shreyansh_restaurant.config_form');
		$form['gst'] = array(
			'#type' => 'textfield',
				'#attributes' => array(
					' type' => 'number',
				),
			'#title' => $this->t('set GST'),
			'#description' => $this->t('Please provide the gst % you want to add.'),
			'#default_value' => $config->get('gst'),
		);

		$form['checkbox'] = array(
			'#type' => 'checkbox',
			'#title' => t('Discount Enable'),
			'#options' => $vars,
			'#default_value' => $users_vars, 
			'#description' => t('select if you want to do discount.'),
			'#default_value' => $config->get('checkbox'),
	 	);

		$form['minimum'] = array(
			'#type' => 'textfield',
				'#attributes' => array(
					' type' => 'number',
				),
			'#title' => $this->t('set minimum ammount'),
			'#description' => $this->t('Please provide the minimum amount you want to set for discount.'),
			'#default_value' => $config->get('minimum'),
		);

		$form['discount'] = array(
			'#type' => 'textfield',
				'#attributes' => array(
					' type' => 'number',
				),
			'#title' => $this->t('set discount'),
			'#description' => $this->t('Please provide the discount you want to set.'),
			'#default_value' => $config->get('discount'),
		);
		return parent::buildForm($form, $form_state);
	}
	/**
	* {@inheritdoc}
	*/
	// public function validateForm(array &$form, FormStateInterface	$form_state) {
	// 	$salutation = $form_state->getValue('gst');
	// 	if (strlen($salutation) > 20) {
	// 		$form_state->setErrorByName('salutation', $this->t('This salutation is too long'));
	// 	}
	// }
	/**
	* {@inheritdoc}
	*/
	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		
		// $node = \Drupal::entityTypeManager()->getStorage('node')->create([
		// 	'type'=> 'shreyansh_chhatbar',
		// 	'uid'=>1,
		// 	'langcode'=>'en',
		// 	'status'=>1,
		// 	'title'=> 'chaman',
		// 	'field_customer_mobile_no_'=>'1234567890',
		// 	'field_shreyansh_starter'=>['17','16'],
		// 	'field_shreyansh_starter_quantity'=>'2',
		// 	'field_shreyansh_sabji'=>'11',
		// 	'field_shreyansh_sabji_quantity'=>'1',
		// 	'field_shreyansh_roti'=>'8',
		// 	'field_shreyansh_roti_quantity'=>'2',
		// 	'field_shreyansh_drink'=>'13',
		// 	'field_shreyansh_drinks_quantity'=>'2',
		// 	'field_desert'=>'3',
		// 	'field_shreyansh_desert_quantity'=>'1',
		// 	'field_user_name'=>'18'
		// ]);
		// $node->save();

		//adding new vocabulary if doesn't exist.
		$voc_id = 'vocccc';
		$name = 'vocccc';

		$vocs = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();
		if (!isset($vocs[$voc_id])) {
			$new_vocab = \Drupal\taxonomy\Entity\Vocabulary::create(array(
				'name' => $name,
				'description' => 'This vocabulary has a special purpose',
				'vid' => $voc_id
			  ));
			$new_vocab->save();
		}
		
		$term_price = '20';
		$term = Term::create([
			'vid' => $voc_id,
			'name' => 'new term..',
			'field_price'=>'20'
	  	]);
		$fields = $term->getFields(); 
		array_push($fields ,['field_price'=>'20']);
		dump($term);
		dump($term->getFields());
		exit;
  		$term->save();

		$this->config('shreyansh_restaurant.config_form')
		->set('gst', $form_state->getValue('gst'))
		->set('checkbox', $form_state->getValue('checkbox'))
		->set('minimum', $form_state->getValue('minimum'))
		->set('discount', $form_state->getValue('discount'))
		->save();
		parent::submitForm($form, $form_state);
	}
}