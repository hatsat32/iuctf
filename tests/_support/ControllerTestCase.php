<?php namespace Tests\Support;

use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\Mock\MockSession;
use CodeIgniter\Session\Handlers\ArrayHandler;

class ControllerTestCase extends DatabaseTestCase
{
	use ControllerTester;

	protected $refresh = true;

	public function setUp(): void
	{
		parent::setUp();

		$this->mockSession();
	}

	protected function mockSession()
	{
		require_once SYSTEMPATH . 'Test/Mock/MockSession.php';
		$config = config('App');
		$this->session = new MockSession(new ArrayHandler($config, '0.0.0.0'), $config);
		\Config\Services::injectMock('session', $this->session);
		$_SESSION = [];
	}
}
