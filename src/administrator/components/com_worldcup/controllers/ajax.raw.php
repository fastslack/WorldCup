<?php
/**
* WorldCup
*
* @version $Id:
* @package Matware.WorldCup
* @copyright Copyright (C) 2004 - 2018 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class WorldcupControllerAjax extends JControllerLegacy
{

	/**
	 * Save the result
	 *
	 * @return  none
	 */
  public function saveResult()
  {
		$db = JFactory::getDBO();

		$mid = JFactory::getApplication()->input->get( 'id' );
		$l = JFactory::getApplication()->input->get( 'l' );
		$v = JFactory::getApplication()->input->get( 'v' );
		$t1 = JFactory::getApplication()->input->get( 't1' );
		$t2 = JFactory::getApplication()->input->get( 't2' );

		$query = "INSERT  INTO `#__worldcup_results`  ( `mid`, `local`, `visit`, `team1`, `team2` )
		VALUES ('{$mid}', '{$l}', '{$v}', '{$t1}', '{$t2}' )";
		$db->setQuery( $query );
		$db->query();

		exit;
	}

	/**
	 * Save the result
	 *
	 * @return  none
	 */
  public function deleteResult()
  {
		$db = JFactory::getDBO();

		$mid = JFactory::getApplication()->input->get('mid');
		$l = JFactory::getApplication()->input->get( 'l' );
		$v = JFactory::getApplication()->input->get( 'v' );

		$query = "DELETE FROM `#__worldcup_results` WHERE mid = '{$mid}'
		 AND  local = '{$l}' AND visit = '{$v}'";
		$db->setQuery( $query );
		$db->query();

		exit;
	}
}
