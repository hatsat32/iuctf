<?php namespace Config;


use CodeIgniter\Config\BaseConfig;
use App\Models\SettingModel;


class Settings extends BaseConfig
{

	public function __construct()
	{
		parent::__construct();

		foreach ((new SettingModel)->findAll() as $setting) {
			$this->{$setting->key} = $setting->value;
		}
	}

	/**
	 * Name of CTF
	 */
	public $ctf_name = "IUCTF";

	/**
	 * CTF logo
	 */
	public $ctf_logo = null;

	/**
	 * CTF home page view
	 */
	public $home_page = null;

	/**
	 * CTF theme
	 */
	public $theme = "default";

	/**
	 * Ctf timer settings
	 */
	public $ctf_timer = "off";
	public $ctf_start_time = null;
	public $ctf_end_time = null;

	/**
	 * Allow Registration
	 */
	public $allow_register = "allow";

	/**
	 * Some Ctf's needs to hash flags.
	 * If this settings is true no unhashed flags approwed
	 * Iuctf uses sha256 hash algorithm
	 */
	public $need_hash = false;

	/**
	 * While hashing glags, some users uses some websites.
	 * And that web sites logs entries is their history
	 * This secret key dont allows users to use another site.
	 */
	public $hash_secret_key = null;

	/**
	 * Max team member
	 * Default 4
	 */
	public $team_member_limit = 4;
}
