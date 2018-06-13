<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_worldcup
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class from com_worldcup
 *
 * @since  3.3
 */
class WorldcupRouter extends JComponentRouterBase
{
	/**
	 * Build the route for the com_worldcup component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query)
	{
		$segments = array();

		if (isset($query['view']))
		{
			$segments[] = $query['view'];
			unset($query['view']);
		}

		if (isset($query['layout']))
		{
			if ($query['layout'] == 'step7')
			{
				$segments[] = 'show';
			}else{
				$segments[] = $query['layout'];
			}
			unset($query['layout']);
		}

		if (isset($query['task']))
		{
			$segments[] = $query['task'];
			unset($query['task']);
		}

		if (isset($query['step']))
		{
			$segments[] = $query['step'];
			unset($query['step']);
		}

		if (isset($query['id']))
		{
			$segments[] = $query['id'];
			unset($query['id']);
		}

		if (isset($query['cid']))
		{
			$segments[] = $query['cid'];
			unset($query['cid']);
		}

		if (isset($query['user_id']))
		{
			$segments[] = $query['user_id'];
			unset($query['user_id']);
		}

		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}

		return $segments;
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{

		switch($segments[0])
		{
			case 'competition':
				$vars['view'] = 'competition';
				$vars['layout'] = $segments[1];
				$vars['id'] = (int)$segments[2];
				break;
			case 'bets':
				$vars['view'] = 'bets';
				if ($segments[1] == 'show')
				{
					$vars['layout'] = 'step7';
					$vars['cid'] = (int) $segments[2];
					$vars['user_id'] = (int)$segments[3];
				}else{
					if (is_numeric($segments[1]))
					{
						$vars['cid'] = (int) $segments[1];
					}elseif (is_string($segments[1])) {
						$vars['layout'] = $segments[1];
						$vars['cid'] = (int) $segments[2];
					}
				}

				break;
		}

		return $vars;
	}
}

/**
 * Build the route for the com_worldcup component
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function worldcupBuildRoute(&$query)
{
	$router = new WorldcupRouter;

	return $router->build($query);
}

/**
 * Parse the segments of a URL.
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function worldcupParseRoute($segments)
{
	$router = new WorldcupRouter;

	return $router->parse($segments);
}
