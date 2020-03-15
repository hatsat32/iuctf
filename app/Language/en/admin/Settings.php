<?php

return [
	'settings'    => 'Settings',
	'general'     => 'General',
	'timer'       => 'Timer',
	'data'        => 'Data',
	'ctfName'     => 'CTF Name',
	'memberLimit' => 'Member Limit',
	'theme'       => 'Theme',
	'default'     => 'Default',

	'updatedSuccessfully' => 'Settings updated successfully',

	// general settings
	'ctfNameTitle'         => 'CTF Name',
	'ctfNameDesc'          => 'The name of the Competition. Or the name of the "CTF".',
	'teamMemberLimitTitle' => 'Team Member Limit',
	'teamMemberLimitDesc'  => 'Max team member.',
	'themeTitle'           => 'Theme',
	'themeDesc'            => 'The theme of the CTF',
	'allowRegister'        => 'Allow Register',
	'disallowRegister'     => 'Dissallow Register',
	'allowRegisterTitle'   => 'Allow Register',
	'allowRegisterDesc'    => 'New user register allow or dissallow',
	'needHash'             => 'Need hash for flags',
	'noNeedHash'           => 'No need hash for flags',
	'needHashTitle'        => 'Need hash for flags',
	'needHashDesc'         => 'New user register allow or dissallow',
	'needHashKeyDesc'      => 'This key adds end of the flag before hash.',
	'hashSecretKey'        => 'Hash Secret Key',
	'regenHashSecretKey'   => 'Regenerate Hash Secret Key',

	// timer settings
	'ctfTimer'             => 'CTF Timer',
	'timerTitle'           => 'Timer',
	'timerDesc'            => 'Configure CTF timer',
	'startTime'            => 'Start Time',
	'endTime'              => 'End Time',

	// theme settings
	'themes'               => 'Themes',
	'deleteTheme'          => 'Delete the theme',
	'importTheme'          => 'Import a Theme',
	'themeChanged'         => 'Theme changed successfully',
	'defaultThemeErr'      => 'Default theme newer be deleted',
	'themeValidationErr'   => 'Theme not valid',
	'currentThemeErr'      => 'Current theme can not be deleted. Please change theme first',
	'themeDeleted'         => 'Theme successfully deleted',

	// data settings
	'backup'               => 'Backup',
	'reset'                => 'Reset',
	'download'             => 'Download',
	'backupDesc'           => 'Backup files',
	'backupSuccessful'     => 'Taking backup successfull',
	'deletedSuccessfully'  => 'Deleted Successfully',
	'fileNotExist'         => 'File not exist {file}',
	'deleteError'          => 'File delete error happen',

	// home page settings
	'home'                 => 'Home Page',
	'pageChangeError'      => 'Can not write to disk',
	'pageChanged'          => 'Home page changed successfully',
	'note'                 => 'Note',
	'noteContent'          => 'You can use Jquery and Bootstrap 4 in here.',
	'warning'              => 'Warning',
	'jsWarning'            => 'Please be careful when you put javascript code in here! This content will NOT be escaped in homepage!',
];
