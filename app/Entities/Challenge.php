<?php namespace App\Entities;

use App\Models\FileModel;
use CodeIgniter\Entity;
use App\Models\FlagModel;
use App\Models\HintModel;


class Challenge extends Entity
{
	protected $attributes = [
		'challenge_id' => null,
		'type'         => null,
		'content'      => null,
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $casts = [
		'id'           => 'int',
		'category_id'  => 'int',
		'point'        => 'int',
		'max_attempts' => 'int',
		'is_active'    => 'boolean',
	];

	//--------------------------------------------------------------------

	public function setMaxAttempts(string $attempts)
	{
		if (empty($attempts))
		{
			$this->attributes['max_attempts'] = 0;
		}
		else
		{
			$this->attributes['max_attempts'] = $attempts;
		}

		return $this;
	}

	//--------------------------------------------------------------------

	public function flags()
	{
		$flagModel = new FlagModel();
		return $flagModel->where('challenge_id', $this->attributes['id'])->findAll();
	}

	//--------------------------------------------------------------------

	public function hints()
	{
		$hintModel = new HintModel();
		return $hintModel->where('challenge_id', $this->attributes['id'])->findAll();
	}

	//--------------------------------------------------------------------

	public function files()
	{
		$fileModel = new FileModel();
		return $fileModel->where('challenge_id', $this->attributes['id'])->findAll();
	}

	//--------------------------------------------------------------------
}
