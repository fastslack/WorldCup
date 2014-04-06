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

		// Getting the teams
		$this->teams = $this->getTeams(1);

		// Getting the groups
		$this->groups = $this->getGroups(1);

		// Getting the correct matches
		$this->matches = array();

		foreach ($groups as $group)
		{
			$this->matches[] = $this->getMatches(1, $group->id);		
		}

		// Getting the bets
		$this->bets = $this->getBets(1);

		// Getting the results
		$this->results = $this->getResults();

		parent::display($tpl);
	}

	function step2 ($tpl = null) {

		// Get the groups
		$this->groups = $this->getGroups(1);

		// Get Data for table groups
		$this->data = $this->_getTableData($groups);

		// Get Matches of 8vo
		$this->matches = $this->getMatches(1, 0, 1);		

		// Get the bets
		$this->oldbets = $this->getBets(1, 1);

		parent::display($tpl);
	}

	function step3 ($tpl = null) {

		// Get Matches of 4to
		$this->matches = $this->getMatches(1, 0, 2);		

		// Get the old bets
		$this->oldbets = $this->getBets(1, 1);

		// Get the bets
		$this->bets = $this->getBets(1, 2);

		// Getting the teams
		$this->teams = $this->getTeams(1);

		parent::display($tpl);
	}

	function step4 ($tpl = null) {

		// Get Matches of Semi
		$this->matches = $this->getMatches(1, 0, 3);		

		// Get the old bets
		$this->oldbets = $this->getBets(1, 2);

		// Get the bets
		$this->bets = $this->getBets(1, 3);

		// Get the teams
		$this->teams = $this->getTeams(1);

		parent::display($tpl);
	}

	function step5 ($tpl = null) {

		// Get Matches of 4to
		$this->matches = $this->getMatches(1, 0, 4);		

		// Get the old bets
		$this->oldbets = $this->getBets(1, 3);

		// Get the bets
		$this->bets = $this->getBets(1, 4);

		// Get the teams
		$this->teams = $this->getTeams(1);

		parent::display($tpl);
	}

	function step6 ($tpl = null) {

		// Get Matches of final
		$this->matches = $this->getMatches(1, 0, 5);	

		// Get the old bets
		$this->oldbets = $this->getBets(1, 4);

		// Get the bets
		$this->bets = $this->getBets(1, 5);

		// Get the teams
		$this->teams = $this->getTeams(1);

		parent::display($tpl);
	}

	/**
	* Get the matches
	*
	* @return      object
	* @since       1.0
	*/
	protected function getMatches($tid, $group_id, $phase_id = false)
	{
		$query = $this->_db->getQuery(true);
		$query->select('m.*');
		$query->from(" #__worldcup_matches AS m");

		// Join over the places.
		$query->select('p.name AS pname')
			->join('LEFT', '#__worldcup_places AS p ON p.id = m.place');

		$query->where("m.tid = {$tid}");

		if ($phase_id === false)
		{
			$query->where("m.group = {$group_id}");
		}else{
			$query->where("m.phase = {$phase_id}");
		}

		$query->order($this->_db->escape('m.id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList();
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	/**
	* Get the bets
	*
	* @return      object
	* @since       1.0
	*/
	protected function getBets($tid, $phase_id = false)
	{
		// Getting the bets
		$query = $this->_db->getQuery(true);
		$query->select('b.mid, b.local, b.visit, b.team1, b.team2');
		$query->from(" #__worldcup_bets AS b");
		$query->where("b.uid != 0");
		$query->where("b.uid = {$this->_my->id}");
		$query->where("b.tid = {$tid}");

		if ($phase_id !== false)
		{
			// Join over the matches.
			$query->join('LEFT', '#__worldcup_matches AS m ON m.id = b.mid');

			$query->where("m.phase = {$phase_id}");
		}

		$query->order($this->_db->escape('b.id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList('mid');
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
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

	/**
	* Get the teams
	*
	* @return      object
	* @since       1.0
	*/
	protected function getTeams($tid = 1)
	{
		// Getting the groups
		$query = $this->_db->getQuery(true);
		$query->select('t.*');
		$query->from(" #__worldcup_teams AS t");
		$query->where("t.tid = {$tid}");

		$query->order($this->_db->escape('t.id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList('id');
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	/**
	* Get the groups
	*
	* @return      object
	* @since       1.0
	*/
	protected function getGroups($tid = 1)
	{
		// Getting the groups
		$query = $this->_db->getQuery(true);
		$query->clean();
		$query->select('g.*');
		$query->from(" #__worldcup_groups AS g");
		$query->where("g.tid = {$tid}");

		$query->order($this->_db->escape('id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList('id');
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	function orderBy($data) { 

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
		}

		$res = array_multisort($points, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data; 
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
