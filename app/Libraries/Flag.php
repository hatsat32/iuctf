<?php namespace App\Libraries;

use App\Models\SubmissionModel;
use App\Models\SolvesModel;

class Flag
{
	/** @param float **/
	protected $dynamicRate = 0.5;

	/** @param string **/
	protected $hashSecret = '';

	/** @param bool **/
	protected $needHash = false;

	//--------------------------------------------------------------------

	public function __construct()
	{
		$this->secret = ss()->hash_secret_key;
		$this->needHash = ss()->need_hash;
	}

	//--------------------------------------------------------------------

	public function check(string $submited_flag, array $flags): bool
	{
		foreach ($flags as $flag)
		{
			if ($flag->type === 'static')
			{
				if ($this->needHash && $submited_flag === $this->hash($flag->content))
				{
					return true;
				}
				else if (!$this->needHash && $flag->content === $submited_flag)
				{
					return true;
				}
			}
			else if ($flag->type === 'regex' && preg_match("/{$flag->content}/", $submited_flag))
			{
				return true;
			}
		}

		return false;
	}

	//--------------------------------------------------------------------

	public function log($data): bool
	{
		$submissionModel = new SubmissionModel();
		$result = $submissionModel->insert($data);
		return (bool) $result;
	}

	//--------------------------------------------------------------------

	public function isAlreadySolved($challengeID, $teamID): bool
	{
		$solvesModel = new SolvesModel();
		$data = [
			'challenge_id' => $challengeID,
			'team_id'      => $teamID
		];

		$solved_before = $solvesModel->where($data)->find();

		return ! empty($solved_before);
	}

	//--------------------------------------------------------------------

	public function hash(string $flag): string
	{
		return hash('sha256', $flag . $this->secret);
	}

	//--------------------------------------------------------------------
}
