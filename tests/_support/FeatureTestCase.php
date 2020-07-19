<?php namespace Tests\Support;

use CodeIgniter\Test\Mock\MockSession;
use CodeIgniter\Session\Handlers\ArrayHandler;

class FeatureTestCase extends \CodeIgniter\Test\FeatureTestCase
{
	/**
	 * @var SessionHandler
	 */
	protected $session;

	protected $refresh = true;
	protected $seed = 'Tests\Support\Database\Seeds\TestSeeder';
	protected $basePath = SUPPORTPATH . 'Database/';
	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->mockSession();
		$this->withSession([]);
	}

	public function tearDown(): void
	{
		parent::tearDown();
	}

	public function withSession(array $values = NULL)
	{
		$this->session = $values;

		return $this;
	}

	protected function mockSession()
	{
		$config        = config('App');
		$this->session = new MockSession(new ArrayHandler($config, '0.0.0.0'), $config);
		\Config\Services::injectMock('session', $this->session);
	}
}
