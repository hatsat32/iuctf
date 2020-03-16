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

	/**
	 * Check flas is correct or not
	 * 
	 * @param string $submited_flag
	 * @param array $flags
	 * 
	 * @return bool - if flag is correct true, false otherwise
	 */
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

	/**
	 * Log flag submit action
	 * 
	 * @param array $data
	 */
	public function log($data): bool
	{
		$submissionModel = new SubmissionModel();
		$result = $submissionModel->insert($data);
		return (bool) $result;
	}

	//--------------------------------------------------------------------

	/**
	 * If team team solved the challenge return true, false otherwise
	 * 
	 * @param int $challengeID
	 * @param int $teamID
	 * 
	 * @return bool
	 */
	public function isAlreadySolved(int $challengeID, int $teamID): bool
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

	/**
	 * Get flags hash
	 * 
	 * This method adds secret key enf of the flag and gets sha256 sum
	 * 
	 * @param string $flag
	 * 
	 * @return string
	 */
	public function hash(string $flag): string
	{
		return hash('sha256', $flag . $this->secret);
	}

	//--------------------------------------------------------------------
}
