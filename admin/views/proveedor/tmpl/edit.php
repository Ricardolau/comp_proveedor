<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_proveedor
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$assoc = JLanguageAssociations::isEnabled();

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "proveedor.cancel" || document.formvalidator.isValid(document.getElementById("proveedor-form")))
		{
			' . $this->form->getField("misc")->save() . '
			Joomla.submitform(task, document.getElementById("proveedor-form"));
		}
	};
');
// Fieldsets to not automatically render by /layouts/joomla/edit/params.php
$this->ignore_fieldsets = array('details', 'item_associations', 'jmetadata');

?>

<form action="<?php echo JRoute::_('index.php?option=com_proveedor&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="proveedor-form" class="form-validate">

	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_PROVEEDOR_NEW_CONTACT', true) : JText::_('COM_PROVEEDOR_EDIT_CONTACT', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('image'); ?>
						<?php echo $this->form->renderField('pro_cif'); ?>
						<?php echo $this->form->renderField('email_to'); ?>
						<?php echo $this->form->renderField('address'); ?>
						<?php echo $this->form->renderField('suburb'); ?>
						<?php echo $this->form->renderField('state'); ?>
						<?php echo $this->form->renderField('postcode'); ?>
						<?php echo $this->form->renderField('country'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('telephone'); ?>
						<?php echo $this->form->renderField('mobile'); ?>
						<?php echo $this->form->renderField('fax'); ?>
						<?php echo $this->form->renderField('webpage'); ?>
						<?php echo $this->form->renderField('facebook'); ?>
						<?php echo $this->form->renderField('twitter'); ?>
						<?php echo $this->form->renderField('google_plus'); ?>
					</div>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'misc', JText::_('JGLOBAL_FIELDSET_MISCELLANEOUS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
				<div class="form-vertical">
					<?php echo $this->form->renderField('misc'); ?>
				</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

		<?php if ($assoc) : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'associations', JText::_('JGLOBAL_FIELDSET_ASSOCIATIONS', true)); ?>
			<?php echo $this->loadTemplate('associations'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
