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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class WorldcupControllerCpanel extends JControllerAdmin
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {

		parent::__construct();

		$my =& JFactory::getUser();

		$subMenus = array(
			JText::_( "Dashboard") => 'cpanel',
			JText::_( "Tournaments") => 'tournaments',
			JText::_( "Users") => 'users',
			JText::_( "Places") => 'places',
			JText::_( "Groups") => 'groups',
			JText::_( "Teams") => 'teams',
			JText::_( "Matches") => 'matches',
			JText::_( "Bets") => 'bets',
			JText::_( "Results") => 'results');

		foreach ($subMenus as $name => $extension) {

			$onclick = '#" onclick="javascript:window.location=\'index.php?option=com_worldcup&controller='.$extension.'\'"';

			JSubMenuHelper::addEntry(JText::_( $name ), $onclick, 0);
		}    

	}

	/**
	 * Proxy for getModel.
	 * @since   1.6
	 */
	public function getModel($name = 'Cpanel', $prefix = 'WorldcupModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * Method to provide child classes the opportunity to process after the delete task.
	 *
	 * @param   JModelLegacy   $model   The model for the component
	 * @param   mixed          $ids     array of ids deleted.
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	protected function postDeleteHook(JModelLegacy $model, $ids = null)
	{
	}
}
