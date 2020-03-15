<?php namespace App\Core;

use CodeIgniter\View\View;
use Config\Services;

trait ThemeTrait
{
	/** @var string The name of the theme's folder. **/
	protected $theme = 'default';

	/** @var View **/
	protected $renderer = null;

	/** @var string **/
	protected $escape = 'raw';

	//--------------------------------------------------------------------

	public static function list(bool $default = false)
	{
		helper('filesystem');

		$themes = array_map(function($theme) {
			return rtrim($theme, '/');
		}, directory_map(THEMEPATH, 1));

		if ($default)
		{
			$themes[] = 'default';
		}

		return $themes;
	}

	//--------------------------------------------------------------------

	/**
	 * Same as the global view() helper, but uses our instance of the
	 * renderer so we can render themes.
	 *
	 * @param string $name
	 * @param array  $data
	 * @param array  $options
	 *
	 * @return string
	 */
	protected function render(string $name, array $data = [], array $options = [])
	{
		$renderer = $this->getRenderer();

		$saveData = null;
		if (array_key_exists('saveData', $options) && $options['saveData'] === true)
		{
			$saveData = (bool)$options['saveData'];
			unset($options['saveData']);
		}

		return $renderer->setData($data, $this->escape)->render($name, $options, $saveData);
	}

	//--------------------------------------------------------------------

	/**
	 * Gets an instance of our theme-based renderer and caches it locally.
	 *
	 * @return ThemedView|\CodeIgniter\View\View
	 */
	protected function getRenderer()
	{
		if ($this->renderer !== null)
		{
			return $this->renderer;
		}

		if ($this->theme === 'default')
		{
			$path = APPPATH.'Views'.DIRECTORY_SEPARATOR.'default';
		}
		else
		{
			$path = THEMEPATH . "{$this->theme}";
		}

		$this->renderer = Services::renderer($path, null, false);

		return $this->renderer;
	}

	//--------------------------------------------------------------------
}