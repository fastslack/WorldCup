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
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

JLoader::register('WorldcupBets', JPATH_COMPONENT_ADMINISTRATOR.'/includes/bets.php');
JLoader::register('WorldcupMatches', JPATH_COMPONENT_ADMINISTRATOR.'/includes/matches.php');
JLoader::register('WorldcupTeams', JPATH_COMPONENT_ADMINISTRATOR.'/includes/teams.php');
JLoader::register('WorldcupTournaments', JPATH_COMPONENT_ADMINISTRATOR.'/includes/tournaments.php');

/**
 * WorldcupViewResults View
 */
class WorldcupViewResults extends JViewLegacy {

	protected $items;

	protected $pagination;

	protected $state;

	function display($tpl = null) {

		// Loader
		JLoader::import('helpers.worldcup', JPATH_COMPONENT_ADMINISTRATOR);

		$betsObj = new WorldcupBets();
		$matchesObj = new WorldcupMatches();
		$teamsObj = new WorldcupTeams();
		$tournamentObj = new WorldcupTournaments();

		$this->state		= $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Get the user id and tournament id
		$user_id = JFactory::getApplication()->input->get('id');
		$tid = (int) $this->state->get('filter.tid');

		// Get groups
		$this->groups = $tournamentObj->getGroupsList($tid);

		// Get Data for table groups
		$this->data = $tournamentObj->getGroupsTable($tid, $this->groups, 'results');

		// Get the matches
		$this->matches = array();
		for($i=0;$i<=5;$i++)
		{
			$this->matches[$i] = $matchesObj->getMatchesList($tid, $i);
		}

		// Get the second phase table of this user
		$this->results = $matchesObj->getResultsList($tid);
		// Get teams
		$this->teams = $teamsObj->getTeamsList($tid);
		// Get Phases
		$this->phases =	WorldcupHelper::getPhases(count($this->teams));

		// Add the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		$canDo = JHelperContent::getActions('com_worldcup', 'result', $this->state->get('filter.published'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_RESULTS_TITLE' ), 'plugin.png' );

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('result.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('result.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('results.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('results.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		JToolBarHelper::cancel('results.cancel', 'JTOOLBAR_CLOSE');
		JToolBarHelper::spacer();
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
							't.tid' =>  JText::_('COM_WORLDCUP_RESULTS_TID'),
				't.date' =>  JText::_('COM_WORLDCUP_RESULTS_DATE'),
				't.group' =>  JText::_('COM_WORLDCUP_RESULTS_GROUP'),
				't.place' =>  JText::_('COM_WORLDCUP_RESULTS_PLACE'),
				't.team1' =>  JText::_('COM_WORLDCUP_RESULTS_TEAM1'),
				't.team2' =>  JText::_('COM_WORLDCUP_RESULTS_TEAM2'),
				't.phase' =>  JText::_('COM_WORLDCUP_RESULTS_PHASE'),
				't.published' =>  JText::_('COM_WORLDCUP_RESULTS_PUBLISHED'),
				't.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	/**
	 * recursiveArraySearch
	 *
	 * @return  int  $haystack  The haystack.
	 * @return  int  $needle    The needle.
	 * @return  int  $index     The index.
	 *
	 * @since   3.0
	 */
	function recursiveArraySearch($haystack, $needle, $index = null) {
		$aIt     = new RecursiveArrayIterator($haystack);
		$it    = new RecursiveIteratorIterator($aIt);

		while($it->valid()) {       
			if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) {
				return $aIt->key();
			}

			$it->next();
		}

		return false;
	} 
	/**
	 * Returns the results list
	 *
	 * @return  int  The id of the phase
	 *
	 * @since   3.0
	 */
	protected function getHTMLHeader($phase)
	{
		// Set the date format
		$format = 'd/m H:i';
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
				<th width="20" nowrap="nowrap">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?>
				</th>
				<th width="20%" nowrap="nowrap" align="left">
					<?php echo JText::_( 'Place' ); ?>
				</th>
				<th width="20%" nowrap="nowrap" align="right">
					<?php echo JText::_( 'Team' ); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					&nbsp;
				</th>
				<th width="20%" nowrap="nowrap" align="left">
					<?php echo JText::_( 'Team' ); ?>
				</th>
				<th width="13%" nowrap="nowrap" align="left">
					<?php echo JText::_( 'Actions' ); ?>
				</th>
			</tr>
		</thead>
<?php

	}

	/**
	 * Returns the results list
	 *
	 * @return  int  The id of the phase
	 *
	 * @since   3.0
	 */
	protected function getResultList22($phase)
	{
		// Set the date format
		$format = 'd/m H:i';

		$this->getHTMLHeader($phase);

		echo "<tbody>";

		for ($i=0, $n=count( $this->matches[$phase] ); $i < $n; $i++) {
			// Get the match
			$match = &$this->matches[$phase][$i];
			// Get the correct date
			$date =& JFactory::getDate($match->date);
			// Get the result 
			$result = & $this->results[$match->id];
			// Declare variables
			$local = $visit = $disabled = "";
			// Check results
			if (!empty($result->mid)) {
				$local = $result->local;
				$visit = $result->visit;
				$disabled = "disabled";
			}
?>
			<tr class="odd">
				<td align="center">
					<?php echo $match->id;?>
				</td>
				<td align="center">
					<?php echo $date->format($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $match->team1; ?>.png">
					<?php echo $this->teams[$match->team1]->name;?>
				</td>
				<td align="center">
					<input size="1" type="text" id="l<?php echo $match->id; ?>" class="span4" value="<?php echo $local; ?>" <?php echo $disabled; ?>>
					<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $match->team1; ?>" />
					&nbsp;<small>vs</small>&nbsp;
					<input size="1" type="text" id="v<?php echo $match->id; ?>" class="span4" value="<?php echo $visit; ?>" <?php echo $disabled; ?>>	
					<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $match->team2; ?>" />
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $match->team2; ?>.png">
					<?php echo $this->teams[$match->team2]->name;?>
				</td>
				<td align="left">
					<div class="save" title="<?php echo $match->id; ?>" >
						<i class="icon-checkmark "></i>
					</div>
					<div class="delete" title="<?php echo $match->id; ?>" >
						<i class="icon-cancel "></i>
					</div>
				</td>
			</tr>

<?php	} ?>
		</tbody>
		</table>
<?php
	}

	/**
	 * Returns the results list
	 *
	 * @return  int  The id of the phase
	 *
	 * @since   3.0
	 */
	protected function getResultList($phase)
	{
		// Set the date format
		$format = 'd/m H:i';

		$this->getHTMLHeader($phase);

		echo "<tbody>";

		for ($i=0, $n=count( $this->matches[$phase] ); $i < $n; $i++) {
			// Get the match
			$match = &$this->matches[$phase][$i];
			// Get the correct date
			$date =& JFactory::getDate($match->date);
			// Get the result 
			$result = & $this->results[$match->id];
			// Declare variables
			$local = $visit = $local_id = $visit_id = $disabled = "";
			// Check results
			if (!empty($result->mid)) {
				$local = $result->local;
				$visit = $result->visit;
				$disabled = "disabled";
			}

			// Check values
			switch ($phase) {
				case 0:
					$local_id = isset($match->team1) ? $match->team1 : '';
					$visit_id = isset($match->team2) ? $match->team2 : '';
					$local_name = isset($this->teams[$match->team1]->name) ? $this->teams[$match->team1]->name : '';
					$visit_name = isset($this->teams[$match->team2]->name) ? $this->teams[$match->team2]->name : '';
					break;
				case 1:
					$pos1 = substr($match->team1, 0, 1);
					$group1 = $this->recursiveArraySearch($this->groups, substr($match->team1, 1, 2) );

					$pos2 = substr($match->team2, 0, 1);
					$group2 = $this->recursiveArraySearch($this->groups, substr($match->team2, 1, 2) );

					$local_id = isset($this->data[$group1][$pos1-1]['id']) ? $this->data[$group1][$pos1-1]['id'] : '';
					$visit_id = isset($this->data[$group2][$pos2-1]['id']) ? $this->data[$group2][$pos2-1]['id'] : '';
					$local_name = isset($this->data[$group1][$pos1-1]['name']) ? $this->data[$group1][$pos1-1]['name'] : '';
					$visit_name = isset($this->data[$group2][$pos2-1]['name']) ? $this->data[$group2][$pos2-1]['name'] : '';
				break;
				case 2:

					$winner1 = substr($match->team1, 1, 3);
					$winner2 = substr($match->team2, 1, 3);

					if ($this->results[$winner1]['local'] > $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team1'];
					}else if ($this->results[$winner1]['local'] < $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team2'];
					}

					if ($this->results[$winner2]['local'] > $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team1'];
					}else if ($this->results[$winner2]['local'] < $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team2'];
					}

					$local_name = isset($this->teams[$local_id]->name) ? $this->teams[$local_id]->name : '';
					$visit_name = isset($this->teams[$visit_id]->name) ? $this->teams[$visit_id]->name : '';

				break;
				case 3:

					$winner1 = substr($match->team1, 1, 3);
					$winner2 = substr($match->team2, 1, 3);

					if ($this->results[$winner1]['local'] > $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team1'];
					}else if ($this->results[$winner1]['local'] < $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team2'];
					}

					if ($this->results[$winner2]['local'] > $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team1'];
					}else if ($this->results[$winner2]['local'] < $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team2'];
					}

					$local_name = isset($this->teams[$local_id]->name) ? $this->teams[$local_id]->name : '';
					$visit_name = isset($this->teams[$visit_id]->name) ? $this->teams[$visit_id]->name : '';

				break;
				case 4:

					$winner1 = substr($match->team1, 1, 3);
					$winner2 = substr($match->team2, 1, 3);

					if ($this->results[$winner1]['local'] > $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team1'];
					}else if ($this->results[$winner1]['local'] < $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team2'];
					}

					if ($this->results[$winner2]['local'] > $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team1'];
					}else if ($this->results[$winner2]['local'] < $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team2'];
					}

					$local_name = isset($this->teams[$local_id]->name) ? $this->teams[$local_id]->name : '';
					$visit_name = isset($this->teams[$visit_id]->name) ? $this->teams[$visit_id]->name : '';

				break;
				case 5:

					$winner1 = substr($match->team1, 1, 3);
					$winner2 = substr($match->team2, 1, 3);

					if ($this->results[$winner1]['local'] > $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team1'];
					}else if ($this->results[$winner1]['local'] < $this->results[$winner1]['visit']) {
						$local_id = $this->results[$winner1]['team2'];
					}

					if ($this->results[$winner2]['local'] > $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team1'];
					}else if ($this->results[$winner2]['local'] < $this->results[$winner2]['visit']) {
						$visit_id = $this->results[$winner2]['team2'];
					}

					$local_name = isset($this->teams[$local_id]->name) ? $this->teams[$local_id]->name : '';
					$visit_name = isset($this->teams[$visit_id]->name) ? $this->teams[$visit_id]->name : '';

				break;
			}

			$local_id = !empty($local_id) ? $local_id : 0;
			$visit_id = !empty($visit_id) ? $visit_id : 0;	
?>
			<tr class="odd">
				<td>
					<?php echo $match->id;?>
				</td>
				<td align="center">
					<?php echo $date->format($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $local_id; ?>.png">
					<?php echo $local_name;?>
				</td>
				<td align="center">
					<input size="1" type="text" id="l<?php echo $match->id; ?>" class="span4" value="<?php echo $local; ?>" <?php echo $disabled; ?>>
					<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $local_id; ?>" />
		      &nbsp;<small>vs</small>&nbsp;
					<input size="1" type="text" id="v<?php echo $match->id; ?>" class="span4" value="<?php echo $visit; ?>" <?php echo $disabled; ?>>
					<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $visit_id; ?>" />
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $visit_id; ?>.png">
					<?php echo $visit_name;?>
				</td>
				<td align="center">
					<div class="save" title="<?php echo $match->id; ?>" >
						<img src="templates/hathor/images/header/icon-48-apply.png">
					</div>
					<div class="edit" title="<?php echo $match->id; ?>" >
						<img src="templates/hathor/images/header/icon-48-edit.png">
					</div>
					<div class="delete" title="<?php echo $match->id; ?>" >
						<img src="templates/hathor/images/header/icon-48-deny.png">
					</div>
				</td>
			</tr>

<?php	} ?>
		</tbody>
		</table>
<?php
	}


}
