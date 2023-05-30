<?php

namespace Drupal\sports\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

class SportsController extends ControllerBase {

	protected $database;
		
		public function __construct(Connection $database) {
    	$this->database = $database;
	
  	}

  /**
  * {@inheritdoc}
  */ 

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }
	/**
	* Renders a table of players.
	*/
	public function players() {

		

		$values = [
			['name' => 'Novak D.', 'data' => serialize(['sport' => 'tennis'])],
			['name' => 'Michael P.', 'data' => serialize(['sport' => 'swimming'])]
		];

		$fields = ['name', 'data'];
		$query = $this->database->insert('players')
			->fields($fields);
		foreach ($values as $value) {
			$query->values($value);
		}
		$result = $query->execute();

		$limit = 10; // The number of items per page.
		$query = $this->database->select('players', 'p')
		->fields('p')
		->extend('\Drupal\Core\Database\Query\PagerSelectExtender')
		->limit($limit);
		$result = $query->execute()->fetchAll();

		$header = [$this->t('Name')];
		$rows = [];

		foreach ($result as $row) {
			$rows[] = [
				$row->name
			];
		}

		$build = [];
		$build[] = [
			'#theme' => 'table',
			'#header' => $header,
			'#rows' => $rows,
		];

		return $build;
	}
}