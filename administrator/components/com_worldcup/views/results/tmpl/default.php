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

/*
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
*/
$teams = $this->teams;
$matches = $this->matches;
$results = $this->results;
$groups = $this->groups;
$data = $this->data;

$format = 'd/m H:i';

JHtml::_('behavior.framework', true);

$user = JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_worldcup.results');
$saveOrder	= $listOrder == 't.ordering';
$sortFields = $this->getSortFields();

?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<script type="text/javascript" src="components/com_worldcup/js/results.js"></script>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=results'); ?>" method="post" name="adminForm" id="adminForm">

<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
	<div class="clearfix"> </div>

	<?php

		$total = (count($this->teams) > 12) ? 5 : 4;

		for($i=0;$i<=$total;$i++)
		{
			echo $this->getResultList($i); 
		}
	?>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="results" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
