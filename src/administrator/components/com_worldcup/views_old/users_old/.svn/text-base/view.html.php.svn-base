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

class worldcupViewUsers extends JView {

	function display($tpl = null) {
   	global $mainframe;
              
		if($this->getLayout() == 'detail') {
		  $this->detail($tpl);
		  return;
		}

		JToolBarHelper::title(  JText::_( 'Users' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart     = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = "u.usertype != 'Super Administrator' ";

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' GROUP BY u.id ORDER BY u.id ASC';

		/* Get Users Total */
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

		JToolBarHelper::title(  JText::_( 'Users' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();
		$id = JRequest::getVar( 'id' );

		## Getting the groups
		$query = "SELECT t.* 
							FROM #__worldcup_teams AS t
		          ORDER BY t.id ASC";
		$db->setQuery($query);
		$teams = $db->loadObjectList('id');

		## Getting the groups
		$query = "SELECT g.* 
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		//print_r($groups);

		for($i=0;$i<count($groups);$i++) {

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

		## Getting the users
		$query = "SELECT b.mid, b.goals 
			FROM #__worldcup_bets AS b
			WHERE b.uid = {$id}
      ORDER BY b.id ASC";

		$db->setQuery($query);
		$bets = $db->loadObjectList('mid');


		$this->assignRef('bets', $bets);
		$this->assignRef('teams', $teams);
		$this->assignRef('matches', $matches);
		$this->assignRef('groups', $groups);

		parent::display($tpl);
	}


}
?>
