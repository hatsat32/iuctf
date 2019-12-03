<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Challenge;

class ChallengeModel extends Model
{
	public function __construct()
	{
		parent::__construct();

		$this->setValidationLabels();
	}

	protected $table      = 'challenges';
	protected $primaryKey = 'id';
	protected $returnType = Challenge::class;

	protected $allowedFields = [
		'category_id', 'name', 'point', 'description', 'max_attempts', 'type', 'is_active'
	];

	protected $validationRules = [
		'category_id'   => 'numeric',
		'name'          => 'required|min_length[2]',
		'point'         => 'required|numeric',
		'description'   => 'required',
		'max_attempts'  => ['rules' => 'numeric'],
		'type'          => 'required|in_list[static,dynamic]',
		'is_active'     => 'required|in_list[0,1]',
	];
	
	protected $useTimestamps = true;

	protected function setValidationLabels()
	{
		$this->validationRules['max_attempts']['label'] = lang('admin/Challenge.maxAttempt');
	}
}
