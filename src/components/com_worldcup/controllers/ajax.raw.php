<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2018 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\DI\Container;
use Worldcup\Competitions;

/**
 * The Worldcup ajax controller
 *
 * @package     Worldcup
 * @subpackage  com_worldcup
 * @since       1.0.0
 */
class WorldcupControllerAjax extends AdminController
{
	/**
	 * @var		string	The context for persistent state.
	 * @since   3.0.3
	 */
	protected $context = 'com_worldcup.ajax';

	private $container;

  /**
	 * Create container
	 */
	public function createContainer()
	{
		// Get a new DI container
		$this->container = new Container;

		$config = JFactory::getConfig();
    $my = JFactory::getUser();

    if ($my->id == 0)
    {
      $this->returnError(403, 'UNAUTHORISED');
    }

		// Set config to container
		$this->container->share('config', function (Container $c) use ($config) {
			return $config;
		}, true);

		// Set input to container
		$input = JFactory::getApplication()->input;
		$this->container->share('input', function (Container $c) use ($input) {
			return $input;
		}, true);

		// Set db to container
		$db = JFactory::getDbo();
		$this->container->share('db', function (Container $c) use ($db) {
			return $db;
		}, true);

    // Set my to container
		$this->container->share('my', function (Container $c) use ($my) {
			return $my;
		}, true);

		$competitions = new Competitions();
		$this->container->share('competitions', function (Container $c) use ($competitions) {
			return $competitions;
		}, true);
	}

	/**
	 * Run requestAuth
	 */
	public function requestAuth()
	{
		// Create container
		$this->createContainer();

		$cid = $this->container->get('input')->get('cid');

    $this->container->get('competitions')->requestAuth($cid);

    $this->returnError(200, 'OK');
	}

	/**
	 * Run confirmAuth
	 */
	public function confirmAuth()
	{
		// Create container
		$this->createContainer();

		$cid = $this->container->get('input')->get('cid');

		if ($this->container->get('competitions')->checkAuth($cid, $this->container->get('my')->id) != 2)
		{
			$this->returnError(403, 'UNAUTHORISED');
		}

		$user_id = $this->container->get('input')->get('user_id');

    $this->container->get('competitions')->confirmAuth($cid, $user_id);

    $this->returnError(200, 'OK');
	}

	/**
	 * Run confirmAuth
	 */
	public function revokeAuth()
	{
		// Create container
		$this->createContainer();

		$cid = $this->container->get('input')->get('cid');

		if ($this->container->get('competitions')->checkAuth($cid, $this->container->get('my')->id) != 2)
		{
			$this->returnError(403, 'UNAUTHORISED');
		}

		$user_id = $this->container->get('input')->get('user_id');

    $this->container->get('competitions')->revokeAuth($cid, $user_id);

    $this->returnError(200, 'OK');
	}

	/**
	 * returnError
	 *
	 * @return	none
	 * @since	2.5.0
	 */
	public function returnError ($code, $message, $debug = false)
	{
		$response = array();
		$response['code'] = $code;
		$response['message'] = \JText::_($message);

		if ($debug != false)
		{
			$message['debug'] = $debug;
		}

		print(json_encode($response));
		exit;
	}
}
