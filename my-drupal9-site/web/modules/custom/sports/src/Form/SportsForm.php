<?php

namespace Drupal\sports\Form;

use Drupal\sports\Controller\SportsController;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SportsForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sports_form';
  }

	public function buildForm(array $form, FormStateInterface $form_state) {
    $form['team_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Team Name:'),
      '#required' => TRUE,
    );
    $form['team_description'] = array(
      '#type' => 'textfield',
      '#title' => t('Team Description'),
      '#required' => TRUE,
    );
    $form['team_id'] = array(
      '#type' => 'number',
			'#min' => 1,
      '#title' => t('Team Id:'),
      '#required' => TRUE,
    );
    $form['player_name'] = array (
			'#type' => 'textfield',
			'#title' => t('Player Name'),
      '#required' => TRUE,
    );
    $form['player_data'] = array (
      '#type' => 'textfield',
      '#title' => t('Player Data:'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  
	public function submitForm(array &$form, FormStateInterface $form_state) {

		$form_values = $form_state->getValues();
		
    dump($form_values);
		
    exit;
  }

}