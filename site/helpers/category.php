<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_proveedor
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Proveedor Component Category Tree
 *
 * @since  1.6
 */
class ProveedorCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   1.6
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__proveedor_details';
		$options['extension'] = 'com_proveedor';
		$options['statefield'] = 'published';
		parent::__construct($options);
	}
}
