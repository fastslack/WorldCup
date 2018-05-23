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

class worldcupViewTeams extends JView {

	function display($tpl = null) {
   	global $mainframe;
              
		if($this->getLayout() == 'form') {
		  $this->_displayForm($tpl);
		  return;
		}

		JToolBarHelper::title(  JText::_( 'Teams' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		//JToolBarHelper::cancel();
		//JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$filter_order	  = $mainframe->getUserStateFromRequest( 'filter_order', 'filter_order', 't.group', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( 'filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$search		  = $mainframe->getUserStateFromRequest( 'search','search','','string' );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart     = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );
		$tid = JRequest::getVar( 'tid' );

		if (!$tid) {
			$tid = 1;
		}

		$where = array();
		$where[] = "g.tid = {$tid}";

		if ($search) {
			$where[] = 'LOWER(g.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

    if ($filter_order == '') {
      $filter_order = 'g.name';
    }
    if ($filter_order_Dir == '') {
      $filter_order_Dir = 'ASC';
    }

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' ORDER BY g.name ASC';

		/* Get Teams Total */
		$query = 'SELECT COUNT(*)'
		. ' FROM #__worldcup_teams AS t'
		. $where;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		/* Get Teams */
		$query = 'SELECT t.*, g.name AS gname'
		. ' FROM #__worldcup_teams AS t'
		. ' LEFT JOIN #__worldcup_groups AS g ON g.id = t.group'
		. $where
		. $orderby;
		//echo $query;

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$teams = $db->loadObjectList();
		print_r($db->getError());

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

    $this->assignRef('teams', $teams);
    $this->assignRef('lists', $lists);
    $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}

	function _displayForm ($tpl = null) {
		global $mainframe;

		$db   =& JFactory::getDBO();
		$task = JRequest::getVar( 'task' );
		$hid  = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$tid = JRequest::getVar( 'tournament' );

		if ($task == "edit") {
			$title = JText::_( 'Edit Team' );
		}else{
			$title = JText::_( 'Add Team' );
		}

		JToolBarHelper::title( $title, 'plugin.png' );
		JToolBarHelper::custom('display', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::save();
		JToolBarHelper::spacer();

		$teams = new TableWorldCupTeams($db);
		$teams->load($hid[0]);

		## Getting the users
/*
		$query = "SELECT id, username FROM #__users
		          ORDER BY username";
		$db->setQuery($query);
		$usrs = $db->loadObjectList();
		$u[] = JHTML::_( 'select.option', '0', 'No User', 'id', 'username' );
		$users = array_merge($u, $usrs);

		$lists['users']  = JHTML::_('select.genericlist', $users, 'uid', 'style="width: 135px;"', 'id',
     'username', $teams->uid); 
*/
		## Getting the groups
		$query = "SELECT id, name FROM #__worldcup_groups
		          ORDER BY name";
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		//print_r($groups);
/*
		$query = "SELECT gid FROM #__worldcup_usergroups
		          WHERE sid = {$hid[0]}";
		$db->setQuery($query);
		$sel = $db->loadResultArray();
*/
		$lists['groups']  = JHTML::_('select.genericlist', $groups, 'group', 'style="width: 135px;"', 'id',
     'name', null); 

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

		$this->assignRef('title', $title);
		$this->assignRef('lists', $lists);
		$this->assignRef('teams', $teams);	

		parent::display($tpl);
	} 

}
?>
