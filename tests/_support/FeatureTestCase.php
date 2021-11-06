<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class FeatureTestCase extends CIUnitTestCase
{
	use DatabaseTestTrait, FeatureTestTrait;

	/**
	 * @var SessionHandler
	 */
	protected $session;

	/**
	 * @var boolean
	 */
	protected $refresh = true;

	/**
	 * @var string
	 */
	protected $seed = 'Tests\Support\Database\Seeds\TestSeeder';

	/**
	 * @var string
	 */
	protected $basePath = SUPPORTPATH . 'Database/';

	/**
	 * @var string
	 */
	protected $namespace = 'App';
}
