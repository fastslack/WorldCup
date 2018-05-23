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
$users = $this->users;
//$matches = $this->matches;
//print_r($usersnames);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<form action="index.php?option=com_worldcup&task=save" method="post" name="adminForm" >

<table width="100%">
<thead>
	<tr>
		<td width="100"><?php echo JText::_( 'User' ); ?></td>
		<td width="100"><?php echo JText::_( 'Points' ); ?></td>
	</tr>
</thead>
<?php
	for ($i=0;$i<count($score);$i++){
    if($score[$i]->count == 64) {
?>
<tbody>
<tr class="odd">
	<td><?php echo $usersnames[$score[$i]->uid]->name; ?></td>
	<td><?php echo $score[$i]->points; ?></td>
<?php
    }
	}
?>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="score" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</tbody>
</table>
