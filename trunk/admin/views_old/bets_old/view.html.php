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

jimport( 'joomla.application.component.view' );

class worldcupViewBets extends JView {

	function display($tpl = null) {
   	global $mainframe;

		if($this->getLayout() == 'detail') {
		  $this->detail($tpl);
		  return;
		}

		JToolBarHelper::title(  JText::_( 'Bets' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		//JToolBarHelper::deleteList();
		//JToolBarHelper::editListX();
		//JToolBarHelper::addNewX();
		//JToolBarHelper::cancel();
		//JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart     = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = "u.usertype != 'Super Administrator' ";

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' GROUP BY u.id ORDER BY u.id ASC';

		/* Get Bets Total */
		$query = 'SELECT COUNT(*)'
		. ' FROM #__users AS u'
		. $where;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		/* Get Users */
		$query = "SELECT u.*, COUNT(b.id) AS count
			FROM #__users AS u
			LEFT JOIN #__worldcup_bets AS b ON b.uid = u.id"
		. $where
		. $orderby;
		//echo $query;

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$users = $db->loadObjectList();
		print_r($db->getError());
		//print_r($users);

		# Teams
		$query = "SELECT id, name FROM #__worldcup_teams
		          ORDER BY name";
		$db->setQuery($query);
		$teams = $db->loadAssocList('id');

		# Sended List
		$lists['sended'][] = array();
		$lists['sended'][0] = 'publish_x';
		$lists['sended'][1] = 'tick';

    $this->assignRef('users', $users);
		$this->assignRef('teams', $teams);
    $this->assignRef('lists', $lists);
    $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}

	function detail ($tpl = null) {
		global $mainframe;

		JToolBarHelper::title(  JText::_( 'Bets' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();
		$id = JRequest::getVar( 'id' );

		## 
		## Get groups
		##
		$query = "SELECT g.*
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList('id');
		//print_r($groups);

		## 
		## Get Matches clasification
		##
		for($i=1;$i<=count($groups);$i++) {

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
		$data = $this->__getSecondPhaseTable ($id);

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

	function __getSecondPhaseTable ($uid) {
		global $mainframe;

		$data = array();
		$db =& JFactory::getDBO();

		## Getting the groups
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

				//print_r($teams[$i]);echo ".<br><br>";
			}
	
			//print_r($teams[$i]);
			//echo "<br>";
			$data[$i] = $this->__orderBy($teams[$i]);
			//print_r($data);
			//echo "<br>======================================<br><br>";
		}

		return $data;
	}

	function __orderBy($data) { 

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
		}

		$res = array_multisort($points, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data; 
	} 

}
?>

