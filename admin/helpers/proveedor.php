<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Proveedor component helper.
 *
 * @since  1.6
 */
class ProveedorHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_PROVEEDOR_SUBMENU_CONTACTS'),
			'index.php?option=com_proveedor&view=proveedors',
			$vName == 'proveedors'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_PROVEEDOR_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_proveedor',
			$vName == 'categories'
		);
	}
}
