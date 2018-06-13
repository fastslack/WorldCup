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

// No direct access to this file
defined('_JEXEC') or die;

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewResults extends WorldCupView
{

	function display($tpl = null)
	{
		$tid = 4;
		$db = JFactory::getDBO();

		// Create a new query object.
		$query	= $this->_db->getQuery(true);

		// Get groups
		$groups = $this->_tournaments->getGroupsList($tid);

		// Get Data for table groups
		$data = $this->_results->getTableData($groups);

		// Get teams
		$teams = $this->_teams->getTeamsList($tid);

		// Get results
		$this->results = $this->_results->getResultsList($tid);

		// Send data to template
		$this->assignRef('data', $data);
		$this->assignRef('groups', $groups);
    //$this->assignRef('matches', $this->matches);
		$this->assignRef('matches8vo', $matches8vo);
		$this->assignRef('teams', $teams);

		parent::display($tpl);
	}

}
?>
