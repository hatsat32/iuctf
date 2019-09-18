<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
	protected $table      = 'categories';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'name', 'description'
	];

	protected $validationRules = [
		'name'			=> 'required|alpha_numeric_space',
		// 'description'     => 'alpha_numeric_space',
	];
	
	protected $validationMessages = [];
	protected $skipValidation = false;
}
