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

jimport('joomla.filesystem.file');
include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'worldcup_config.php');

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

$my =& JFactory::getUser();

$groups = $this->groups;
$teams = $this->teams;
$matches = $this->matches;
$data = $this->data;
$bets = $this->bets;
$results = $this->results;
//print_r($bets);
//echo "<p>";
//print_r($results);
//print_r($teams);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<script type="text/javascript">
/* <![CDATA[ */
window.addEvent( 'domready', function() {

  $$('.save').addEvent( 'click', function(event) {

		var id = this.title;
		//alert(this.title);

    var local = document.getElementById('l'+id);
    var visit = document.getElementById('v'+id);

    if (local.disabled == 1 || visit.disabled == 1) {
      return false;
    }

    if (local.value == "" || visit.value == "") {
      alert('<?php echo JText::_( "Please fill results" ); ?>');
      return false;
    }

    var a = new Ajax( '<?php echo $url; ?>?id='+id+'&l='+local.value+'&v='+visit.value, {
      method: 'get',
      onComplete: function( response ) {
				//alert(response);
        local.disabled = 1;
        visit.disabled = 1;
        alert('<?php echo JText::_( "Result saved!" ); ?>');
      }
    }).request();
  });

  $$('.delete').addEvent( 'click', function(event) {

		var id = this.title;
		//alert(this.title);

    var local = document.getElementById('l'+id);
    var visit = document.getElementById('v'+id);

    if (local.disabled == 0 || visit.disabled == 0 ) {
      return false;
    }

    var a = new Ajax( '<?php echo $urld; ?>?id='+id+'&l='+local.value+'&v='+visit.value, {
      method: 'get',
      onComplete: function( response ) {
				//alert(response);
        local.disabled = 0;
        visit.disabled = 0;
        alert('<?php echo JText::_( "Result deleted!" ); ?>');
      }
    }).request();
  });



});
/* ]]> */
</script>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<form action="index.php?option=com_worldcup" method="post" name="adminForm">
<?php


?>

<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[0]; ?></h3>
	</td>
</tr>
</table>

<table class="adminlist">
<thead>
	<tr>
		<th width="10%" nowrap="nowrap">
			<?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?>
		</th>
		<th width="15%" nowrap="nowrap">
			<?php echo JText::_( 'Place' ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Tipp (Ergebnis n. 90Min)
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Punkte
		</th>
		<th width="10%" nowrap="nowrap">
			Gesamt
		</th>
	</tr>
</thead>
<tbody>
<?php
	//print_r($bets);

      $scoreArr = array();
      $scoreArr[$i] = array();
      $scoreArr[$i]['uid'] = $userid;
      $scoreArr[$i]['count'] = $user->count;
      $scoreArr[$i]['points'] = 0;
	for ($i=0, $n=count( $matches[0] ); $i < $n; $i++) {
		$match = &$matches[0][$i];

		$date =& JFactory::getDate($match->date);
		$format = '%b/%d %H:%M';

    $result = &$results[$match->id];
    //print_r($result);
    $bet = &$bets[$match->id];
    //print_r($bet);
    if ($result['mid'] != "") {
      $res = explode("-", $result['goals']);
      $local = $result['local'];
      $visit = $result['visit'];
      $betlocal = $bet['local'];
      $betvisit = $bet['visit'];
      //echo "bET_".$bet->local;
      //echo "<br>VISITE_ ".$visit;
      //echo "<br>BETVISITE_ ".$betvisit;
      //$disabled = "disabled";


        ## Deuce
        if($local == $visit) {
          $game['result'] = "deuce";
        }
        if(($betlocal == $betvisit) ) {
          $game['bet'] = "deuce";
        }
        ## MISSED TIPP
        //added by Piotr Mackowiak
        if (empty($betlocal)){
          $game['bet'] = "missed";
        }
        ## Simple
        if($local > $visit) {
          $game['result'] = "local";
        }else if($local < $visit) {
          $game['result'] = "visit";
        }
        if($betlocal > $betvisit) {
          $game['bet'] = "local";
        }else if($betlocal < $betvisit) {
          $game['bet'] = "visit";
        }
        //Punkte Pro spiel
        $pfad = 0;

        if( ($game['bet'] == "deuce" && $game['result'] == "deuce")  && ($betlocal != $local) ) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['equalmatch'];
          $pfad = 2;
        } else if($betlocal == $local && $betvisit == $visit) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['exactmatch'];
          $pfad = 3;
        }else if($game['bet'] == $game['result'] && (strlen($betlocal) > 0) && (strlen($local) > 0))  {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['simplematch'];
          $pfad = 2;
        }

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

			   <strong>
				<?php echo $betlocal;?>
        <small>-</small>
				<?php echo $betvisit;?>&nbsp;
				</strong>
        (&nbsp;<?php echo $local;?>
        <small>-</small>
				<?php echo $visit;?>&nbsp;)
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $match->team2; ?>.png">
				<?php echo $this->teams[$match->team2]['name'];?>
			</td>
      <td><center>+<?php echo $pfad;?></center></td>
      <td></td>
		</tr>
<?php
    unset($disabled);
    unset($local);
    unset($visit);
    unset($pfad);
	}
?>
</tbody>
</table>


<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[1]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<th width="10%" nowrap="nowrap">
			<?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?>
		</th>
		<th width="15%" nowrap="nowrap">
			<?php echo JText::_( 'Place' ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Tipp (Ergebnis n. 90Min)
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Punkte
		</th>
		<th width="10%" nowrap="nowrap">
			Gesamt
		</th>

	</tr>
</thead>
<tbody>
<?php
		//matches = $this->matches[1];
		//print_r($data);

		for ($i=0, $n=count( $matches[1] ); $i < $n; $i++) {
			$match = &$matches[1][$i];
      // Match = stdClass Object ( [id] => 49 [date] => 2010-06-26 11:00:00 [group] => 0 [place] => 4 [team1] => 1A [team2] => 2B [phase] => 1 [pname] => Puerto Elizabeth )
      //print_r($match);
			$date =& JFactory::getDate($match->date);
			$format = '%b/%d %H:%M';

			$pos1 = substr($match->team1, 0, 1);
			$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );
      //print_r($groups); // Gruppen ID
      //echo "GROUP1: ".$group1;
			$pos2 = substr($match->team2, 0, 1);
			$group2 = recursiveArraySearch($groups, substr($match->team2, 1, 2) );
      //echo $pos2;
			//print_r($group1);
			//echo "<br><br>";

		  $result = &$results[$match->id];
      $bet = &$bets[$match->id];
      //print_r($result);
      //echo "<br><br>";

		  if ($bet['mid'] != "") {
		    $res = explode("-", $result['goals']);
		    $local = $result['local'];
		    $visit = $result['visit'];
		    $finallocal = $result['finallocal'];
		    $finalvisit = $result['finalvisit'];
		    $betlocal = $bet['local'];
        $betvisit = $bet['visit'];
		    $disabled = "disabled";
		    $draw = "";
		    if (($finallocal != 0) && ($finalvisit != 0)){
           $draw = " (Endstand:".$finallocal."-".$finalvisit."";
        }
        //echo "DRAW:".$draw;

		    ## Deuce
        if($local == $visit) {
          $game['result'] = "deuce";
        }
        if(($betlocal == $betvisit) ) {
          $game['bet'] = "deuce";
        }
        ## MISSED TIPP added by Piotr Mackowiak
        if (empty($betlocal)){
          $game['bet'] = "missed";
        }
        ## Simple
        if($local > $visit) {
          $game['result'] = "local";
        }else if($local < $visit) {
          $game['result'] = "visit";
        }
        if($betlocal > $betvisit) {
          $game['bet'] = "local";
        }else if($betlocal < $betvisit) {
          $game['bet'] = "visit";
        }
        //Punkte Pro spiel
        $pfad = 0;
        if( ($game['bet'] == "deuce" && $game['result'] == "deuce")  && ($betlocal != $local) ) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['equalmatch'];
          $pfad = 2;
        } else if($betlocal == $local && $betvisit == $visit) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['exactmatch'];
          $pfad = 3;
        }else if($game['bet'] == $game['result'] && (strlen($betlocal) > 0) )  {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['simplematch'];
          $pfad = 2;
        }

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
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
				<?php echo $data[$group1][$pos1-1]['name'];?>     <!-- Name vom Team-->
			</td>
			<td align="center">
			   <strong>
				<?php echo $betlocal;?>
        <small>-</small>
				<?php echo $betvisit;?>&nbsp;
				</strong>
        (&nbsp;<?php echo $local;?>
        <small>-</small>
				<?php echo $visit.")".$draw;?>&nbsp;)

			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
				<?php echo $data[$group2][$pos2-1]['name'];?>
			</td>
      <td><center>+<?php echo $pfad;?></center></td>
      <td></td>
		</tr>
<?php
			unset($pos1);unset($pos2);
			unset($group1);unset($group2);
		  unset($disabled);
		  unset($local);
		  unset($visit);
		}
?>
</tbody>
</table>


<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[2]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<th width="10%" nowrap="nowrap">
			<?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?>
		</th>
		<th width="15%" nowrap="nowrap">
			<?php echo JText::_( 'Place' ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Tipp (Ergebnis n. 90Min)
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			Punkte
		</th>
		<th width="10%" nowrap="nowrap">
			Gesamt
		</th>

	</tr>
</thead>
<tbody>
<?php
		//$matches = $this->matches[2];
		//print_r($matches[2]);

		for ($i=0, $n=count( $matches[2] ); $i < $n; $i++) {
			$match = &$matches[2][$i];

			$date =& JFactory::getDate($match->date);
			$format = '%b/%d %H:%M';

			$pos1 = substr($match->team1, 0, 1);
			$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );
      //print_r($groups);
			$pos2 = substr($match->team2, 0, 1);
			//$group2 =recursiveArraySearch($groups, substr($match->team2, 1, 2) );

		  $result = &$results[$match->id];
      $bet = &$bets[$match->id];
//print_r($result);
//echo "<br><br>";

		  if ($bet['mid'] != "") {
		    $res = explode("-", $result['goals']);
		    $local = $result['local'];
		    $visit = $result['visit'];
		    $finallocal = $result['finallocal'];
		    $finalvisit = $result['finalvisit'];
		    $betlocal = $bet['local'];
        $betvisit = $bet['visit'];
		    $disabled = "disabled";
		    $draw = "";
		    if (($finallocal != 0) && ($finalvisit != 0)){
           $draw = " (Endstand:".$finallocal."-".$finalvisit."";
        }
        //echo "DRAW:".$draw;

		            ## Deuce
        if($local == $visit) {
          $game['result'] = "deuce";
        }
        if(($betlocal == $betvisit) ) {
          $game['bet'] = "deuce";
        }
        ## MISSED TIPP
        //added by Piotr Mackowiak
        if (empty($betlocal)){
          $game['bet'] = "missed";
        }
        ## Simple
        if($local > $visit) {
          $game['result'] = "local";
        }else if($local < $visit) {
          $game['result'] = "visit";
        }
        if($betlocal > $betvisit) {
          $game['bet'] = "local";
        }else if($betlocal < $betvisit) {
          $game['bet'] = "visit";
        }
        //Punkte Pro spiel
        $pfad = 0;

        if( ($game['bet'] == "deuce" && $game['result'] == "deuce")  && ($betlocal != $local) ) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['equalmatch'];
          $pfad = 2;
        } else if($betlocal == $local && $betvisit == $visit) {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['exactmatch'];
          $pfad = 3;
        }else if($game['bet'] == $game['result'] && (strlen($betlocal) > 0) )  {
          $scoreArr[$i]['points'] = $scoreArr[$i]['points'] + $worldcupConfig['simplematch'];
          $pfad = 2;
        }
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
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
				<?php echo $data[$group1][$pos1-1]['name'];?>
			</td>
			<td align="center">
			   <strong>
				<?php echo $betlocal;?>
        <small>-</small>
				<?php echo $betvisit;?>&nbsp;
				</strong>
        (&nbsp;<?php echo $local;?>
        <small>-</small>
				<?php echo $visit.")".$draw;?>&nbsp;)
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
				<?php echo $data[$group2][$pos2-1]['name'];?>
			</td>
      <td><center>+<?php echo $pfad;?></center></td>
      <td></td>

		</tr>
<?php
			unset($pos1);unset($pos2);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>














<form action="index.php?option=com_worldcup" method="post" name="adminForm">
<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="bets" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
