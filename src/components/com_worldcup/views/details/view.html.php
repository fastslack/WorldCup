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

require_once (JPATH_COMPONENT.DS.'view.php');

class worldcupViewdetails extends WorldCupView {

	function display($tpl = null) {
   	global $mainframe;

		if($this->getLayout() == 'detail') {
		  $this->detail($tpl);
		  return;
		}

	}

	function detail ($tpl = null) {
		global $mainframe;

		include(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php');

		$db =& JFactory::getDBO();
		$id = JRequest::getVar( 'id' );

		## Getting the groups
		$query = "SELECT g.*
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList('id');
		//print_r($groups);

		for($i=1;$i<=count($groups);$i++) {

			## Getting the matches
			$query = "SELECT m.*, p.name AS pname
								FROM #__worldcup_matches AS m
								LEFT JOIN #__worldcup_places AS p ON p.id = m.place
								WHERE m.group = '{$groups[$i]->id}'
				        ORDER BY m.id ASC";
			$db->setQuery($query);
			$matches[$i] = $db->loadObjectList();
			//echo $query;
			//print_r($matches[$i]);
			//echo "<br><br><br>";
		}

		##
		## Get Matches of 8vo
		##
		$where = array();
		$where[] = "m.phase = 1";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Get Matches of 4to
		##
		$where = array();
		$where[] = "m.phase = 2";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Get Matches of Semi
		##
		$where = array();
		$where[] = "m.phase = 3";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Get Matches of 3rd
		##
		$where = array();
		$where[] = "m.phase = 4";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Get Matches of Final
		##
		$where = array();
		$where[] = "m.phase = 5";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Getting the bets
		##
		$query = "SELECT b.mid, b.local, b.visit, b.team1, b.team2
			FROM #__worldcup_bets AS b
			LEFT JOIN #__worldcup_matches AS m ON m.id = b.mid
			WHERE b.uid = {$id}
			ORDER BY b.id ASC";
		$db->setQuery($query);
		//echo $query;
		$bets = $db->loadObjectList( 'mid' );

		##
		## Getting the second phase table of this user
		##
		$data = WorldCupHelper::_getSecondPhaseTable ($id);

		##
		## Teams
		##
		$query = "SELECT id, name
			FROM #__worldcup_teams";

		$db->setQuery($query);
		//echo $query;
		$teams = $db->loadObjectList( 'id' );

		##
		## Phases
		##
		$phases = array();
		$phases[] = JText::_( 'Clasification' );
		$phases[] = JText::_( 'Round of 16' );
		$phases[] = JText::_( 'Quarter-finals' );
		$phases[] = JText::_( 'Semi-finals' );
		$phases[] = JText::_( 'Match for third place' );
		$phases[] = JText::_( 'Final' );

		$this->assignRef('phases', $phases);
		$this->assignRef('bets', $bets);
		$this->assignRef('data', $data);
		$this->assignRef('oldbets', $oldbets);
		$this->assignRef('teams', $teams);
		$this->assignRef('matches', $matches);
		$this->assignRef('groups', $groups);

		parent::display($tpl);
	}

}
?>
