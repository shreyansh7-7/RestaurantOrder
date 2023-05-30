<?php

namespace Drupal\hello_world\EventSubscriber;

use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;

/**url
* Subscribes to the Kernel Request event and redirects to the homepage
* when the user has the "non_grata" role.
*/

class HelloWorldRedirectSubscriber implements EventSubscriberInterface {

	/**
	* @var \Drupal\Core\Session\AccountProxyInterface
	*/

	protected $currentUser;

	/**
	* HelloWorldRedirectSubscriber constructor.
	*
	* @param \Drupal\Core\Session\AccountProxyInterface $currentUser
	*/

	public function __construct(AccountProxyInterface $currentUser, RouteMatchInterface $current_route_match) {
		$this->currentUser = $currentUser;
		$this->current_route_match = $current_route_match;
	}

	/**
	* {@inheritdoc}
	*/

	public static function getSubscribedEvents() {
		$events[KernelEvents::REQUEST][] = ['onRequest', 0];
		return $events;
	}

	/**
	* Handler for the kernel request event.
	*
	* @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
	*/

	public function onRequest(GetResponseEvent $event) {

		/** @var Request $request */

		$request = $event->getRequest();
		$path = $request->getPathInfo();
		$route_name = $this->current_route_match->getRouteName();

		if ($route_name !== 'hello_world.hello') {
			return;
		}

		$roles = $this->currentUser->getRoles();

		if (in_array('customer', $roles)) {
			$url = Url::fromUri('internal:/');
			$event->setResponse(new RedirectResponse($url->toString()));
		}
		
	}
}