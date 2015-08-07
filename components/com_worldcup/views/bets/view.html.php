<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2014 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewBets extends WorldCupView {

	function display($tpl = null)	{

		// Get the patient id
		$this->tid = JFactory::getApplication()->input->get('tid', 1);

		if($this->getLayout() == 'step2') {
		  $this->step2($tpl);
		  return;
		}else if($this->getLayout() == 'step3') {
		  $this->step3($tpl);
		  return;
		}else if($this->getLayout() == 'step4') {
		  $this->step4($tpl);
		  return;
		}else if($this->getLayout() == 'step5') {
		  $this->step5($tpl);
		  return;
		}else if($this->getLayout() == 'step6') {
		  $this->step6($tpl);
		  return;
		}

		// Get the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		// Get the groups
		$this->groups = $this->_tournaments->getGroupsList($this->tid, '');

		// Get the correct matches
		$this->matches = array();

		foreach ($this->groups as $group)
		{
			//$this->matches[] = $this->getMatches(1, $group->id);
			$this->matches[] = $this->_matches->getMatchesList($this->tid, false, $group->id);		
		}

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->tid, $this->_my->id);


		// Get the results
		$this->results = $this->getResults();

		parent::display($tpl);
	}

	function step2 ($tpl = null) {

		// Getting the groups
		$this->groups = $this->_tournaments->getGroupsList($this->tid);

		// Get Data for table groups
		$this->data = $this->_getTableData($groups);

		// Get Matches of 8vo
		//$this->matches = $this->getMatches(1, 0, 1);
		$this->matches = $this->_matches->getMatchesList($this->tid, 1, 0);		

		// Get the bets
		$this->oldbets = $this->_bets->getBetsList($this->tid, $this->_my->id, 1);
		//$this->oldbets = $this->getBets(1, 1);

		parent::display($tpl);
	}

	function step3 ($tpl = null) {

		// Get Matches of 4to
		//$this->matches = $this->getMatches(1, 0, 2);
		$this->matches = $this->_matches->getMatchesList($this->tid, 2, 0);			

		// Get the old bets
		$this->oldbets = $this->getBets(1, 1);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->tid, $this->_my->id, 2);
		//$this->bets = $this->getBets(1, 2);

		// Getting the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		parent::display($tpl);
	}

	function step4 ($tpl = null) {

		// Get Matches of Semi
		//$this->matches = $this->getMatches(1, 0, 3);		
		$this->matches = $this->_matches->getMatchesList($this->tid, 3, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->tid, $this->_my->id, 2);
		//$this->oldbets = $this->getBets(1, 2);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->tid, $this->_my->id, 3);
		//$this->bets = $this->getBets(1, 3);

		// Get the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		parent::display($tpl);
	}

	function step5 ($tpl = null) {

		// Get Matches of 4to
		//$this->matches = $this->getMatches(1, 0, 4);
		$this->matches = $this->_matches->getMatchesList($this->tid, 4, 0);			

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->tid, $this->_my->id, 3);
		//$this->oldbets = $this->getBets(1, 3);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->tid, $this->_my->id, 4);
		//$this->bets = $this->getBets(1, 4);

		// Get the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		parent::display($tpl);
	}

	function step6 ($tpl = null) {

		// Get Matches of final
		//$this->matches = $this->getMatches(1, 0, 5);
		$this->matches = $this->_matches->getMatchesList($this->tid, 5, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->tid, $this->_my->id, 4);
		//$this->oldbets = $this->getBets(1, 4);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->tid, $this->_my->id, 5);
		//$this->bets = $this->getBets(1, 5);

		// Get the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		parent::display($tpl);
	}

	/**
	* Get the results
	*
	* @return      object
	* @since       1.0
	*/
	protected function getResults()
	{
		// Getting the results
		$query = $this->_db->getQuery(true);
		$query->select('r.mid');
		$query->from(" #__worldcup_results AS r");
		$query->order($this->_db->escape('r.id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList('mid');
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}


	function _getTableData($groups) { 

		$data = array();
		$db =& JFactory::getDBO();
		$my =& JFactory::getUser();

		for($i=1;$i<=count($groups);$i++) {

			$query = "SELECT t.id, t.name
				FROM #__worldcup_teams AS t
				WHERE t.group = {$groups[$i]['id']}
				AND t.tid = 1"; 
			$db->setQuery($query);
			//echo $query;
			$teams[$i] = $db->loadAssocList( 'id' );
			//print_r($teams[$i]);
			//echo "<br><br>";

			$query = "SELECT b.mid, m.team1, m.team2, b.local, b.visit 
				FROM #__worldcup_bets AS b 
				LEFT JOIN #__worldcup_matches AS m ON m.id = b.mid
				WHERE b.uid = {$my->id}
				AND m.tid = 1
				AND m.group = {$groups[$i]['id']}
				ORDER BY b.mid ASC";

			$db->setQuery($query);
			//echo $query;
			$bets = $db->loadObjectList( );
			//echo "<br><br>";			
			//print_r($bets);

			for($y=0;$y<count($bets);$y++) {
				$bet = &$bets[$y];
				//print_r($bet);
				//echo "<br><br>";

				if ($bet->local > $bet->visit ) {
					$teams[$i][$bet->team1]['points'] += 3;
				}else if ($bet->local < $bet->visit ) {
					$teams[$i][$bet->team2]['points'] += 3;
				}else if ($bet->local == $bet->visit ) {
					$teams[$i][$bet->team1]['points'] += 1;
					$teams[$i][$bet->team2]['points'] += 1;	
				}

				$teams[$i][$bet->team1]['gf'] += $bet->local;
				$teams[$i][$bet->team2]['gf'] += $bet->visit;

				$teams[$i][$bet->team1]['ge'] += $bet->visit;
				$teams[$i][$bet->team2]['ge'] += $bet->local;	

				//print_r($teams[$i]);echo ".<br><br>";
			}
	
			//print_r($teams[$i]);
			//echo "<br><br>";
			$data[$i] = $this->orderBy($teams[$i]);
			//print_r($data);
			//echo "<br>======================================<br><br>";
		}

		return $data; 
	}
}
