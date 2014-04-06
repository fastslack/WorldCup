<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access');

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

$teams = $this->teams;
$matches = $this->matches;
$results = $this->results;
$groups = $this->groups;
$data = $this->data;

$url = JURI::root()."administrator/components/com_worldcup/ajax/save.php";
$urld = JURI::root()."administrator/components/com_worldcup/ajax/delete.php";

?>
<script type="text/javascript">
/* <![CDATA[ */
window.addEvent( 'domready', function() {

  $$('.save').addEvent( 'click', function(event) {

		var id = this.title;
		//alert(this.title);

    var local = document.getElementById('l'+id);
    var visit = document.getElementById('v'+id);
    var t1 = document.getElementById('t1-'+id);
    var t2 = document.getElementById('t2-'+id);

    if (local.disabled == 1 || visit.disabled == 1) {
      return false;
    }

    if (local.value == "" || visit.value == "") {
      alert('<?php echo JText::_( "Please fill results" ); ?>');
      return false;
    }

    var a = new Ajax( '<?php echo $url; ?>?id='+id+'&l='+local.value+'&v='+visit.value+'&t1='+t1.value+'&t2='+t2.value, {
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
<table>
<tr>
<!--
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
	</td>
-->
	<td align="left" width="100%">
		<?php echo JText::_( 'Tournament' ); ?>:&nbsp;<?php echo $this->lists['tournaments']; ?>
		<button onclick="this.form.submit();"><?php echo JText::_( 'Change' ); ?></button>
	</td>
	<td nowrap="nowrap">
	</td>
</tr>
</table>

<?php
	echo $this->getPhaseHTML(0);
?>

<!--
##
##  8vos
##
-->
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
		//matches = $this->matches[1];
		//print_r($data);

		for ($i=0, $n=count( $matches[1] ); $i < $n; $i++) {
			$match = &$matches[1][$i];

			$date =& JFactory::getDate($match->date);          
			$format = '%b/%d %H:%M';

			$pos1 = substr($match->team1, 0, 1);
			$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );

			$pos2 = substr($match->team2, 0, 1);
			$group2 = recursiveArraySearch($groups, substr($match->team2, 1, 2) );

			//print_r($group1);
			//echo "<br><br>";

		  $result = &$results[$match->id];

//print_r($result);
//echo "<br><br>";

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
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
				<?php echo $data[$group1][$pos1-1]['name'];?>
			</td>
			<td align="center">
				<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php echo $local; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $data[$group1][$pos1-1]['id']; ?>" />
        &nbsp;<small>vs</small>&nbsp;
				<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php echo $visit; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $data[$group2][$pos2-1]['id']; ?>" />
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
				<?php echo $data[$group2][$pos2-1]['name'];?>
			</td>
			<td align="center">
				<div class="save" title="<?php echo $match->id; ?>">
        <img src="images/apply_f2.png" /></div>&nbsp;&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png"  /></div>
			</td>
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

<!--
##
##  4tos
##
-->
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
		//$matches = $this->matches[2];
		//print_r($results);

		for ($i=0, $n=count( $matches[2] ); $i < $n; $i++) {
			$match = &$matches[2][$i];

			//print_r($match);
			//echo "==================<br>";

			$date =& JFactory::getDate($match->date);          
			$format = '%b/%d %H:%M';

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($results[$winner1]['local'] > $results[$winner1]['visit']) {
				$local = $results[$winner1]['team1'];
			}else if ($results[$winner1]['local'] < $results[$winner1]['visit']) {
				$local = $results[$winner1]['team2'];
			}

			if ($results[$winner2]['local'] > $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team1'];
			}else if ($results[$winner2]['local'] < $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team2'];
			}
			//print_r($results[$winner1]);
			//echo "<br>";
			//echo "$local - $visit<br>";

?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $date->toFormat($format); ?>
			</td>
			<td>
				<?php echo $match->pname;?>
			</td>
			<td align="right">
				<img src="components/com_worldcup/images/flags/<?php echo $local; ?>.png">
				<?php echo $teams[$local]['name'];?>
			</td>
			<td align="center">
				<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php //echo $local; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $local; ?>" />
        &nbsp;<small>vs</small>&nbsp;
				<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php //echo $visit; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $visit; ?>" />
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $visit; ?>.png">
				<?php echo $teams[$visit]['name'];?>
			</td>
			<td align="center">
				<div class="save" title="<?php echo $match->id; ?>">
        <img src="images/apply_f2.png" /></div>&nbsp;&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png"  /></div>
			</td>
		</tr>
<?php
			unset($local);unset($visit);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>

<!--
##
##  Semi
##
-->
<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[3]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="0" cellspacing="0" border="0">
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
		//$matches = $this->matches[2];
		//print_r($results);

		for ($i=0, $n=count( $matches[3] ); $i < $n; $i++) {
			$match = &$matches[3][$i];

			//print_r($match);
			//echo "==================<br>";

			$date =& JFactory::getDate($match->date);          
			$format = '%b/%d %H:%M';

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($results[$winner1]['local'] > $results[$winner1]['visit']) {
				$local = $results[$winner1]['team1'];
			}else if ($results[$winner1]['local'] < $results[$winner1]['visit']) {
				$local = $results[$winner1]['team2'];
			}

			if ($results[$winner2]['local'] > $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team1'];
			}else if ($results[$winner2]['local'] < $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team2'];
			}
			//print_r($results[$winner1]);
			//echo "<br>";
			//echo "$local - $visit<br>";

?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $date->toFormat($format); ?>
			</td>
			<td>
				<?php echo $match->pname;?>
			</td>
			<td align="right">
				<img src="components/com_worldcup/images/flags/<?php echo $local; ?>.png">
				<?php echo $teams[$local]['name'];?>
			</td>
			<td align="center">
				<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php //echo $local; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $local; ?>" />
        &nbsp;<small>vs</small>&nbsp;
				<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php //echo $visit; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $visit; ?>" />
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $visit; ?>.png">
				<?php echo $teams[$visit]['name'];?>
			</td>
			<td align="center">
				<div class="save" title="<?php echo $match->id; ?>">
        <img src="images/apply_f2.png" /></div>&nbsp;&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png"  /></div>
			</td>
		</tr>
<?php
			unset($local);unset($visit);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>


<!--
##
##  3rd
##
-->
<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[4]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="0" cellspacing="0" border="0">
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
		//$matches = $this->matches[2];
		//print_r($results);

		for ($i=0, $n=count( $matches[4] ); $i < $n; $i++) {
			$match = &$matches[4][$i];

			//print_r($match);
			//echo "==================<br>";

			$date =& JFactory::getDate($match->date);          
			$format = '%b/%d %H:%M';

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($results[$winner1]['local'] < $results[$winner1]['visit']) {
				$local = $results[$winner1]['team1'];
			}else if ($results[$winner1]['local'] > $results[$winner1]['visit']) {
				$local = $results[$winner1]['team2'];
			}

			if ($results[$winner2]['local'] < $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team1'];
			}else if ($results[$winner2]['local'] > $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team2'];
			}
			//print_r($results[$winner1]);
			//echo "<br>";
			//echo "$local - $visit<br>";

?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $date->toFormat($format); ?>
			</td>
			<td>
				<?php echo $match->pname;?>
			</td>
			<td align="right">
				<img src="components/com_worldcup/images/flags/<?php echo $local; ?>.png">
				<?php echo $teams[$local]['name'];?>
			</td>
			<td align="center">
				<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php //echo $local; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $local; ?>" />
        &nbsp;<small>vs</small>&nbsp;
				<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php //echo $visit; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $visit; ?>" />
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $visit; ?>.png">
				<?php echo $teams[$visit]['name'];?>
			</td>
			<td align="center">
				<div class="save" title="<?php echo $match->id; ?>">
        <img src="images/apply_f2.png" /></div>&nbsp;&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png"  /></div>
			</td>
		</tr>
<?php
			unset($local);unset($visit);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>

<!--
##
##  Final
##
-->
<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[5]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="0" cellspacing="0" border="0">
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
		//$matches = $this->matches[2];
		//print_r($results);

		for ($i=0, $n=count( $matches[5] ); $i < $n; $i++) {
			$match = &$matches[5][$i];

			//print_r($match);
			//echo "==================<br>";

			$date =& JFactory::getDate($match->date);          
			$format = '%b/%d %H:%M';

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($results[$winner1]['local'] > $results[$winner1]['visit']) {
				$local = $results[$winner1]['team1'];
			}else if ($results[$winner1]['local'] < $results[$winner1]['visit']) {
				$local = $results[$winner1]['team2'];
			}

			if ($results[$winner2]['local'] > $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team1'];
			}else if ($results[$winner2]['local'] < $results[$winner2]['visit']) {
				$visit = $results[$winner2]['team2'];
			}
			//print_r($results[$winner1]);
			//echo "<br>";
			//echo "$local - $visit<br>";

?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $date->toFormat($format); ?>
			</td>
			<td>
				<?php echo $match->pname;?>
			</td>
			<td align="right">
				<img src="components/com_worldcup/images/flags/<?php echo $local; ?>.png">
				<?php echo $teams[$local]['name'];?>
			</td>
			<td align="center">
				<input size="1" type="text" id="l<?php echo $match->id; ?>" value="<?php //echo $local; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t1-<?php echo $match->id; ?>" value="<?php echo $local; ?>" />
        &nbsp;<small>vs</small>&nbsp;
				<input size="1" type="text" id="v<?php echo $match->id; ?>" value="<?php //echo $visit; ?>" <?php echo $disabled; ?>>
				<input type="hidden" id="t2-<?php echo $match->id; ?>" value="<?php echo $visit; ?>" />
			</td>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $visit; ?>.png">
				<?php echo $teams[$visit]['name'];?>
			</td>
			<td align="center">
				<div class="save" title="<?php echo $match->id; ?>">
        <img src="images/apply_f2.png" /></div>&nbsp;&nbsp;<div class="delete" title="<?php echo $match->id; ?>" ><img src="images/cancel_f2.png"  /></div>
			</td>
		</tr>
<?php
			unset($local);unset($visit);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="results" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

