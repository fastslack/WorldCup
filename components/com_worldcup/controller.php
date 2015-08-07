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
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * WorldCup Controller
 */
class WorldCupController extends JControllerLegacy {

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {
		parent::__construct();

    //require_once(JPATH_ADMINISTRATOR.'/components/com_worldcup/worldcup_config.php');
		require_once(JPATH_ADMINISTRATOR.'/components/com_worldcup/tables/bets.php');
    require_once(JPATH_ADMINISTRATOR.'/components/com_worldcup/tables/score.php');
	}

	function display() {

		JRequest::setVar( 'view', 'subscribe' );

		parent::display();
	}

	function save($phase) {

		$my =& JFactory::getUser();

		if($my->id == 0) {
			$msg = JText::_( 'You need to login.' );
			$link = 'index.php?option=com_user&view=login';
			$this->setRedirect($link, $msg);
		}

    //include(JPATH_ADMINISTRATOR.'/components/com_worldcup/worldcup_config.php');

		$db =& JFactory::getDBO();
		$post = JRequest::get( 'post' );
		print_r($post);

		$query = "SELECT id
			FROM #__worldcup_matches
			WHERE phase = '{$phase}'";
		$db->setQuery($query);
		$matches = $db->loadObjectList();

		//print_r($matches);

		for($i=0;$i<count($matches);$i++) {

			$new = array();

			# Check if data exists
			$query = "SELECT id, local, visit
				FROM #__worldcup_bets
				WHERE uid = {$my->id} AND mid = {$matches[$i]->id}";
			$db->setQuery($query);
			$exist = $db->loadObject();

			$new['uid'] = $my->id;
			$new['mid'] = $matches[$i]->id;

			if ($exist->id != "" ) {
				$new['id'] = $exist->id;

				if($post['l'.$matches[$i]->id] != $exist->local || $post['v'.$matches[$i]->id] != $exist->visit) {
				  $new['local'] = $post['l'.$matches[$i]->id];
				  $new['visit'] = $post['v'.$matches[$i]->id];
				}else if($exist->local == "" || $exist->visit == "") {
				  $new['local'] = $post['l'.$matches[$i]->id];
				  $new['visit'] = $post['v'.$matches[$i]->id];
				}else{
					$new['local'] = $exist->local;
					$new['visit'] = $exist->visit;
				}
			}else{
		    $new['local'] = $post['l'.$matches[$i]->id];
		    $new['visit'] = $post['v'.$matches[$i]->id];
			}

			if ($phase > 0) {
				$new['team1'] = $post['team1-'.$matches[$i]->id];
				$new['team2'] = $post['team2-'.$matches[$i]->id];
			}

			$bets =& JTable::getInstance('WorldCupBets', 'Table');

			if (!$bets->bind( $new )) {
			  return JError::raiseWarning( 500, $bets->getError() );
			}

			if (!$bets->store()) {
			  JError::raiseError(500, $bets->getError() );
			}

			unset($bets);
		}

	}

	function bets() {

		$my =& JFactory::getUser();
		if(!$my->id) {
			$msg = JText::_( 'You need to login.' );
			$link = 'index.php?option=com_user&view=login';
			$this->setRedirect($link, $msg);
		}

		$step = JRequest::getVar('step');

		if($step == 2) {
			$this->save(0);
			JRequest::setVar( 'layout', 'step2'  );
		}else if ($step == 3){
			$this->save(1);
			JRequest::setVar( 'layout', 'step3'  );
		}else if ($step == 4){
			$this->save(2);
			JRequest::setVar( 'layout', 'step4'  );
		}else if ($step == 5){
			$this->save(3);
			JRequest::setVar( 'layout', 'step5'  );
		}else if ($step == 6){
			$this->save(4);
			JRequest::setVar( 'layout', 'step6'  );
		}else if ($step == 7){
			$this->save(5);
			JRequest::setVar( 'layout', 'default'  );
		}else {
			JRequest::setVar( 'layout', 'default'  );
		}

		JRequest::setVar( 'view', 'bets' );

		parent::display();
	}

	function score() {

		JRequest::setVar( 'view', 'score' );

		parent::display();
	}

	function details() {

		JRequest::setVar( 'view', 'details' ); 
		JRequest::setVar( 'layout', 'detail' );

		parent::display();
	}

  function detailscore() { 

    JRequest::setVar( 'view', 'detailscore' ); 
    JRequest::setVar( 'layout', 'detail' ); 

    parent::display(); 
  }

	function results() {

		JRequest::setVar( 'view', 'results' );

		parent::display();
	}
}
