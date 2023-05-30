<?php

namespace Drupal\hello_world;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
* Prepares the salutation to the world.
*/
class HelloWorldSalutation {
  
  /**
  * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
  */
  protected $eventDispatcher;
  protected $config_factory;
  /**
  * HelloWorldSalutation constructor.
  *
  * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
  * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
  */

  public function __construct(ConfigFactoryInterface $config_factory, EventDispatcherInterface $eventDispatcher) {
    $this->config_factory = $config_factory;
    $this->eventDispatcher = $eventDispatcher;
  }


  public function getSalutation() {
    $config_factory = $this->config_factory->get('hello_world.custom_salutation');
    $salutation = $config_factory->get('salutation');
    if ($salutation != "") {
      $event = new SalutationEvent();
      $event->setValue($salutation);
      $event = $this->eventDispatcher->dispatch(SalutationEvent::EVENT, $event);
      return $event->getValue();
    }
    // $time = new \DateTime();

    // if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
    //     return $this->t('Good morning world');
    // }
    // if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
    //     return $this->t('Good afternoon world');
    // }
    // if ((int) $time->format('G') >= 18) {
    //     return $this->t('Good evening world');
    // }
  }
}
