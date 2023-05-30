<?php

namespace Drupal\shreyansh_restaurant\Form;

use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Configuration form definition for the salutation message.
*/
class ConfigRestaurantForm extends ConfigFormBase {
	/**
	* {@inheritdoc}
	*/
	protected function getEditableConfigNames() {
		return ['codeduck_restaurant.config_form'];
	}
	/**
	* {@inheritdoc}
	*/
	public function getFormId() {
		return 'codeduck_restaurant_configuration_form';
	}
	/**
	* {@inheritdoc}
	*/
	public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('codeduck_restaurant.config_form');

		$form['shreyansh_starter'] = array(
			'#type' => 'tel',
			'#min'=>0,
			'#title' => $this->t('Set Starter Price'),
			'#description' => $this->t('Please provide starter default price'),
			'#default_value' => '200',
		);

		$form['shreyansh_sabji'] = array(
			'#type' => 'tel',
			'#min'=>0,
			'#title' => $this->t('Set Sabji Price'),
			'#description' => $this->t('Please provide sabji default price'),
			'#default_value' => '450',
		);

		$form['shreyansh_roti'] = array(
			'#type' => 'tel',
			'#min'=>0,
			'#title' => $this->t('Set Roti Price'),
			'#description' => $this->t('Please provide roti default price'),
			'#default_value' => '35',
		);

		$form['shreyansh_drinks'] = array(
			'#type' => 'tel',
			'#min'=>0,
			'#title' => $this->t('Set Drinks Price'),
			'#description' => $this->t('Please provide drinks default price'),
			'#default_value' => '40',
		);

		$form['shreyansh_desert'] = array(
			'#type' => 'tel',
			'#min'=>0,
			'#title' => $this->t('Set Desert Price'),
			'#description' => $this->t('Please provide desert default price'),
			'#default_value' => '180',
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
	public function submitForm(array &$form, FormStateInterface $form_state){
        $this->config('codeduck_restaurant.config_form')
		->set('shreyansh_starter', $form_state->getValue('shreyansh_starter'))
		->set('shreyansh_sabji', $form_state->getValue('shreyansh_sabji'))
		->set('shreyansh_roti', $form_state->getValue('shreyansh_roti'))
		->set('shreyansh_drinks', $form_state->getValue('shreyansh_drinks'))
		->set('shreyansh_desert', $form_state->getValue('shreyansh_desert'))
		->save();
		parent::submitForm($form, $form_state);
    }
}
		