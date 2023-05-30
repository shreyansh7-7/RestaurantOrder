<?php
namespace Drupal\custom_codeduck\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
* Configuration form definition for the salutation message.
*/
class CodeduckConfigurationForm extends ConfigFormBase {
    /**
    * {@inheritdoc}
    */
    protected function getEditableConfigNames() {
        return ['custom_codeduck.custom_salutation'];
    }

    /**
    * {@inheritdoc}
    */
    public function getFormId() {
        return 'custom_codeduck_salutation_configuration';
    }

    /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('custom_codeduck.custom_salutation');
        $form['provider'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('set config'),
            '#description' => $this->t('Please provide the role you want to set.'),
            '#default_value' => $config->get('provider'),
        );
        $form['customer'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('set config'),
            '#description' => $this->t('Please provide the role you want to set.'),
            '#default_value' => $config->get('customer'),
        );
        $form['content_editor'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('set config'),
            '#description' => $this->t('Please provide the role you want to set.'),
            '#default_value' => $config->get('content_editor'),
        );
        $form['administrator'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('set config'),
            '#description' => $this->t('Please provide the role you want to set.'),
            '#default_value' => $config->get('administrator'),
        );

        return parent::buildForm($form, $form_state);
    }
    /**
    * {@inheritdoc}
    */
    // public function validateForm(array &$form, FormStateInterface   $form_state) {
    //     $salutation = $form_state->getValue('salutation');
    //     if (strlen($salutation) > 20) {
    //         $form_state->setErrorByName('salutation', $this->t('This salutation is too long'));
    //     }
    // }
    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->config('custom_codeduck.custom_salutation')
        ->set('provider', $form_state->getValue('provider'))
        ->set('customer', $form_state->getValue('customer'))
        ->set('content_editor', $form_state->getValue('content_editor'))
        ->set('administrator', $form_state->getValue('administrator'))
        ->save();
        parent::submitForm($form, $form_state);
    }
}