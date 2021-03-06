<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_proveedor
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JFormHelper::loadRuleClass('email');

/**
 * JFormRule for com_proveedor to make sure the E-Mail adress is not blocked.
 *
 * @since  1.6
 */
class JFormRuleProveedorEmail extends JFormRuleEmail
{
	/**
	 * Method to test for banned e-mail addresses
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 * @param   Registry          $input    An optional Registry object with the entire data set to validate against the entire form.
	 * @param   JForm             $form     The form object for which the field is being tested.
	 *
	 * @return  boolean  True if the value is valid, false otherwise.
	 */
	public function test(SimpleXMLElement $element, $value, $group = null, Registry $input = null, JForm $form = null)
	{
		if (!parent::test($element, $value, $group, $input, $form))
		{
			return false;
		}

		$params = JComponentHelper::getParams('com_proveedor');
		$banned = $params->get('banned_email');

		if ($banned)
		{
			foreach (explode(';', $banned) as $item)
			{
				if ($item != '' && JString::stristr($value, $item) !== false)
				{
					return false;
				}
			}
		}

		return true;
	}
}
