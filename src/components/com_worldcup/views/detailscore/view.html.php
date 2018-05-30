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

require_once (JPATH_COMPONENT.DS.'view.php');

?>
<table width="100%">
<tr>
  <td align="center">
    <h2><b><a href="index.php?option=com_worldcup&view=bets"><?php echo JText::_( "My Bet" ); ?></a> - <a href="index.php?option=com_worldcup&view=score"><?php echo JText::_( "Table" ); ?></a> - <a href="index.php?option=com_worldcup&view=results"><?php echo JText::_( "Results" ); ?></a></b></h2>
  </td>
</tr>
</table>
<?php
//ADDED PIOTR
class worldcupViewdetailscore extends WorldCupView {

function display($tpl = null)	{
  global $mainframe;
    $userid = JRequest::getVar( 'userid' );
		if($this->getLayout() == 'detailscore') {
		  $this->detail($tpl);
		  return;
		}
    global $mainframe;

    include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_worldcup'.DS.'worldcup_config.php');
		include(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php');

		//JToolBarHelper::title(  JText::_( 'Results' ), 'worldcup' );
		//JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		//JToolBarHelper::spacer();

		$matches = array();
		$db =& JFactory::getDBO();






		##
		## Get groups
		##
		$query = "SELECT g.*
							FROM #__worldcup_groups AS g
		          ORDER BY g.id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList('id');

		##
		## Get Data for table groups
		##
		$data = WorldCupHelper::_getTableData($groups);

		##
		## Get Matches clasification
		##
		$where = array();
		$where[] = "m.phase = 0";

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' ORDER BY m.id ASC';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();
		print_r($db->getError());
		//print_r($matches);

		##
		## Get Matches of 8vo
		##
		$where = array();
		$where[] = "m.phase = 1";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Get Matches 4tos
		##
		$where = array();
		$where[] = "m.phase = 2";
		$where = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$query = 'SELECT m.*, p.name AS pname'
		. ' FROM #__worldcup_matches AS m'
		. ' LEFT JOIN #__worldcup_places AS p ON p.id = m.place'
		. $where
		. $orderby;
		//echo $query;
		$db->setQuery( $query );
		$matches[] = $db->loadObjectList();

		##
		## Teams
		##
		$query = "SELECT id, name FROM #__worldcup_teams
		          ORDER BY name";
		$db->setQuery($query);
		$teams = $db->loadAssocList('id');

//ADDED Piotr Mackowiak GET BETES
		##
		## Get all Bets
		##
		$query = "SELECT mid, local, visit FROM #__worldcup_bets
              WHERE uid = ".$userid."
		          ORDER BY mid";
		//echo $query;
    //echo "<br>";
		$db->setQuery($query);
		$bets = $db->loadAssocList('mid');
  //print_r($bets);

		##
		## Results
		##
		$query = "SELECT mid, local, visit, finallocal, finalvisit FROM #__worldcup_results
		          ORDER BY mid";
		$db->setQuery($query);
		$results = $db->loadAssocList('mid');

		##
		## Phases
		##
		$phases = array();
		$phases[] = JText::_( 'Clasification' );
		$phases[] = JText::_( 'Round of 16' );
		$phases[] = JText::_( 'Quarter-finals' );
		$phases[] = JText::_( 'Semi-finals' );
		$phases[] = JText::_( 'Match for third place' );
		$phases[] = JText::_( 'Final' );

		##
		## Passing data to template
		##
		$this->assignRef('phases', $phases);
    $this->assignRef('matches', $matches);
		$this->assignRef('teams', $teams);
    $this->assignRef('results', $results);
    $this->assignRef('pageNav', $pageNav);
		$this->assignRef('groups', $groups);
		$this->assignRef('data', $data);
		$this->assignRef('bets',$bets) ;

		parent::display($tpl);
	}

}


?>
