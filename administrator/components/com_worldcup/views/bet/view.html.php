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
defined('_JEXEC') or die('Restricted access');

JLoader::register('WorldcupBets', JPATH_COMPONENT_ADMINISTRATOR.'/includes/bets.php');
JLoader::register('WorldcupMatches', JPATH_COMPONENT_ADMINISTRATOR.'/includes/matches.php');
JLoader::register('WorldcupTeams', JPATH_COMPONENT_ADMINISTRATOR.'/includes/teams.php');
JLoader::register('WorldcupTournaments', JPATH_COMPONENT_ADMINISTRATOR.'/includes/tournaments.php');

/**
 * WorldcupViewBet View
 */
class WorldcupViewBet extends JViewLegacy
{
	/**
	* display method of Exercise view
	* @return void
	*/
	public function display($tpl = null) 
	{
		// Loader
		JLoader::import('helpers.worldcup', JPATH_COMPONENT_ADMINISTRATOR);

		// Get the user id and tournament id
		$user_id = JFactory::getApplication()->input->get('id');
		$tid = JFactory::getApplication()->input->get('tid');

		$betsObj = new WorldcupBets();
		$matchesObj = new WorldcupMatches();
		$teamsObj = new WorldcupTeams();
		$tournamentObj = new WorldcupTournaments();

		// get the Data
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
	    JError::raiseError(500, implode('<br />', $errors));
	    return false;
		}

		// Get groups
		$this->groups = $tournamentObj->getGroupsList($tid);

		// Get the matches
		$this->matches = array();

		for($i=1;$i<=count($this->groups);$i++) {
			$this->matches[$i] = $matchesObj->getMatchesList($tid, false, $this->groups[$i]->id);
		}

		$this->matches[] = $matchesObj->getMatchesList($tid, 1);
		$this->matches[] = $matchesObj->getMatchesList($tid, 2);
		$this->matches[] = $matchesObj->getMatchesList($tid, 3);
		$this->matches[] = $matchesObj->getMatchesList($tid, 4);
		$this->matches[] = $matchesObj->getMatchesList($tid, 5);

		// Get bets
		$this->bets = $betsObj->getBetsList($tid, $user_id);
		// Get teams
		$this->teams = $teamsObj->getTeamsList($tid);		
		// Get the second phase table of this user
		$this->data = $tournamentObj->getGroupsTable($tid, $user_id);
		// Get Phases
		$this->phases =	WorldcupHelper::getPhases(count($this->teams));

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);

		$isNew = ($input->get('id') == 0);
		JToolBarHelper::title($isNew ? JText::_('JTOOLBAR_NEW')
				                         : JText::_('JTOOLBAR_EDIT'));
		JToolBarHelper::cancel('bet.cancel', $isNew ? 'JTOOLBAR_CANCEL'
				                                               : 'JTOOLBAR_CLOSE');
	}

	/**
	* recursiveArraySearch
	*/
  public function recursiveArraySearch($haystack, $needle, $index = null) {
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

}
