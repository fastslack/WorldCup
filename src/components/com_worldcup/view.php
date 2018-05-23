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
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

JLoader::register('WorldcupBets', JPATH_COMPONENT_ADMINISTRATOR.'/includes/bets.php');
JLoader::register('WorldcupMatches', JPATH_COMPONENT_ADMINISTRATOR.'/includes/matches.php');
JLoader::register('WorldcupTeams', JPATH_COMPONENT_ADMINISTRATOR.'/includes/teams.php');
JLoader::register('WorldcupTournaments', JPATH_COMPONENT_ADMINISTRATOR.'/includes/tournaments.php');

class WorldCupView extends JViewLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Create the db instance
		$this->_db =& JFactory::getDBO();
		// Create the JUser instance
		$this->_my =& JFactory::getUser();
		// Declare WorldCup objects
		$this->_bets = new WorldcupBets();
		$this->_matches = new WorldcupMatches();
		$this->_teams = new WorldcupTeams();
		$this->_tournaments = new WorldcupTournaments();
	}

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

}
