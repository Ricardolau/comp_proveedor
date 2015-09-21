<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_proveedor
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

if (isset($this->error)) : ?>
	<div class="proveedor-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="proveedor-form">
	<form id="proveedor-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<fieldset>
			<legend><?php echo JText::_('COM_PROVEEDOR_FORM_LABEL'); ?></legend>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('proveedor_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('proveedor_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('proveedor_email'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('proveedor_email'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('proveedor_subject'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('proveedor_subject'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('proveedor_message'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('proveedor_message'); ?></div>
			</div>
			<?php if ($this->params->get('show_email_copy')) : ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('proveedor_email_copy'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('proveedor_email_copy'); ?></div>
				</div>
			<?php endif; ?>
			<?php // Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php if ($fieldset->name != 'proveedor') : ?>
					<?php $fields = $this->form->getFieldset($fieldset->name); ?>
					<?php foreach ($fields as $field) : ?>
						<div class="control-group">
							<?php if ($field->hidden) : ?>
								<div class="controls">
									<?php echo $field->input; ?>
								</div>
							<?php else: ?>
								<div class="control-label">
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type != "Spacer") : ?>
										<span class="optional"><?php echo JText::_('COM_PROVEEDOR_OPTIONAL'); ?></span>
									<?php endif; ?>
								</div>
								<div class="controls"><?php echo $field->input; ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="form-actions">
				<button class="btn btn-primary validate" type="submit"><?php echo JText::_('COM_PROVEEDOR_CONTACT_SEND'); ?></button>
				<input type="hidden" name="option" value="com_proveedor" />
				<input type="hidden" name="task" value="proveedor.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<input type="hidden" name="id" value="<?php echo $this->proveedor->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</fieldset>
	</form>
</div>
