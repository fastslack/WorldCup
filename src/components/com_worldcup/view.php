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
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

use Joomla\CMS\Factory;
use Worldcup\Bets;
use Worldcup\Competitions;
use Worldcup\Matches;
use Worldcup\Results;
use Worldcup\Score;
use Worldcup\Teams;
use Worldcup\Tournaments;

class WorldCupView extends JViewLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Create the db instance
		$this->_db = Factory::getDBO();

		// Create the JUser instance
		$this->_my = Factory::getUser();

		// Declare WorldCup objects
		$this->_bets = new Bets();
		$this->_competitions = new Competitions();
		$this->_matches = new Matches();
		$this->_teams = new Teams();
		$this->_score = new Score();
		$this->_results = new Results();
		$this->_tournaments = new Tournaments();
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
