<?php namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
	protected $table      = 'files';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'challenge_id', 'location'
	];

	protected $validationRules = [
        'challenge_id'      => 'required|numeric',
        'location'          => 'required|string',
	];
}
