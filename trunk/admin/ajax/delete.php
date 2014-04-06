<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

define( '_JEXEC', 1 );
define( 'JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE.DS.'defines.php' );

require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'methods.php' );
require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'factory.php' );
require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'import.php' );
require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'error'.DS.'error.php' );
require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'base'.DS.'object.php' );
require_once ( JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'database.php' );

require(JPATH_ROOT.DS."configuration.php");

$jconfig = new JConfig();
//print_r($jconfig);

$config = array();
$config['driver']   = 'mysql';
$config['host']     = $jconfig->host;
$config['user']     = $jconfig->user;
$config['password'] = $jconfig->password;
$config['database'] = $jconfig->db;
$config['prefix']   = $jconfig->dbprefix;
//print_r($config);

//$config_new = $config;
//$config_new['prefix'] = "j16_";

$db = JDatabase::getInstance( $config );
//$db_new = JDatabase::getInstance( $config_new );
//$db = new JDatabase( $config );
//print_r($db);

$mid = JRequest::getInt( 'id' );
$l = JRequest::getInt( 'l' );
$v = JRequest::getInt( 'v' );

$query = "DELETE FROM `#__worldcup_results` WHERE mid = '{$mid}'
 AND  local = '{$l}' AND visit = '{$v}'";
$db->setQuery( $query );
$db->query();
print_r($db->getError());
//echo $query;

//print_r($_GET);


//echo "\n\n";

//sleep(1);
?>

