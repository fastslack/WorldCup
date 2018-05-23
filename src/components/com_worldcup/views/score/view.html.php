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

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewScore extends WorldCupView {

	function display($tpl = null)	{
		global $mainframe;

    //include(JPATH_ADMINISTRATOR.DS.'/components'.DS.'com_worldcup'.DS.'worldcup_config.php');
		//include(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php');

		$params = JFactory::getApplication()->getParams();

		$db =& JFactory::getDBO();
		$my =& JFactory::getUser();

		##
		## Getting the results
		##
		$query = "SELECT r.*
              FROM #__worldcup_results AS r
		          ORDER BY r.mid ASC";
		$db->setQuery($query);
		$results = $db->loadObjectList();

		## TODOOOO
		## Getting clasifieds data
		##
		//$data = WorldCupHelper::_getTableData($groups);

		##
		## Getting the users
		##
		$query = "SELECT u.id, u.name, COUNT(b.id) AS count
			FROM #__users AS u
			LEFT JOIN #__worldcup_bets AS b ON b.uid = u.id
      WHERE u.username != 'admin'
      GROUP BY u.id";
		$db->setQuery($query);
		$users = $db->loadObjectList();

		##
    ## Truncate score table
		##
	  $query = "TRUNCATE TABLE `#__worldcup_score`";
	  $db->setQuery($query);
	  $db->query();

		// Get the points parameters
		$equalmatch = $params->get('equalmatch');
		$exactmatch = $params->get('exactmatch');
		$simplematch = $params->get('simplematch');

		##
		##
		##
    $scoreArr = array();

    for($i=0;$i<count($users);$i++) {
      $user = &$users[$i];

      $scoreArr[$i] = array();
      $scoreArr[$i]['uid'] = $user->id;
      $scoreArr[$i]['count'] = $user->count;
      $scoreArr[$i]['points'] = 0;

	    ## Getting the bets
	    $query = "SELECT b.*, m.phase
      FROM #__worldcup_bets AS b
			LEFT JOIN #__worldcup_matches AS m ON m.id = b.mid
      WHERE b.uid = {$user->id}
      ORDER BY b.mid ASC";
	    $db->setQuery($query);
	    $bets = $db->loadObjectlist('mid');

      for($y=0;$y<count($results);$y++) {
        $result = &$results[$y];
				$bet = isset($bets[$result->mid]) ? $bets[$result->mid] : '';

        $game['result'] = "result";
        $game['bet'] = "bet";

				##
				## Results check
				## 		
	      if($result->local == $result->visit) {
	        $game['result'] = "deuce";
	      }
			
	      ## Simple
	      if($result->local > $result->visit) {
	        $game['result'] = "local";
	      }else if($result->local < $result->visit) {
	        $game['result'] = "visit";
	      }

				##
				## Who wins on bets
				## 	
				if (is_object($bet)) {
				  if($bet->local > $bet->visit) {
				    $game['bet'] = "local";
				  }else if($bet->local < $bet->visit) {
				    $game['bet'] = "visit";
				  }
				}

				##
				## Clasification count
				## 
				if ($result->mid <= 48) {

					##
					## Bets check
					## 			
					if (is_object($bet)) {
					  if($bet->local == $bet->visit) {
					    $game['bet'] = "deuce";
					  }	
					}

		      ## Adding score
		      if( ($game['bet'] == "deuce" && $game['result'] == "deuce") && ($bet->local != $result->local) ) {
		        $scoreArr[$i]['points'] += $equalmatch;
		      } else if(isset($bet->local) && $bet->local == $result->local && $bet->visit == $result->visit) {
		        $scoreArr[$i]['points'] += $exactmatch;
		      }else if($game['bet'] == $game['result']) {
		        $scoreArr[$i]['points'] += $simplematch;
		      }

				##
				## 8vos count
				## 
				}else if ($result->mid >= 49 && $result->mid <= 56){

					## 
					## Get team of result
					##
					if ($game['result'] == "local"){
						$result_winner = $result->team1;
					}elseif ($game['result'] == "visit"){
						$result_winner = $result->team2;
					}

					##
					## 
					##
					$query = "SELECT b.* FROM jos_worldcup_bets AS b 
							WHERE (b.mid > 48 AND b.mid <= 57 AND b.uid = {$user->id} 
									AND b.team1 = {$result_winner} AND local > visit) 
							OR
							(b.mid > 48 AND b.mid <= 57 AND b.uid = {$user->id} 
									AND b.team2 = {$result_winner} AND local < visit)
				    	ORDER BY b.mid ASC LIMIT 1";
					$db->setQuery($query);
					$bets8vo = $db->loadObject();
					//echo $db->getErrorMsg ();

					##
					## Who wins on bets
					## 	
					if (is_object($bets8vo)) {
						if($bets8vo->local > $bets8vo->visit) {
						  $game['bet'] = "local";
						}else if($bets8vo->local < $bets8vo->visit) {
						  $game['bet'] = "visit";
						}
					}

					if($user->id == 64) {
						//echo "<br>------------<br><b>{$result->mid}</b><br>";
						//echo "RESULTADO REAL=> {$result->local} - {$result->visit}<br>";
						//echo "APUESTA=> {$bets8vo->local} - {$bets8vo->visit}<br>";

						//echo "<br>".$query."<br>";
						//echo $scoreArr[$i]['points']."<br>";				
						//print_r($result_winner);echo "<br>";
						//print_r($result);echo "<br>";
						//print_r($bets8vo);
						//echo "<b>{$bet->mid}</b> => {$game['result']} == ";
						//echo "<b>{$bet->mid}</b> => {$bet->local} - {$bet->visit} == ";
						//print_r($real_result);
						//print_r($result8vo);
						//echo "<br>";print_r($game);
						//echo "<br>";
						//echo $result8vo->$game['result'] ." - ". $bet->$game['bet'];
						//echo "<br>";	
					}


					##
					if($result->team1 == $bets8vo->team1 || $result->team2 == $bets8vo->team2) {

						if($result->local == $bets8vo->local && $result->visit == $bets8vo->visit) {
							//echo "exact1<br>";
							$scoreArr[$i]['points'] += $exactmatch;
						}else if($result->local > $result->visit && $bets8vo->local > $bets8vo->visit) {
							//echo "simple2<br>";
							$scoreArr[$i]['points'] += $simplematch;
						}

					}else if($result->team1 == $bets8vo->team2 || $result->team2 == $bets8vo->team1) {
						if($result->local == $bets8vo->visit && $result->visit == $bets8vo->local) {
							//echo "exact4<br>";
							$scoreArr[$i]['points'] += $exactmatch;
						}else	if($result->local > $result->visit && $bets8vo->local < $bets8vo->visit) {
							//echo "simple5<br>";
							$scoreArr[$i]['points'] += $simplematch;
						}
					}



				}

      }

			##
      ## Insert Score to database
			##
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

		##
		## Getting the score
		##
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

		##
		## Getting the results
		##
		$query = "SELECT u.id, u.name, u.username
              FROM #__users AS u
		          ORDER BY u.id ASC";
		$db->setQuery($query);
		$usersnames = $db->loadObjectList('id');

		//$this->assignRef('bets', $bets);
		$this->assignRef('usersnames', $usersnames);
		$this->assignRef('score', $score);
		//$this->assignRef('groups', $groups);

		parent::display($tpl);
	}

}
