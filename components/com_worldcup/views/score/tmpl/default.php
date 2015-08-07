<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

$my =& JFactory::getUser();

$score = $this->score;
$usersnames = $this->usersnames;
//$matches = $this->matches;
//print_r($usersnames);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<form action="index.php?option=com_worldcup&task=save" method="post" name="adminForm" onSubmit="submitbutton(); return false;">

<div class="box">
  <div class="tab-header">
		<i class="icon-th-list"></i>
		 <?php echo JText::_( "Score" ); ?>
	</div>
  <div class="padded">

		<table width="100%">
		<thead>
			<tr>
				<td width="100"><?php echo JText::_( "User" ); ?></td>
				<td width="100"><?php echo JText::_( "Points" ); ?></td>
			</tr>
		</thead>
		<?php
			for ($i=0;$i<count($score);$i++){
				if($score[$i]->count == 64) {
		?>
		<tbody>
		<tr class="odd">
			<td><a href="<?php echo JRoute::_( 'index.php?option=com_worldcup&view=details&id='.$usersnames[$score[$i]->uid]->id ); ?>"><?php echo $usersnames[$score[$i]->uid]->name; ?></a></td>
			<td><?php echo $score[$i]->points; ?></td>
		<?php
				}
			}
		?>

		</tbody>
		</table>
	</div>
</div>
