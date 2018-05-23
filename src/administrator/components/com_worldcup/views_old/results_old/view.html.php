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

class worldcupViewResults extends JView {

	function display($tpl = null) {
   	global $mainframe;

		include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'helpers'.DS.'helper.php');

		JToolBarHelper::title(  JText::_( 'Results' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::spacer();

		$matches = array();
		$db =& JFactory::getDBO();
		$tid = JRequest::getVar( 'tid' );

		if (!$tid) {
			$tid = 1;
		}

		## 
		## Get groups
		##
		$query = "SELECT g.*
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList('id');

		## 
		## Get Data for table groups
		##
		$data = WorldCupHelper::_getTableData($groups);

		## 
		## Teams
		##
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

		## 
		## Results
		##
		$query = "SELECT * 
							FROM #__worldcup_results WHERE tid = {$tid}
		          ORDER BY mid";
		$db->setQuery($query);
		$results = $db->loadAssocList('mid');

		##
		## Phases
		##
		$phases = array();
		$phases[] = JText::_( 'Clasification' );
		if ($teamscount > 12) {
			$phases[] = JText::_( 'Round of 16' );
		}
		$phases[] = JText::_( 'Quarter-finals' ); 
		$phases[] = JText::_( 'Semi-finals' ); 
		$phases[] = JText::_( 'Match for third place' );
		$phases[] = JText::_( 'Final' );

		## Tournament
		$lists['tournaments'] = WorldCupHelper::getTournaments($tid);

		##
		## Passing data to template
		##
		$this->assignRef('phases', $phases);
    $this->assignRef('matches', $matches);
		$this->assignRef('teams', $teams);
    $this->assignRef('results', $results);
    $this->assignRef('pageNav', $pageNav);
		$this->assignRef('groups', $groups);
		$this->assignRef('data', $data);
		$this->assignRef('lists', $lists);

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
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Place' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Team' ); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					&nbsp;
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Team' ); ?>
				</th>
				<th width="13%" nowrap="nowrap">

				</th>
			</tr>
		</thead>
		<tbody>
		<?php
				//print_r($results);

			for ($i=0, $n=count( $this->matches[$phase] ); $i < $n; $i++) {
				$match = &$this->matches[$phase][$i];

				$date =& JFactory::getDate($match->date);
				$format = '%b/%d %H:%M';

				$result = &$results[$match->id];

				if ($result['mid'] != "") {
				  $local = $result['local'];
				  $visit = $result['visit'];
				  $disabled = "disabled";
				}

		?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $date->toFormat($format); ?>
					</td>
					<td>
						<?php echo $match->pname;?>
					</td>
					<td align="right">
						<img src="components/com_worldcup/images/flags/<?php echo $match->team1; ?>.png">
						<?php echo $this->teams[$match->team1]['name'];?>
					</td>
					<td align="center">
						<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php echo $local; ?>" <?php echo $disabled; ?>>
						<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $match->team1; ?>" />
				    &nbsp;<small>vs</small>&nbsp;
						<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php echo $visit; ?>" <?php echo $disabled; ?>>	
						<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $match->team2; ?>" />
					</td>
					<td>
						<img src="components/com_worldcup/images/flags/<?php echo $match->team2; ?>.png">
						<?php echo $this->teams[$match->team2]['name'];?>
					</td>
					<td align="center">
						<div class="save" title="<?php echo $match->id; ?>">
				    <img src="images/apply_f2.png" /></div>&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png" /></div>
					</td>
				</tr>
		<?php
				unset($disabled);
				unset($local);
				unset($visit);
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

