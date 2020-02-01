<?php namespace App\Entities;


use App\Models\ChallengeModel;
use CodeIgniter\Entity;


class Category extends Entity
{
	protected $attributes = [
		'name'        => null,
		'description' => null,
	];

	protected $dates = ['created_at', 'updated_at'];

	//--------------------------------------------------------------------

	public function challenges()
	{
		$challengeModel = new ChallengeModel();
		return $challengeModel->where('category_id', $this->attributes['id'])->findAll();
	}

	//--------------------------------------------------------------------
}
