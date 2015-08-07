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
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class worldcupViewScore extends JView {

	function display($tpl = null)	{
		global $mainframe;

    include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'worldcup_config.php');

		JToolBarHelper::title(  JText::_( 'Score' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();
		$my =& JFactory::getUser();

		## Getting the results
		$query = "SELECT r.*
              FROM #__worldcup_results AS r
		          ORDER BY r.mid ASC";
		$db->setQuery($query);
		$results = $db->loadObjectList();

		## Getting the users
		$query = "SELECT u.id, u.name, COUNT(b.id) AS count
			FROM #__users AS u
			LEFT JOIN #__worldcup_bets AS b ON b.uid = u.id
      WHERE u.usertype != 'Super Administrator'
      GROUP BY u.id";
		$db->setQuery($query);
		$users = $db->loadObjectList();

    ## Truncate score table
	  $query = "TRUNCATE TABLE `#__worldcup_score`";
	  $db->setQuery($query);
	  $db->query();

    $scoreArr = array();

    for($i=0;$i<count($users);$i++) {
      $user = &$users[$i];

      $scoreArr[$i] = array();
      $scoreArr[$i]['uid'] = $user->id;
      $scoreArr[$i]['count'] = $user->count;
      $scoreArr[$i]['points'] = 0;

      for($y=0;$y<count($results);$y++) {
        $result = &$results[$y];

		    ## Getting the bets
		    $query = "SELECT b.*
        FROM #__worldcup_bets AS b
        WHERE b.mid = {$result->mid}
        AND b.uid = {$user->id}
        ORDER BY b.uid, b.mid ASC";
		    $db->setQuery($query);
		    $bet = $db->loadObject();

        //echo "<br>{$user->id}:=======<br>";
        //print_r($bet);
        //echo "<br>=======<br>";
        //print_r($result);

        $game['result'] = "result";
        $game['bet'] = "bet";

        ## Deuce
        if($result->local == $result->visit) {
          $game['result'] = "deuce";
        }
        if($bet->local == $bet->visit) {
          $game['bet'] = "deuce";
        }

        ## Simple
        if($result->local > $result->visit) {
          $game['result'] = "local";
        }else if($result->local < $result->visit) {
          $game['result'] = "visit";
        }

        if($bet->local > $bet->visit) {
          $game['bet'] = "local";
        }else if($bet->local < $bet->visit) {
          $game['bet'] = "visit";
        }

        //echo "<br>{$game['bet']}  +   {$game['result']} <br> ";
        //echo "<br>{$scoreArr[$i]['points']}  +   {$worldcupConfig['exactmatch']} == ";
        ## Equal
        if( ($game['bet'] == "deuce" && $game['result'] == "deuce") && ($bet->local != $result->local) ) {
          $scoreArr[$i]['points'] += $worldcupConfig['equalmatch'];
        } else if($bet->local == $result->local && $bet->visit == $result->visit) {
          $scoreArr[$i]['points'] += $worldcupConfig['exactmatch'];
        }else if($game['bet'] == $game['result']) {
          $scoreArr[$i]['points'] += $worldcupConfig['simplematch'];
        }

        //echo "<br><br>{$game['bet']} == {$game['result']}<br><br>";
        //print_r($scoreArr[$i]);
        //print_r($scoreArr[$i]['points']);
        //echo "<br><br>";

      }

      ## SQL Score
			$sqlscore =& JTable::getInstance('WorldCupScore', 'Table');

			if (!$sqlscore->bind( $scoreArr[$i] )) {
			  return JError::raiseWarning( 500, $sqlscore->getError() );
			}
			if (!$sqlscore->store()) {
			  return JError::raiseError(500, $sqlscore->getError() );
			}
      unset($scoreArr[$i]);
			unset($sqlscore);

    }

		## Getting the score
		$query = "SELECT s.*, u.name
    FROM #__worldcup_score AS s
    LEFT JOIN #__users AS u ON u.id = s.uid
    ORDER BY s.points DESC";
		$db->setQuery($query);
		$score = $db->loadObjectList();

    //echo "<br>=======<br>";
    //print_r($scoreArr);
    //echo "<br>=======<br>";
    //sort($score);
    //print_r($score);
    //echo "<br>=======<br>";

		## Getting the results
		$query = "SELECT u.id, u.name, u.username
              FROM #__users AS u
		          ORDER BY u.id ASC";
		$db->setQuery($query);
		$usersnames = $db->loadObjectList('id');

		//$this->assignRef('users', $users);
		$this->assignRef('usersnames', $usersnames);
		$this->assignRef('score', $score);
		//$this->assignRef('groups', $groups);

		parent::display($tpl);
	}

}
?>

