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

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewBets extends WorldCupView
{

	function display($tpl = null)
	{
		$my = JFactory::getUser();
		$app = JFactory::getApplication();

		if (empty($my->id))
		{
			// Redirect to the return page.
			$app->redirect('index.php?option=com_users&view=registration');
			$app->close();
		}

		// Get the patient id
		$this->tid = JFactory::getApplication()->input->get('tid', 4);
		$this->cid = JFactory::getApplication()->input->get('cid', 0);

		// Get the teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

		$this->competition = $this->_competitions->getCompetitionById($this->cid);

		switch ($this->getLayout()) {
			case 'step2':
				$this->step2($tpl);
				return;
			case 'step3':
				$this->step3($tpl);
				return;
			case 'step4':
				$this->step4($tpl);
				return;
			case 'step5':
				$this->step5($tpl);
				return;
			case 'step6':
				$this->step6($tpl);
				return;
			case 'step7':
				$this->step7($tpl);
				return;
		}

		// Get the groups
		$this->groups = $this->_tournaments->getGroupsList($this->tid, '');

		// Get the correct matches
		$this->matches = array();

		foreach ($this->groups as $group)
		{
			//$this->matches[] = $this->getMatches(1, $group->id);
			$this->matches[] = $this->_matches->getMatchesList($this->tid, false, $group->id);
		}

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->cid, $this->_my->id);

		// Get the results
		//$this->results = $this->getResults();

		parent::display($tpl);
	}

	function step2 ($tpl = null)
	{
		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get groups
		$this->groups = $this->_tournaments->getGroupsList($this->tid);

		// Get Data for table groups
		//$this->data = $this->_getTableData($groups);
		$this->data = $this->_bets->_getTableData($this->groups, (int)$this->cid);

		// Get Matches of 8vo
		//$this->matches = $this->getMatches(1, 0, 1);
		$this->matches = $this->_matches->getMatchesList($this->tid, 1);

		// Get the bets
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 1);
		//$this->oldbets = $this->getBets(1, 1);

		parent::display($tpl);
	}

	function step3 ($tpl = null) {

		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get Matches of 4to
		$this->matches = $this->_matches->getMatchesList($this->tid, 2, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 1);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->cid, $this->_my->id, 2);

		parent::display($tpl);
	}

	function step4 ($tpl = null) {

		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get Matches of Semi
		$this->matches = $this->_matches->getMatchesList($this->tid, 3, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 2);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);

		parent::display($tpl);
	}

	function step5 ($tpl = null) {

		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get Matches of 4to
		$this->matches = $this->_matches->getMatchesList($this->tid, 4, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->cid, $this->_my->id, 4);

		parent::display($tpl);
	}

	function step6 ($tpl = null) {

		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get Matches of final
		$this->matches = $this->_matches->getMatchesList($this->tid, 5, 0);

		// Get the old bets
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);

		// Get the bets
		$this->bets = $this->_bets->getBetsList($this->cid, $this->_my->id, 5);

		parent::display($tpl);
	}

	function step7 ($tpl = null)
	{
		$data = JFactory::getApplication()->input->post->getArray();
		$saveData = $this->sanitizeData($data);
		$this->saveData($saveData);

		// Get groups
		$this->groups = $this->_tournaments->getGroupsList($this->tid);

		// Get Data, matches, bets
		$this->data = $this->_bets->_getTableData($this->groups, $this->cid);
		$this->matches = $this->_matches->getMatchesList($this->tid, 1);
		$this->oldbets = $this->_bets->getBetsList($this->cid, $this->_my->id, 1);

		// Get Matches of 4to
		$this->matches2 = $this->_matches->getMatchesList($this->tid, 2, 0);
		$this->oldbets2 = $this->_bets->getBetsList($this->cid, $this->_my->id, 1);
		$this->bets2 = $this->_bets->getBetsList($this->cid, $this->_my->id, 2);

		// Get Matches of Semi
		$this->matches3 = $this->_matches->getMatchesList($this->tid, 3, 0);
		$this->oldbets3 = $this->_bets->getBetsList($this->cid, $this->_my->id, 2);
		$this->bets3 = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);

		// Get Matches of 4to
		$this->matches4 = $this->_matches->getMatchesList($this->tid, 4, 0);
		$this->oldbets4 = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);
		$this->bets4 = $this->_bets->getBetsList($this->cid, $this->_my->id, 4);

		// Get Matches of final
		$this->matches5 = $this->_matches->getMatchesList($this->tid, 5, 0);
		$this->oldbets5 = $this->_bets->getBetsList($this->cid, $this->_my->id, 3);
		$this->bets5 = $this->_bets->getBetsList($this->cid, $this->_my->id, 5);

		parent::display($tpl);
	}

	/**
	* Get the results
	*
	* @return      object
	* @since       1.0
	*/
	protected function getResults()
	{
		// Getting the results
		$query = $this->_db->getQuery(true);
		$query->select('r.mid');
		$query->from(" #__worldcup_results AS r");
		$query->order($this->_db->escape('r.id ASC'));

		$this->_db->setQuery($query);

		try {
			return $this->_db->loadObjectList('mid');
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	/**
	* Sanitize data
	*
	* @return      array
	* @since       1.0
	*/
	protected function sanitizeData($data)
	{
		$return = array();
		$cid = JFactory::getApplication()->input->get('cid', false);
		// @@ TODO: Fix hardcode
		$tid = JFactory::getApplication()->input->get('tid', 4);

		if ($cid == false)
		{
			return false;
		}

		foreach ($data as $key => $value)
		{
			$letter = explode('-', $key);
			$k = $letter[1];

			$return[$k]['tid'] = $tid;
			$return[$k]['cid'] = $cid;
			$return[$k]['mid'] = $k;
			$return[$k]['uid'] = $this->_my->id;

			if ($letter[0] == 'l')
			{
				$return[$k]['local'] = (int) $value;
			}
			elseif ($letter[0] == 'v') {
				$return[$k]['visit'] = (int) $value;
			}
			elseif ($letter[0] == 'team1') {
				$return[$k]['team1'] = $value;
			}
			elseif ($letter[0] == 'team2') {
				$return[$k]['team2'] = $value;
			}
			elseif ($letter[0] == 'pLocal') {
				$return[$k]['pLocal'] = $value;
			}
			elseif ($letter[0] == 'pVisit') {
				$return[$k]['pVisit'] = $value;
			}
		}

		return $return;
	}

	/**
	* Save data
	*
	* @return      array
	* @since       1.0
	*/
	protected function saveData($data)
	{
		foreach ($data as $key => $value)
		{
			$table = $this->get('Table');
			$load = $value;
			$table->load($load);

			if (!empty($table->id))
			{
				$table->load($load);
			}

			$table->save($load);
		}
	}


	/**
	* Print table header
	*
	* @return      array
	* @since       1.0
	*/
	protected function printTableHeader()
	{
?>
		<thead>
			<tr>
				<th width="30%" nowrap="nowrap">
					<?php echo JText::_( 'Match' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Result' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Penalties' ); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					<?php echo JText::_( 'Date' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Place' ); ?>
				</th>
			</tr>
		</thead>
<?php
	}


	/**
	* Print table header
	*
	* @return      array
	* @since       1.0
	*/
	protected function printTableRows($matches, $bets, $oldbets, $reverse = false, $readonly = '')
	{
		$readonly2 = '';

		if ($readonly != '')
		{
			$readonly = "readonly='readonly'";
		}


		foreach ($matches as $key => $match)
		{

			$date = JFactory::getDate($match->date);
			$format = 'd/m H:i';

			$winner1 = (int) substr($match->team1, 1, 3);
			$winner2 = (int) substr($match->team2, 1, 3);

			if ($reverse == true)
			{
				if ($oldbets[$winner1]->local < $oldbets[$winner1]->visit) {
					$local = $oldbets[$winner1]->team1;
				}else if ($oldbets[$winner1]->local > $oldbets[$winner1]->visit) {
					$local = $oldbets[$winner1]->team2;
				}

				if ($oldbets[$winner2]->local < $oldbets[$winner2]->visit) {
					$visit = $oldbets[$winner2]->team1;
				}else if ($oldbets[$winner2]->local > $oldbets[$winner2]->visit) {
					$visit = $oldbets[$winner2]->team2;
				}

				if ($oldbets[$winner2]->local == $oldbets[$winner2]->visit || $oldbets[$winner1]->local == $oldbets[$winner1]->visit)
				{
					if ($oldbets[$winner1]->pLocal < $oldbets[$winner1]->pVisit) {
						$local = $oldbets[$winner1]->team1;
					}else if ($oldbets[$winner1]->pLocal > $oldbets[$winner1]->pVisit) {
						$local = $oldbets[$winner1]->team2;
					}

					if ($oldbets[$winner2]->pLocal < $oldbets[$winner2]->pVisit) {
						$visit = $oldbets[$winner2]->team1;
					}else if ($oldbets[$winner2]->pLocal > $oldbets[$winner2]->pVisit) {
						$visit = $oldbets[$winner2]->team2;
					}
				}
			}
			else
			{
				if ($oldbets[$winner1]->local > $oldbets[$winner1]->visit) {
					$local = $oldbets[$winner1]->team1;
				}else if ($oldbets[$winner1]->local < $oldbets[$winner1]->visit) {
					$local = $oldbets[$winner1]->team2;
				}

				if ($oldbets[$winner2]->local > $oldbets[$winner2]->visit) {
					$visit = $oldbets[$winner2]->team1;
				}else if ($oldbets[$winner2]->local < $oldbets[$winner2]->visit) {
					$visit = $oldbets[$winner2]->team2;
				}

				if ($oldbets[$winner2]->local == $oldbets[$winner2]->visit || $oldbets[$winner1]->local == $oldbets[$winner1]->visit)
				{
					if ($oldbets[$winner1]->pLocal > $oldbets[$winner1]->pVisit) {
						$local = $oldbets[$winner1]->team1;
					}else if ($oldbets[$winner1]->pLocal < $oldbets[$winner1]->pVisit) {
						$local = $oldbets[$winner1]->team2;
					}

					if ($oldbets[$winner2]->pLocal > $oldbets[$winner2]->pVisit) {
						$visit = $oldbets[$winner2]->team1;
					}else if ($oldbets[$winner2]->pLocal < $oldbets[$winner2]->pVisit) {
						$visit = $oldbets[$winner2]->team2;
					}
				}
			}

			if ($oldbets[$match->id]->pLocal == 0 && $oldbets[$match->id]->pVisit == 0)
			{
				$readonly2 = "readonly='readonly'";
			}

		?>
			<tr class="">

				<td align="" data-title="partido">
					<?php echo $this->teams[$local]->name;?>&nbsp;<img src="<?php echo $this->teams[$local]->flag; ?>">&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;<img src="<?php echo $this->teams[$visit]->flag; ?>">&nbsp;<?php echo $this->teams[$visit]->name;?>
				</td>
				<td align="" data-title="resultado">
					<input type="text" data-mid="<?php echo $match->id; ?>" id="l-<?php echo $match->id; ?>" name="l-<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->local; ?>" size="1" class="input_result" <?php echo $readonly; ?>>&nbsp;-&nbsp;
					<input type="text" data-mid="<?php echo $match->id; ?>" id="v-<?php echo $match->id; ?>" name="v-<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->visit; ?>" size="1" class="input_result" <?php echo $readonly; ?>>
				</td>
				<td align="" data-title="penales">
					<input type="text" id="pLocal-<?php echo $match->id; ?>" name="pLocal-<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->pLocal; ?>" size="1" <?php echo $readonly2; ?>>&nbsp;-&nbsp;
					<input type="text" id="pVisit-<?php echo $match->id; ?>" name="pVisit-<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->pVisit; ?>" size="1" <?php echo $readonly2; ?>>
				</td>
				<td data-title="fecha">
					<?php echo $date->format($format); ?>
				</td>
				<td data-title="lugar">
					<?php echo $match->pname;?>
				</td>
				<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $this->teams[$local]->id; ?>" />
				<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $this->teams[$visit]->id; ?>" />
			</tr>
<?php
				unset($pos1);unset($pos2);
				unset($group1);unset($group2);
		}
	}
}
