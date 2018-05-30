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

/**
 * @package		Joomla
 * @subpackage	Modules
 */
class WorldCupHelper
{
	function _getTableData($groups) {

		$data = array();
		$db =& JFactory::getDBO();

		for($i=1;$i<=count($groups);$i++) {

			$query = "SELECT t.id, t.name
				FROM #__worldcup_teams AS t
				WHERE t.group = {$groups[$i]->id}";
			$db->setQuery($query);
			//echo $query;
			$teams[$i] = $db->loadAssocList( 'id' );
			//print_r($teams[$i]);
			//echo "<br><br>";

			$query = "SELECT r.mid, m.team1, m.team2, r.local, r.visit
				FROM #__worldcup_results AS r
				LEFT JOIN #__worldcup_matches AS m ON m.id = r.mid
				WHERE m.group = {$groups[$i]->id}
				ORDER BY r.mid ASC";

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

				$teams[$i][$bet->team1]['diff'] += $bet->local;
				$teams[$i][$bet->team1]['diff'] -= $bet->visit;

				$teams[$i][$bet->team2]['diff'] += $bet->visit;
				$teams[$i][$bet->team2]['diff'] -= $bet->local;

				//print_r($teams[$i]);echo ".<br><br>";
			}

			//print_r($teams[$i]);
			//echo "<br><br>";
			$data[$i] = WorldCupHelper::_orderBy($teams[$i]);
			//print_r($data);
			//echo "<br>======================================<br><br>";
		}

		return $data;
	}

	function _getSecondPhaseTable ($uid) {
		global $mainframe;

		$data = array();
		$db =& JFactory::getDBO();

		##
		## Getting the groups
		##
		$query = "SELECT g.*
			FROM #__worldcup_groups AS g";
		$db->setQuery($query);
		//echo $query;
		$groups = $db->loadAssocList( 'id' );
		//print_r($groups);

		for($i=1;$i<=count($groups);$i++) {

			$query = "SELECT t.id, t.name
				FROM #__worldcup_teams AS t
				WHERE t.group = {$groups[$i]['id']}";
			$db->setQuery($query);
			//echo $query;
			$teams[$i] = $db->loadAssocList( 'id' );
			//print_r($teams[$i]);
			//echo "<br><br>";

			$query = "SELECT b.mid, m.team1, m.team2, b.local, b.visit
				FROM #__worldcup_bets AS b
				LEFT JOIN #__worldcup_matches AS m ON m.id = b.mid
				WHERE b.uid = {$uid}
				AND m.group = {$groups[$i]['id']}
				ORDER BY b.mid ASC";

			$db->setQuery($query);
			//echo $query;
			$bets = $db->loadObjectList( );
			//print_r($bets);
			//echo "<br><br>";

			for($y=0;$y<count($bets);$y++) {
				$bet = &$bets[$y];

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

				$teams[$i][$bet->team1]['diff'] += $bet->local;
				$teams[$i][$bet->team1]['diff'] -= $bet->visit;

				$teams[$i][$bet->team2]['diff'] += $bet->visit;
				$teams[$i][$bet->team2]['diff'] -= $bet->local;

				//print_r($teams[$i]);echo ".<br><br>";

			}

			//print_r($teams[$i]);
			//echo "<br>";
			$data[$i] = WorldCupHelper::_orderBy($teams[$i]);
			//print_r($data);
			//echo "<br>======================================<br><br>";

		}

		return $data;
	}

	##
	## _getClasifiedTeams
	##
	function _getClasifiedTeams ($round, $uid = false) {
		global $mainframe;

		$data = array();
		$db =& JFactory::getDBO();

		##
		## Get groups
		##
		$query = "SELECT g.*
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList('id');

		if ($uid == false) {
			##
			## Results
			##
			$query = "SELECT mid, local, visit FROM #__worldcup_results
					      ORDER BY mid";
			$db->setQuery($query);
			$results = $db->loadAssocList('mid');
			##
			## Get Data for table groups
			##
			$data = WorldCupHelper::_getTableData($groups);
		}else{
			##
			## Bets
			##
			$query = "SELECT mid, local, visit FROM #__worldcup_bets
								WHERE uid = $uid
					      ORDER BY mid";
			$db->setQuery($query);
			$results = $db->loadAssocList('mid');

			##
			## Get Data for table groups
			##
			$data = WorldCupHelper::_getSecondPhaseTable($uid);

		}

		##
		## Get matches
		##
		$where = array();
		$where[] = "m.phase = {$round}";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' ORDER BY m.id ASC';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches = $db->loadObjectList();

		##
		## Get clasifieds
		##
		$clasifieds = array();

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$pos1 = substr($match->team1, 0, 1);
			$group1 = WorldCupHelper::_recursiveArraySearch($groups, substr($match->team1, 1, 2) );

			$pos2 = substr($match->team2, 0, 1);
			$group2 = WorldCupHelper::_recursiveArraySearch($groups, substr($match->team2, 1, 2) );

			//echo "{$match->team1} - {$match->team2} <br> $pos1 - $group1 == $pos2 - $group2<br><br>";
			//echo $data[$group1][$pos1-1]['name'] . "<br>";
			//echo $data[$group2][$pos2-1]['name'] . "<br><br>";

		  $result = &$results[$match->id];
			//print_r($result);
			//echo "<br><br>";

			if ($result['local'] > $result['visit']) {
				$clasifieds[] = $data[$group1][$pos1-1]['id'];
			}else if ($result['local'] < $result['visit']) {
				$clasifieds[] = $data[$group2][$pos2-1]['id'];
			}

		}

		return $clasifieds;
	}

	function _orderBy($data) {

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
				$diff[$key] = $row['diff'];
		}

		$res = array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data;
	}

	function _recursiveArraySearch($haystack, $needle, $index = null) {
		$aIt     = new RecursiveArrayIterator($haystack);
		$it    = new RecursiveIteratorIterator($aIt);

		while($it->valid()) {
		  if (((isset($index) AND ($it->key() == $index))
				OR (!isset($index))) AND ($it->current() == $needle)) {
		      return $aIt->key();
		  }

		  $it->next();
		}

		return false;
	}

}
