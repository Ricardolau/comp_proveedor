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
 * Marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<dl class="proveedor-address dl-horizontal" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	<?php if (($this->params->get('address_check') > 0) &&
		($this->proveedor->address || $this->proveedor->suburb  || $this->proveedor->state || $this->proveedor->country || $this->proveedor->postcode)) : ?>
		<?php if ($this->params->get('address_check') > 0) : ?>
			<dt>
				<span class="<?php echo $this->params->get('marker_class'); ?>" >
					<?php echo $this->params->get('marker_address'); ?>
				</span>
			</dt>
		<?php endif; ?>

		<?php if ($this->proveedor->address && $this->params->get('show_street_address')) : ?>
			<dd>
				<span class="proveedor-street" itemprop="streetAddress">
					<?php echo nl2br($this->proveedor->address) . '<br />'; ?>
				</span>
			</dd>
		<?php endif; ?>

		<?php if ($this->proveedor->suburb && $this->params->get('show_suburb')) : ?>
			<dd>
				<span class="proveedor-suburb" itemprop="addressLocality">
					<?php echo $this->proveedor->suburb . '<br />'; ?>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($this->proveedor->state && $this->params->get('show_state')) : ?>
			<dd>
				<span class="proveedor-state" itemprop="addressRegion">
					<?php echo $this->proveedor->state . '<br />'; ?>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($this->proveedor->postcode && $this->params->get('show_postcode')) : ?>
			<dd>
				<span class="proveedor-postcode" itemprop="postalCode">
					<?php echo $this->proveedor->postcode . '<br />'; ?>
				</span>
			</dd>
		<?php endif; ?>
		<?php if ($this->proveedor->country && $this->params->get('show_country')) : ?>
		<dd>
			<span class="proveedor-country" itemprop="addressCountry">
				<?php echo $this->proveedor->country . '<br />'; ?>
			</span>
		</dd>
		<?php endif; ?>
	<?php endif; ?>

<?php if ($this->proveedor->email_to && $this->params->get('show_email')) : ?>
	<dt>
		<span class="<?php echo $this->params->get('marker_class'); ?>" itemprop="email">
			<?php echo nl2br($this->params->get('marker_email')); ?>
		</span>
	</dt>
	<dd>
		<span class="proveedor-emailto">
			<?php echo $this->proveedor->email_to; ?>
		</span>
	</dd>
<?php endif; ?>

<?php if ($this->proveedor->telephone && $this->params->get('show_telephone')) : ?>
	<dt>
		<span class="<?php echo $this->params->get('marker_class'); ?>" >
			<?php echo $this->params->get('marker_telephone'); ?>
		</span>
	</dt>
	<dd>
		<span class="proveedor-telephone" itemprop="telephone">
			<?php echo nl2br($this->proveedor->telephone); ?>
		</span>
	</dd>
<?php endif; ?>
<?php if ($this->proveedor->fax && $this->params->get('show_fax')) : ?>
	<dt>
		<span class="<?php echo $this->params->get('marker_class'); ?>">
			<?php echo $this->params->get('marker_fax'); ?>
		</span>
	</dt>
	<dd>
		<span class="proveedor-fax" itemprop="faxNumber">
		<?php echo nl2br($this->proveedor->fax); ?>
		</span>
	</dd>
<?php endif; ?>
<?php if ($this->proveedor->mobile && $this->params->get('show_mobile')) :?>
	<dt>
		<span class="<?php echo $this->params->get('marker_class'); ?>" >
			<?php echo $this->params->get('marker_mobile'); ?>
		</span>
	</dt>
	<dd>
		<span class="proveedor-mobile" itemprop="telephone">
			<?php echo nl2br($this->proveedor->mobile); ?>
		</span>
	</dd>
<?php endif; ?>
<?php if ($this->proveedor->webpage && $this->params->get('show_webpage')) : ?>
	<dt>
		<span class="<?php echo $this->params->get('marker_class'); ?>" >
		</span>
	</dt>
	<dd>
		<span class="proveedor-webpage">
			<a href="<?php echo $this->proveedor->webpage; ?>" rel="nofollow" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->proveedor->webpage); ?></a>
		</span>
	</dd>
<?php endif; ?>
<?php  // Aquí debería haber un parametro de mostrar redes sociales ... si o no 
if ($this->proveedor->webpage && $this->params->get('show_webpage')) : ?>
	<dt>
		<span class="<?php echo $this->params->get('marker_facebook_class'); ?>" >
		<?php echo $this->params->get('marker_facebook'); ?>
		</span>
	</dt>
			
	<dd>
		<span class="proveedor-facebook">
			<a href="<?php echo $this->proveedor->facebook; ?>" rel="nofollow" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->proveedor->facebook); ?></a>
		</span>
	</dd>
	<dt>
		<span class="<?php echo $this->params->get('marker_twitter_class'); ?>" >
		<?php echo $this->params->get('marker_twitter'); ?>
		</span>
	</dt>
			
	<dd>
		<span class="proveedor-twitter">
			<a href="<?php echo $this->proveedor->twitter; ?>" rel="nofollow" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->proveedor->twitter); ?></a>
		</span>
	</dd>
	<dt>
		<span class="<?php echo $this->params->get('marker_google_plus_class'); ?>" >
		<?php echo $this->params->get('marker_google_plus'); ?>
		</span>
	</dt>
			
	<dd>
		<span class="proveedor-googlep">
			<a href="<?php echo $this->proveedor->google_plus; ?>" rel="nofollow" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->proveedor->google_plus); ?></a>
		</span>
	</dd>
	
	
	
<?php endif; ?>





</dl>
