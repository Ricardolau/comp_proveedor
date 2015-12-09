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
 * Controller for single proveedor view
 *
 * @since  1.5.19
 */
class ProveedorControllerProveedor extends JControllerForm
{
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6.4
	 */
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	/**
	 * Method to submit the proveedor form and send an email.
	 *
	 * @return  boolean  True on success sending the email. False on failure.
	 *
	 * @since   1.5.19
	 */
	public function submit()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app    = JFactory::getApplication();
		$model  = $this->getModel('proveedor');
		$params = JComponentHelper::getParams('com_proveedor');
		$stub   = $this->input->getString('id');
		$id     = (int) $stub;

		// Get the data from POST
		$data    = $this->input->post->get('jform', array(), 'array');
		$proveedor = $model->getItem($id);

		$params->merge($proveedor->params);

		// Check for a valid session cookie
		if ($params->get('validate_session', 0))
		{
			if (JFactory::getSession()->getState() != 'active')
			{
				JError::raiseWarning(403, JText::_('COM_PROVEEDOR_SESSION_INVALID'));

				// Save the data in the session.
				$app->setUserState('com_proveedor.proveedor.data', $data);

				// Redirect back to the proveedor form.
				$this->setRedirect(JRoute::_('index.php?option=com_proveedor&view=proveedor&id=' . $stub, false));

				return false;
			}
		}

		// Proveedor plugins
		JPluginHelper::importPlugin('proveedor');
		$dispatcher = JEventDispatcher::getInstance();

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			JError::raiseError(500, $model->getError());

			return false;
		}

		$validate = $model->validate($form, $data);

		if ($validate === false)
		{
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_proveedor.proveedor.data', $data);

			// Redirect back to the proveedor form.
			$this->setRedirect(JRoute::_('index.php?option=com_proveedor&view=proveedor&id=' . $stub, false));

			return false;
		}

		// Validation succeeded, continue with custom handlers
		$results = $dispatcher->trigger('onValidateProveedor', array(&$proveedor, &$data));

		foreach ($results as $result)
		{
			if ($result instanceof Exception)
			{
				return false;
			}
		}

		// Passed Validation: Process the proveedor plugins to integrate with other applications
		$dispatcher->trigger('onSubmitProveedor', array(&$proveedor, &$data));

		// Send the email
		$sent = false;

		if (!$params->get('custom_reply'))
		{
			$sent = $this->_sendEmail($data, $proveedor, $params->get('show_email_copy'));
		}

		// Set the success message if it was a success
		if (!($sent instanceof Exception))
		{
			$msg = JText::_('COM_PROVEEDOR_EMAIL_THANKS');
		}
		else
		{
			$msg = '';
		}

		// Flush the data from the session
		$app->setUserState('com_proveedor.proveedor.data', null);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($proveedor->params->get('redirect'))
		{
			$this->setRedirect($proveedor->params->get('redirect'), $msg);
		}
		else
		{
			$this->setRedirect(JRoute::_('index.php?option=com_proveedor&view=proveedor&id=' . $stub, false), $msg);
		}

		return true;
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   array      $data                  The data to send in the email.
	 * @param   stdClass   $proveedor               The user information to send the email to
	 * @param   boolean    $copy_email_activated  True to send a copy of the email to the user.
	 *
	 * @return  boolean  True on success sending the email, false on failure.
	 *
	 * @since   1.6.4
	 */
	private function _sendEmail($data, $proveedor, $copy_email_activated)
	{
			$app = JFactory::getApplication();

			$mailfrom = $app->get('mailfrom');
			$fromname = $app->get('fromname');
			$sitename = $app->get('sitename');

			$name    = $data['proveedor_name'];
			$email   = JStringPunycode::emailToPunycode($data['proveedor_email']);
			$subject = $data['proveedor_subject'];
			$body    = $data['proveedor_message'];

			// Prepare email body
			$prefix = JText::sprintf('COM_PROVEEDOR_ENQUIRY_TEXT', JUri::base());
			$body	= $prefix . "\n" . $name . ' <' . $email . '>' . "\r\n\r\n" . stripslashes($body);

			$mail = JFactory::getMailer();
			$mail->addRecipient($proveedor->email_to);
			$mail->addReplyTo($email, $name);
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($sitename . ': ' . $subject);
			$mail->setBody($body);
			$sent = $mail->Send();

			// If we are supposed to copy the sender, do so.

			// Check whether email copy function activated
			if ($copy_email_activated == true && !empty($data['proveedor_email_copy']))
			{
				$copytext    = JText::sprintf('COM_PROVEEDOR_COPYTEXT_OF', $proveedor->name, $sitename);
				$copytext    .= "\r\n\r\n" . $body;
				$copysubject = JText::sprintf('COM_PROVEEDOR_COPYSUBJECT_OF', $subject);

				$mail = JFactory::getMailer();
				$mail->addRecipient($email);
				$mail->addReplyTo(array($email, $name));
				$mail->setSender(array($mailfrom, $fromname));
				$mail->setSubject($copysubject);
				$mail->setBody($copytext);
				$sent = $mail->Send();
			}

			return $sent;
	}
}
