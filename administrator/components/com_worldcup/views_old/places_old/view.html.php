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

class worldcupViewPlaces extends JView {

	function display($tpl = null) {
   	global $mainframe;

		if($this->getLayout() == 'form') {
		  $this->_displayForm($tpl);
		  return;
		}

		JToolBarHelper::title(  JText::_( 'WorldCup Places' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		//JToolBarHelper::cancel();
		//JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$filter_order	  = $mainframe->getUserStateFromRequest( 'filter_order', 'filter_order', 'g.name', 'cmd' );
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
      $filter_order = 'g.id';
    }

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		//$orderby	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$orderby	= ' ORDER BY g.name ASC';

		/* Get Places Total */
		$query = 'SELECT COUNT(*)'
		. ' FROM #__worldcup_places AS g'
		. $where;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		/* Get Places */
		$query = 'SELECT g.*, t.title AS tournament'
		. ' FROM #__worldcup_places AS g'
		. ' LEFT JOIN #__worldcup_tournaments AS t ON t.id = g.tid'
		. $where
		. $orderby;
		//echo $query;

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$places = $db->loadObjectList();
		print_r($db->getError());

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search'] = $search;

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

    $this->assignRef('places', $places);
    $this->assignRef('lists', $lists);
		$this->assignRef('tid', $tid);
    $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}

	function _displayForm ($tpl = null) {
		global $mainframe;

		$db =& JFactory::getDBO();
		$task = JRequest::getVar( 'task' );
		$tid = JRequest::getVar( 'tournament' );
		$hid  = JRequest::getVar( 'cid', array(), 'post', 'array' );

		if ($task == "edit") {
			$title = JText::_( 'Edit Place' );
		}else{
			$title = JText::_( 'Add Place' );
		}

		JToolBarHelper::title( $title, 'plugin.png' );
		JToolBarHelper::custom('display', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::save();
		JToolBarHelper::spacer();

		$place = new TableWorldCupPlaces($db);
		$place->load($hid[0]);

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

		$this->assignRef('title', $title);
		$this->assignRef('lists', $lists);
		$this->assignRef('place', $place);
		$this->assignRef('tid', $tid);

		parent::display($tpl);
	} 

}
?>
