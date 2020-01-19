<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity;

class FileModel extends Model
{
	protected $table      = 'files';
	protected $primaryKey = 'id';
	protected $returnType = Entity::class;

	protected $allowedFields = [
		'challenge_id', 'location'
	];

	protected $validationRules = [
		'challenge_id' => 'required|numeric',
		'location'     => 'required|string',
	];
}
