<?php namespace App\Controllers;

class Home extends BaseController
{
	//--------------------------------------------------------------------

	public function index()
	{
		return $this->render('index');
	}

	//--------------------------------------------------------------------

	public function language()
	{
		$language = $this->request->getGet('language');

		$rules = [
			'language' => 'required|in_list[en,tr]',
		];
		if (! $this->validate($rules))
		{
			return redirect()->back();
		}

		$session = session();
		$session->set('language', $language);

		return redirect()->back();
	}

	//--------------------------------------------------------------------

	protected function render(string $name, array $data = [], array $options = [])
	{
		$path = APPPATH.'Views'.DIRECTORY_SEPARATOR.ss()->theme;
		$renderer = \Config\Services::renderer($path, null, false);

		$saveData = null;
		if (array_key_exists('saveData', $options) && $options['saveData'] === true)
		{
			$saveData = (bool) $options['saveData'];
			unset($options['saveData']);
		}

		return $renderer->setData($data, 'raw')->render($name, $options, $saveData);
	}

	//--------------------------------------------------------------------
}
