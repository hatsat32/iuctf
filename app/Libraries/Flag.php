<?php namespace App\Libraries;

use App\Models\SubmissionModel;

class Flag
{
	protected $dynamicRate = 0.5;

	//--------------------------------------------------------------------

	public function check(string $submited_flag, array $flags): bool
	{
		$result = false;

		foreach ($flags as $flag)
		{
			if ($flag->type === 'static' && $flag->content === $submited_flag)
			{
				$result = true;
				break;
			}
			else if ($flag->type === 'regex' && preg_match("/{$flag->content}/", $submited_flag))
			{
				$result = true;
				break;
			}
			else
			{
				return false;
			}
		}

		return $result;
	}

	//--------------------------------------------------------------------

	public function log($data)
	{
		$submissionModel = new SubmissionModel();
		$result = $submissionModel->insert($data);

		if (! $result)
		{
			return false;
		}

		return true;
	}

	//--------------------------------------------------------------------

	public function isAlreadySolved($challengeID, $teamID)
	{
		$data = [
			'challenge_id' => $challengeID,
			'team_id'      => $teamID
		];

		$solved_before = $this->solvesModel->where($data)->find();

		if (empty($solved_before))
		{
			return false;
		}

		return true;
	}

	//--------------------------------------------------------------------
}
