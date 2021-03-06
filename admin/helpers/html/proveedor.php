<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_proveedor
 *  *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('ProveedorHelper', JPATH_ADMINISTRATOR . '/components/com_proveedor/helpers/proveedor.php');

/**
 * Proveedor HTML helper class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_proveedor
 * @since       1.6
 */
abstract class JHtmlProveedor
{
	/**
	 * Get the associated language flags
	 *
	 * @param   int  $proveedorid  The item id to search associations
	 *
	 * @return  string  The language HTML
	 */
	public static function association($proveedorid)
	{
		// Defaults
		$html = '';

		// Get the associations
		if ($associations = JLanguageAssociations::getAssociations('com_proveedor', '#__proveedor_details', 'com_proveedor.item', $proveedorid))
		{
			foreach ($associations as $tag => $associated)
			{
				$associations[$tag] = (int) $associated->id;
			}

			// Get the associated proveedor items
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('c.id, c.name as title')
				->select('l.sef as lang_sef')
				->from('#__proveedor_details as c')
				->select('cat.title as category_title')
				->join('LEFT', '#__categories as cat ON cat.id=c.catid')
				->where('c.id IN (' . implode(',', array_values($associations)) . ')')
				->join('LEFT', '#__languages as l ON c.language=l.lang_code')
				->select('l.image')
				->select('l.title as language_title');
			$db->setQuery($query);

			try
			{
				$items = $db->loadObjectList('id');
			}
			catch (runtimeException $e)
			{
				throw new Exception($e->getMessage(), 500);

				return false;
			}

			if ($items)
			{
				foreach ($items as &$item)
				{
					$text = strtoupper($item->lang_sef);
					$url = JRoute::_('index.php?option=com_proveedor&task=proveedor.edit&id=' . (int) $item->id);
					$tooltipParts = array(
						JHtml::_('image', 'mod_languages/' . $item->image . '.gif',
								$item->language_title,
								array('title' => $item->language_title),
								true
						),
						$item->title,
						'(' . $item->category_title . ')'
					);

					$item->link = JHtml::_(
						'tooltip',
						implode(' ', $tooltipParts),
						null,
						null,
						$text,
						$url,
						null,
						'hasTooltip label label-association label-' . $item->lang_sef
					);
				}
			}

			$html = JLayoutHelper::render('joomla.content.associations', $items);
		}

		return $html;
	}

	/**
	 * Show the featured/not-featured icon.
	 *
	 * @param   int   $value      The featured value.
	 * @param   int   $i          Id of the item.
	 * @param   bool  $canChange  Whether the value can be changed or not.
	 *
	 * @return  string	The anchor tag to toggle featured/unfeatured proveedors.
	 *
	 * @since   1.6
	 */
	public static function featured($value = 0, $i, $canChange = true)
	{

		// Array of image, task, title, action
		$states	= array(
			0	=> array('unfeatured', 'proveedors.featured', 'COM_PROVEEDOR_UNFEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
			1	=> array('featured', 'proveedors.unfeatured', 'JFEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$icon	= $state[0];

		if ($canChange)
		{
			$html	= '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip' . ($value == 1 ? ' active' : '') . '" title="' . JHtml::tooltipText($state[3]) . '"><span class="icon-'
				. $icon . '"></span></a>';
		}
		else
		{
			$html	= '<a class="btn btn-micro hasTooltip disabled' . ($value == 1 ? ' active' : '') . '" title="' . JHtml::tooltipText($state[2]) . '"><span class="icon-'
				. $icon . '"></span></a>';
		}

		return $html;
	}
}
