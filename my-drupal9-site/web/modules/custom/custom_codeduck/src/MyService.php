<?php

namespace Drupal\custom_codeduck;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
* Prepares the salutation to the world.
*/
class MyService {


  /**
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory, AccountProxyInterface $currentUser) {
    $this->configFactory = $config_factory;
    $this->currentUser = $currentUser; 
  }

  public function getSiteName() {
    $siteName = $this->configFactory->get('system.site')->get('name');
    return $siteName;
  }

  public function getGreeting() {
    $roles = $this->currentUser->getRoles();
    $greeting = $this->getMessage($roles);
    return $greeting;
  }
  
  public function getUserName() {
    $username = $this->currentUser->getDisplayName();
    return $username;
  }

  protected function getMessage($roles){
    
    $configs = $this->configFactory->getEditable('custom_codeduck.custom_salutation');

    if (in_array('provider', $roles)) {
      $message = $configs->get('provider');
    }
    if (in_array('customer', $roles)) {
      $message = $configs->get('customer');
    }
    if (in_array('content_editor', $roles)) {
      $message = $configs->get('content_editor');
    }
    if (in_array('administrator', $roles)) {
      $message = $configs->get('administrator');
    }
    
    return $message;
  }
  
  
}