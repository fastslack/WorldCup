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

class worldcupViewMatches extends JView {

	function display($tpl = null) {
   	global $mainframe;
              
		if($this->getLayout() == 'form') {
		  $this->_displayForm($tpl);
		  return;
		}

		JToolBarHelper::title(  JText::_( 'Matches' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		//JToolBarHelper::cancel();
		//JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();
		$tid = JRequest::getVar( 'tid' );

		if (!$tid) {
			$tid = 1;
		}

		// Getting teams
		$query = "SELECT id, name FROM #__worldcup_teams WHERE tid = {$tid}
		          ORDER BY name";
		$db->setQuery($query);
		$teams = $db->loadAssocList('id');

		$teamscount = count($teams);

		$matches[] = $this->loadMatches($tid, 0);
		$matches[] = $this->loadMatches($tid, 1);
		$matches[] = $this->loadMatches($tid, 2);
		$matches[] = $this->loadMatches($tid, 3);
		$matches[] = $this->loadMatches($tid, 4);
		if ($teamscount > 12) {
			$matches[] = $this->loadMatches($tid, 5);
		}

		## Teams
		$query = "SELECT id, name FROM #__worldcup_teams WHERE tid = {$tid}
		          ORDER BY name";
		$db->setQuery($query);
		$teams = $db->loadAssocList('id');

		## Phases
		$phases = array();
		$phases[] = JText::_( 'Clasification' );
		if ($teamscount > 12) {
			$phases[] = JText::_( 'Round of 16' );
		}
		$phases[] = JText::_( 'Quarter-finals' ); 
		$phases[] = JText::_( 'Semi-finals' ); 
		$phases[] = JText::_( 'Match for third place' );
		$phases[] = JText::_( 'Final' );

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

    $this->assignRef('matches', $matches);
		$this->assignRef('teams', $teams);
    $this->assignRef('lists', $lists);
		$this->assignRef('tid', $tid);
    $this->assignRef('phases', $phases);
		$this->assignRef('teamscount', $teamscount);

		parent::display($tpl);
	}

	function _displayForm ($tpl = null) {
		global $mainframe;

		$db   =& JFactory::getDBO();
		$task = JRequest::getVar( 'task' );
		$hid  = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$tid = JRequest::getVar( 'tournament' );

		if ($task == "edit") {
			$title = JText::_( 'Edit Match' );
		}else{
			$title = JText::_( 'Add Match' );
		}

		JToolBarHelper::title( $title, 'plugin.png' );
		JToolBarHelper::custom('display', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::save();
		JToolBarHelper::spacer();

		$matches = new TableWorldCupMatches($db);
		$matches->load($hid[0]);
		//print_r($matches);

		$date =& JFactory::getDate($matches->date);          
		$format = '%b/%d %H:%M';

		$mdate = $date->toFormat('%Y-%m-%d');
		$mhour = $date->toFormat('%H');
		$mminutes = $date->toFormat('%M');

		# Place list
		$query = "SELECT id, name FROM #__worldcup_places WHERE tid = {$tid}
		          ORDER BY name";
		$db->setQuery($query);
		$places = $db->loadObjectList();
		$u[] = JHTML::_( 'select.option', '0', '-Place-', 'id', 'name' );
		$places = array_merge($u, $places);

		$lists['places']  = JHTML::_('select.genericlist', $places, 'place', 'style="width: 135px;"', 'id',
     'name', $matches->place); 

		# Groups
		$query = "SELECT id, name FROM #__worldcup_groups WHERE tid = {$tid}
		          ORDER BY name";
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		$g[] = JHTML::_( 'select.option', '0', '-Group-', 'id', 'name' );
		$groups = array_merge($g, $groups);

		$lists['groups']  = JHTML::_('select.genericlist', $groups, 'group', 'style="width: 135px;"', 'id',
     'name', $matches->group); 

		# Teams
		$query = "SELECT id, name FROM #__worldcup_teams WHERE tid = {$tid}
		          ORDER BY name";
		$db->setQuery($query);
		$team1 = $db->loadObjectList();

		$t1[] = JHTML::_( 'select.option', '0', '-Team 1-', 'id', 'name' );
		$t2[] = JHTML::_( 'select.option', '0', '-Team 2-', 'id', 'name' );
		$team2 = array_merge($t2, $team1);
		$team1 = array_merge($t1, $team1);

		$lists['team1']  = JHTML::_('select.genericlist', $team1, 'team1', 'style="width: 135px; "', 'id',
     'name', $matches->team1);
		$lists['team2']  = JHTML::_('select.genericlist', $team2, 'team2', 'style="width: 135px;"', 'id',
     'name', $matches->team2); 

		# Lists
		$hour[] = JHTML::_( 'select.option', 0, '-Hour-' );
		for($i=0;$i<=24;$i++){
			$hour[] = JHTML::_( 'select.option', $i, $i );
		}
		$lists['hour'] = JHTML::_('select.genericlist', $hour, 'hour', 'class="inputbox" ', 'value', 'text', $mhour );

		$minutes[] = JHTML::_( 'select.option', '00', '-Minutes-' );
		$minutes[] = JHTML::_( 'select.option', '00', '00' );
		$minutes[] = JHTML::_( 'select.option', '30', '30' );
		$lists['minutes'] = JHTML::_('select.genericlist', $minutes, 'minutes', 'class="inputbox" ', 'value', 'text', $mminutes );

		## Phase list
		$phases[] = JHTML::_( 'select.option', '0', 'Clasification' );
		$phases[] = JHTML::_( 'select.option', '1', 'Round of 16' );
		$phases[] = JHTML::_( 'select.option', '2', 'Quarter-finals' );
		$phases[] = JHTML::_( 'select.option', '3', 'Semi-finals' );
		$phases[] = JHTML::_( 'select.option', '4', 'Match for third place' );
		$phases[] = JHTML::_( 'select.option', '5', 'Final' );

		$lists['phases'] = JHTML::_('select.genericlist', $phases, 'phase', 'class="inputbox" ', 'value', 'text', $matches->phase );

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

		$this->assignRef('mdate', $mdate);
		$this->assignRef('title', $title);
		$this->assignRef('lists', $lists);
		$this->assignRef('matches', $matches);	

		parent::display($tpl);
	} 

	function getPhaseHTML($phase) {
?>
		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo $this->phases[$phase]; ?></h3>
			</td>
		</tr>
		</table>
		<table class="adminlist">
		<thead>
		<tr>
			<th width="20">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Date', 'm.date', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Place', 'p.name', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Team', 'm.team1', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="5" nowrap="nowrap">
		
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Team', 'm.team2', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="15%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Phase', 'm.phase', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
		</tr>
		</thead>
		<?php		          
				$matches = $this->matches[$phase];
				//print_r($matches);

				for ($i=0, $n=count( $matches ); $i < $n; $i++) {
					$match = &$matches[$i];
					$checked = JHTML::_('grid.checkedout', $match, $i );
					//$published 	= JHTML::_('grid.published', $match, $i );

					$date =& JFactory::getDate($match->date);          
					$format = '%b/%d %H:%M';

		?>
					<tr class="<?php echo "row$k"; ?>">
						<td align="center">
							<?php echo $match->id; ?>
						</td>
						<td align="center">
							<?php echo $checked; ?>
						</td>
						<td align="center">
							<?php echo $date->toFormat($format); ?>
						</td>
						<td>
							<?php echo $match->pname;?>
						</td>
						<td align="right">
							<img src="components/com_worldcup/images/flags/<?php echo $match->team1; ?>.png">
							<?php 
								if ($phase > 0){
									echo $match->team1;
								}else{				
									echo $this->teams[$match->team1]['name'];
								}
							?>
						</td>
						<td>
							<small>vs</small>
						</td>
						<td>
							<img src="components/com_worldcup/images/flags/<?php echo $match->team2; ?>.png">
							<?php 
								if ($phase > 0){
									echo $match->team2;
								}else{				
									echo $this->teams[$match->team2]['name'];
								}
							?>
						</td>
						<td align="center">
							<?php echo $this->phases[$match->phase];?>
						</td>
					</tr>
		<?php
				}
		?>
		</tbody>
		</table>
<?php
	}

	function loadMatches($tid, $phase) {

		$db =& JFactory::getDBO();

		/*
		 * Get Matches
     */
		$where = array();
		$where[] = "m.tid = {$tid}";
		$where[] = "m.phase = {$phase}";

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= " ORDER BY m.id ASC";

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;

		$db->setQuery( $query );
		$return = $db->loadObjectList();
		//print_r($db->getError());
		//print_r($matches[0]);

		return $return;
	}
}
?>
