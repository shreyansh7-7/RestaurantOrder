<?php 

namespace Drupal\custom_codeduck\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_codeduck\MyService;


class CodeduckController extends ControllerBase {

  protected $configFactory;
  protected $service;

  public function __construct(MyService $service) {
    $this->service = $service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_codeduck.codeduck')
    );
  }
    
  
  public function getResult() {
    $siteName = $this->service->getSiteName();
    $greeting = $this->service->getGreeting();
    $username = $this->service->getUserName();
    return [ 
      '#markup' => "Welcome ".$greeting." ".$username."  Site Name : ".$siteName
    ];
  }

}