<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Modules
 */
class WorldCupHelper
{

	function getTournaments($tid) { 
		$db =& JFactory::getDBO();

		# Tournaments
		$query = 'SELECT t.*'
		. ' FROM #__worldcup_tournaments AS t'
		. ' ORDER BY id DESC';
		//echo $query;
		$db->setQuery( $query );
		$tournaments = $db->loadObjectList();

		return JHTML::_('select.genericlist', $tournaments, 'tid', null, 'id', 'title', $tid);
	}

	function _getTableData($groups) { 

		$data = array();
		$db =& JFactory::getDBO();

		for($i=1;$i<=count($groups);$i++) {

			$query = "SELECT t.id, t.name, NULL as points, NULL as gf, NULL as ge, NULL as diff 
				FROM #__worldcup_teams AS t
				WHERE t.group = {$groups[$i]->id}"; 
			$db->setQuery($query);
			//echo $query;
			$teams[$i] = $db->loadAssocList( 'id' );
			//$teams[$i]['points'] = '';

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

	function _orderBy($data) { 

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
				$diff[$key] = $row['diff'];
		}

		$res = @array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data; 
	}

}
