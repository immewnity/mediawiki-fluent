<?php
/**
 * SkinTemplate class for the Fluent skin
 *
 * @ingroup Skins
 */
class SkinFluent extends SkinTemplate {
	public $skinname = 'fluent',
		$stylename = 'Fluent',
		$template = 'FluentTemplate';

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		$out->addMeta( 'viewport',
			'width=device-width, initial-scale=1.0, ' .
			'user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		$out->addModuleStyles( [
			'mediawiki.skinning.elements',
			'skins.fluent'
		] );
		$out->addStyle(
			'https://res-1.cdn.office.net/files/fabric-cdn-prod_20221201.001/office-ui-fabric-core/11.0.0/css/fabric.min.css'
		);
		$out->addModules( [
			'skins.fluent.js'
		] );
	}

	/**
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}
}
