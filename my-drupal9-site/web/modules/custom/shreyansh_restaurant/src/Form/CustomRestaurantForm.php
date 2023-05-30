<?php

namespace Drupal\shreyansh_restaurant\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
Use Drupal\taxonomy\Entity\Vocabulary;
Use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\path_alias\Entity\PathAlias;

class CustomRestaurantForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_restaurant_form';
  }

  //creating custom form to take data from user.
	public function buildForm(array $form, FormStateInterface $form_state) {

    //get vocabularies and terms according to them.
    $vocnames = $this->getVocabulary();
    $tids=[1,2];
    foreach($tids as $tid){
      $rest_types[$tid] = Term::load($tid)->getName();
    }

    $form['customer_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
    );

    $form['customer_details'] = array(
      '#type' => 'details',
      '#title' => t('Enter Customer Details:'),
      '#open' => TRUE
    );
    
    $form['customer_details']['mail'] = array(
      '#type' => 'email',
      '#title' => t('mail'),
      '#required' => TRUE,
    );

    $form['customer_details']['field_customer_mobile_no_'] = array (
      '#type' => 'tel',
      '#title' => t('Contact Number'),
      '#required' => TRUE,
    );

    $form['customer_details']['city'] = array (
      '#type' => 'textfield',
      '#title' => t('city'),
      '#required' => TRUE,
    );
    $form['customer_details']['zipcode'] = array (
      '#type' => 'tel',
      '#title' => ('zipcode'),
      '#required' => TRUE,
    );
    
    $form['customer_details']['add1'] =  array (
      '#type' => 'textfield',
      '#title' => ('address line 1'),
      '#required' => TRUE,
    );

    $form['customer_details']['add2'] = array (
      '#type' => 'textfield',
      '#title' => ('address line 2'),
      '#required' => TRUE,
    );
    
    $form['menu'] = array (
      '#type' => 'select',
      '#title' => ('Select item:'),
      '#options' => $vocnames,
      '#required' => TRUE
    );

    $form['item'] = array(
      '#type' => 'textfield',
      '#title' => t('Item :'),
      '#required' => TRUE,
    );

    $form['quantity'] = array (
      '#type' => 'number',
      '#title' => t('Quantity'),
      '#min'=> 1,
      '#required' => TRUE,
    );

    $form['field_restaurant_name'] = array (
      '#type' => 'textfield',
      '#title' => t('Restaurant Name :'),
      '#required' => TRUE,
    );

    $form['restaurant_details'] = array(
      '#type' => 'details',
      '#title' => t('Enter Restaurant Details:'),
      '#open' => TRUE
    );

    $form['restaurant_details']['rest_mail'] = array(
      '#type' => 'email',
      '#title' => t('mail'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['rest_phone'] = array (
      '#type' => 'tel',
      '#title' => t('Contact Number'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['rest_city'] = array (
      '#type' => 'textfield',
      '#title' => t('city'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['rest_zipcode'] = array (
      '#type' => 'tel',
      '#title' => ('zipcode'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['rest_add1'] =  array (
      '#type' => 'textfield',
      '#title' => ('address line 1'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['rest_add2'] = array (
      '#type' => 'textfield',
      '#title' => ('address line 2'),
      '#required' => TRUE,
    );

    $form['restaurant_details']['field_restaurant_type'] = array (
        '#type' => 'select',
        '#title' => ('Select item:'),
        '#options' => $rest_types,
        '#required' => TRUE
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  //actions to do when form is submitting
	public function submitForm(array &$form, FormStateInterface $form_state) {

    \Drupal::messenger()->addMessage(t("Submitted!!"));

    //get all values of form in a single array.
    $form_values = $form_state->getValues();

    //calling a service from drupal.
    $service = \Drupal::service('shreyansh_restaurant.custom_restaurant');

    //get term_id by using service checkterm method.
    $term_id = $service->checkterm($form_values);

    //get rest_id by using checkRestaurantNode method.
    $rest_id = $service->checkRestaurantNode($form_values);

    //create node by using creatOrderNode method.
    $node = $service->creatOrderNode($form_values, $term_id, $rest_id);

    //using url formroute function to change the url of node when created.
    $url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
    $form_state->setRedirectUrl($url);
  }

  //function to get vocabulary names using lable of vocabularies.
  function getVocabulary($var = null){
    $vocabularies = Vocabulary::loadMultiple();
    foreach($vocabularies as $key => $value ) {
      $vocnames[$key] = $value->label();
    }
    unset($vocnames[5], $vocnames[6], $vocnames[7]);
    if($var != null){
      return $vocnames[$var];
    }

    return $vocnames;
    
  }

}
  //
    // $path_alias = PathAlias::create([
    //   'path' => '/node/' . $node->id(),
    //   'alias' => '/'.$customer_name.'/'. $node->id(),
    // ]);
    // $path_alias->save();
    
    //

    // $form_state->setRedirect('entity.node.canonical', ['node' => $node->id()]);