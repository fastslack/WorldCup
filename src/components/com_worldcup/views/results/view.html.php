<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewResults extends WorldCupView
{

	function display($tpl = null)
	{
   	global $mainframe;

		$db = JFactory::getDBO();

		// Create a new query object.
		$query	= $this->_db->getQuery(true);

		// Select the required fields from the table.
		$query->select("g.*");
		$query->from('#__worldcup_groups AS g');
		$query->where("published = 1");

		// Set query
		$db->setQuery($query);

		// Execute the query
		try {
			$groups = $db->loadAssocList( 'id' );
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}

		##
		## Get Data for table groups
		##
		$data = $this->_results->_getTableData($groups);

		##
		## Get matches
		##
		$where = array();
		$where[] = "m.phase = 0";
		$where[] = "m.tid = 4";


		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' ORDER BY m.id ASC';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();
		print_r($db->getError());
		//print_r($matches);

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
		## Get Matches 4tos
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
		## Get Matches Semi
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
		## Get Matches 3rd
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
		## Get Matches final
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
		## Get teams
		##
		$query = "SELECT id, name FROM #__worldcup_teams
		          ORDER BY name";
		$db->setQuery($query);
		$teams = $db->loadAssocList('id');

		##
		## Get results
		##
		$query = "SELECT *
							FROM #__worldcup_results
		          ORDER BY mid";
		$db->setQuery($query);
		$results = $db->loadAssocList('mid');
		//echo $db->getErrorMsg();
		//print_r($results);

		##
		## Send data to template
		##
		$this->assignRef('data', $data);
		$this->assignRef('groups', $groups);
    $this->assignRef('matches', $matches);
		$this->assignRef('matches8vo', $matches8vo);
		$this->assignRef('teams', $teams);
    $this->assignRef('results', $results);
    $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}

	function _getTableData($groups) {

		$data = array();
		$db = JFactory::getDBO();

		//for($i=1;$i<=count($groups);$i++)
		foreach ($groups as $key => $value)
		{
			// Create a new query object.
			$query	= $this->_db->getQuery(true);

			// Select the required fields from the table.
			$query->select("t.id, t.name");
			$query->from('#__worldcup_teams AS t');
			$query->where("t.group = {$value['id']}");

			// Set query
			$db->setQuery($query);

			// Execute the query
			try {
				$teams[$i] = $db->loadAssocList( 'id' );
			} catch (RuntimeException $e) {
				throw new RuntimeException($e->getMessage());
			}

			// Select the required fields from the table.
			$query->select("r.mid, m.team1, m.team2, r.local, r.visit");
			$query->from('#__worldcup_results AS r');
			$query->join('LEFT', '#__worldcup_matches AS m ON m.id = r.mid');
			$query->where("m.group = {$value['id']}");
			$query->order("r.mid ASC");

			// Set query
			$db->setQuery($query);

			// Execute the query
			try {
				$bets = $db->loadObjectList( );
			} catch (RuntimeException $e) {
				throw new RuntimeException($e->getMessage());
			}

			// bets
			for($y=0;$y<count($bets);$y++)
			{
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
			$data[$i] = $this->_orderBy($teams[$i]);
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

		$res = array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data;
	}

}
?>
