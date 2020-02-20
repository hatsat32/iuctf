<?php namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/language', 'Home::language');

// installation manager routes
$routes->get('/install',   'Install::index');
$routes->get('/installed', 'Install::installed');
$routes->post('/install',  'Install::install');

/**
 * Myth:Auth routes
 */
$routes->group('', ['namespace' => 'App\Controllers'], function(RouteCollection $routes) {
	// Login/out
	$routes->get('login', 'AuthController::login', ['as' => 'login']);
	$routes->post('login', 'AuthController::attemptLogin');
	$routes->get('logout', 'AuthController::logout');

	// Registration
	$routes->get('register', 'AuthController::register', ['as' => 'register']);
	$routes->post('register', 'AuthController::attemptRegister');

	// Activation
	$routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);

	// Forgot/Resets
	$routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
	$routes->post('forgot', 'AuthController::attemptForgot');
	$routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
	$routes->post('reset-password', 'AuthController::attemptReset');
});


$routes->group('', ['namespace' => 'App\Controllers\User', 'filter' => 'login'], function(RouteCollection $routes) {
	$routes->get('challenges',                      'ChallengeController::challenges', ['as' => 'challenges']);
	$routes->get('challenges/(:num)',               'ChallengeController::challenge/$1', ['as' => 'challenge-detail']);
	$routes->post('challenges/(:num)',              'ChallengeController::flagSubmit/$1');
	$routes->post('challenges/(:num)/hints/(:num)', 'ChallengeController::hint/$1/$2', ['as' => 'challenge-hints']);

	$routes->get('team',        'TeamController::index', ['as' => 'team']);
	$routes->post('createteam', 'TeamController::createTeam', ['as' => 'createteam']);
	$routes->post('jointeam',   'TeamController::joinTeam', ['as' => 'jointeam']);

	$routes->get('profile',                  'ProfileController::index', ['as' => 'profile']);
	$routes->post('profile',                 'ProfileController::updateProfile');
	$routes->post('profile/change-password', 'ProfileController::updatePassword');

	$routes->get('scoreboard',    'ScoreboardController::index', ['as' => 'scoreboard']);
	$routes->get('notifications', 'UserUtilityController::notifications', ['as' => 'notifications']);

	$routes->get('hash',  'UserUtilityController::hash', ['as' => 'hash']);
	$routes->post('hash', 'UserUtilityController::gethash');
});


$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], function(RouteCollection $routes) {
	$routes->get('/', 'DashboardController::index', ['as' => 'admin-dashboard']);

	$routes->group('teams', function(RouteCollection $routes) {
		$routes->get('/',              'TeamController::index',   ['as' => 'admin-teams']);
		$routes->get('new',            'TeamController::new',     ['as' => 'admin-teams-new']);
		$routes->get('(:num)',         'TeamController::show/$1', ['as' => 'admin-teams-show']);
		$routes->post('/',             'TeamController::create');
		$routes->post('(:num)/delete', 'TeamController::delete/$1');
		$routes->post('(:num)',        'TeamController::update/$1');

		$routes->post('(:num)/authcode','TeamController::changeAuthCode/$1');
		$routes->post('(:num)/ban',     'TeamController::ban/$1');
		$routes->post('(:num)/unban',   'TeamController::unBan/$1');

		$routes->post('(:num)/solves',  'TeamController::markAsSolved/$1');
		$routes->post('(:num)/solves/(:num)/delete', 'TeamController::markAsUnsolved/$1/$2');
	});

	$routes->group('users', function(RouteCollection $routes) {
		$routes->get('/',              'UserController::index',   ['as' => 'admin-users']);
		$routes->get('new',            'UserController::new',     ['as' => 'admin-users-new']);
		$routes->get('(:num)',         'UserController::show/$1', ['as' => 'admin-users-show']);
		$routes->post('/',             'UserController::create');
		$routes->post('(:num)/delete', 'UserController::delete/$1');
		$routes->post('(:num)',        'UserController::update/$1');

		$routes->post('(:num)/change-password', 'UserController::changePassword/$1');
		$routes->post('(:num)/addadmin', 'UserController::addAdmin/$1');
		$routes->post('(:num)/rmadmin',  'UserController::rmAdmin/$1');
		$routes->post('(:num)/ban',      'UserController::ban/$1');
		$routes->post('(:num)/unban',    'UserController::unban/$1');
		$routes->post('(:num)/remove-from-team', 'UserController::removeFromTeam/$1');
	});

	$routes->group('categories', function(RouteCollection $routes) {
		$routes->get('/',              'CategoryController::index',   ['as' => 'admin-categories']);
		$routes->get('new',            'CategoryController::new',     ['as' => 'admin-categories-new']);
		$routes->get('(:num)',         'CategoryController::show/$1', ['as' => 'admin-categories-show']);
		$routes->post('/',             'CategoryController::create');
		$routes->post('(:num)/delete', 'CategoryController::delete/$1', ['as' => 'admin-categories-delete']);
		$routes->post('(:num)',        'CategoryController::update/$1');
	});

	$routes->group('challenges', function(RouteCollection $routes) {
		$routes->get('/',              'ChallengeController::index',   ['as' => 'admin-challenges']);
		$routes->get('new',            'ChallengeController::new',     ['as' => 'admin-challenges-new']);
		$routes->get('(:num)',         'ChallengeController::show/$1', ['as' => 'admin-challenges-show']);
		$routes->post('/',             'ChallengeController::create');
		$routes->post('(:num)/delete', 'ChallengeController::delete/$1');
		$routes->post('(:num)',        'ChallengeController::update/$1');
	});

	$routes->group('challenges/(:num)/flags', function(RouteCollection $routes) {
		$routes->get('/',              'FlagController::index$1',    ['as' => 'admin-flags']);
		$routes->get('new',            'FlagController::new$1',      ['as' => 'admin-flags-new']);
		$routes->get('(:num)',         'FlagController::show/$1/$2', ['as' => 'admin-flags-show']);
		$routes->post('/',             'FlagController::create/$1');
		$routes->post('(:num)/delete', 'FlagController::delete/$1/$2');
		$routes->post('(:num)',        'FlagController::update/$1/$2');
	});

	$routes->group('challenges/(:num)/hints', function(RouteCollection $routes) {
		$routes->get('/',              'HintController::index$1',    ['as' => 'admin-hints']);
		$routes->get('new',            'HintController::new$1',      ['as' => 'admin-hints-new']);
		$routes->get('(:num)',         'HintController::show/$1/$2', ['as' => 'admin-hints-show']);
		$routes->post('/',             'HintController::create/$1');
		$routes->post('(:num)/delete', 'HintController::delete/$1/$2');
		$routes->post('(:num)',        'HintController::update/$1/$2');
	});

	$routes->group('challenges/(:num)/files', function(RouteCollection $routes) {
		$routes->post('/',             'FileController::create/$1');
		$routes->post('(:num)/delete', 'FileController::delete/$1/$2');
	});

	$routes->group('notifications', function(RouteCollection $routes) {
		$routes->get('/',              'NotificationController::index',   ['as' => 'admin-notf']);
		$routes->get('new',            'NotificationController::new',     ['as' => 'admin-notf-new']);
		$routes->get('(:num)',         'NotificationController::show/$1', ['as' => 'admin-notf-show']);
		$routes->post('/',             'NotificationController::create');
		$routes->post('(:num)/delete', 'NotificationController::delete/$1');
		$routes->post('(:num)',        'NotificationController::update/$1');
	});

	$routes->group('settings', function(RouteCollection $routes) {
		$routes->get('/',        'SettingsController::index',   ['as' => 'admin-settings']);

		$routes->get('general',  'SettingsController::general', ['as' => 'admin-settings-general']);
		$routes->post('general', 'SettingsController::generalUpdate');


		$routes->get('timer',    'SettingsController::timer',   ['as' => 'admin-settings-timer']);
		$routes->post('timer',   'SettingsController::timerUpdate');

		$routes->get('data',                    'SettingsController::data',    ['as' => 'admin-settings-data']);
		$routes->get('data/backup/(:segment)',  'SettingsController::download/$1');
		$routes->post('data/backup',            'SettingsController::backupData');
		$routes->post('data/backup/(:segment)', 'SettingsController::delete/$1');
		$routes->post('data/reset',             'SettingsController::resetData');
	});

	$routes->group('logs', function(RouteCollection $routes) {
		$routes->get('submission', 'LogController::submission', ['as' => 'admin-log-flag']);
		$routes->get('login',      'LogController::login',   ['as' => 'admin-log-login']);
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
