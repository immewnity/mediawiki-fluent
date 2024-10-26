<?php

use MediaWiki\MediaWikiServices;

/**
 * BaseTemplate class for the Fluent skin
 *
 * @ingroup Skins
 */
class FluentTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$html = '';
		$html .= $this->get( 'headelement' );
		$html .= Html::rawElement( 'header', [ 'id' => 'fabric-heading' ],
				$this->getLogo() .
				Html::rawElement(
					'div',
					[ 'id' => 'search-box' ],
					$this->getSearch()
				) .
				// User profile links
				Html::rawElement(
					'nav',
					[ 'id' => 'user-tools' ],
					Html::rawElement(
						'div',
						[ 'id' => 'search-icon' ]
					) .
					Html::rawElement(
						'button',
						[ 'id' => 'user-icon', 'title' => 'User icon' ],
						Html::rawElement(
							'div',
							[ 'id' => 'user-icon-img', 'style' => 'background-image: url("' . $this->getGravatarUrl() . '");' ]
						)
					) .
					$this->getUserLinks()
				)
		);
		$html .= Html::rawElement( 'div', [ 'id' => 'mw-wrapper', 'class' => 'ms-Fabric' ],
			Html::rawElement( 'div', [ 'class' => 'mw-body', 'id' => 'content', 'role' => 'main' ],
				$this->getSiteNotice() .
				$this->getNewTalk() .
				// Page editing and tools
				Html::rawElement(
					'nav',
					[ 'id' => 'page-tools' ],
					$this->getPageLinks()
				) .
				Html::rawElement( 'main', [ 'id' => 'mw-main-content' ],
					$this->getIndicators() .
					Html::rawElement( 'h1',
						[
							'class' => 'firstHeading',
							'lang' => $this->get( 'pageLanguage' )
						],
						$this->get( 'title' )
					) .
					Html::rawElement( 'div', [ 'id' => 'siteSub' ],
						$this->getMsg( 'tagline' )->parse()
					) .
					Html::rawElement( 'div', [ 'class' => 'mw-body-content' ],
						Html::rawElement( 'div', [ 'id' => 'contentSub' ],
							$this->getPageSubtitle() .
							Html::rawElement(
								'p',
								[],
								$this->get( 'undelete' )
							)
						) .
						$this->get( 'bodycontent' ) .
						$this->getClear() .
						Html::rawElement( 'div', [ 'class' => 'printfooter' ],
							$this->get( 'printfooter' )
						) .
						$this->getCategoryLinks()
					) .
					$this->getDataAfterContent() .
					$this->get( 'debughtml' ) .
					$this->getFooterBlock()
				)
			) .
			Html::rawElement( 'nav', [ 'id' => 'mw-navigation' ],
				// Site navigation/sidebar
				Html::rawElement(
					'div',
					[ 'id' => 'site-navigation' ],
					$this->getSiteNavigation()
				) .
				Html::rawElement(
					'div',
					[ 'id' => 'expand-collapse' ],
					"<span>Collapse</span>"
				)
			)
		);

		$html .= $this->getTrail();
		$html .= Html::closeElement( 'body' );
		$html .= Html::closeElement( 'html' );

		echo $html;
	}

	/**
	 * Generates the logo and (optionally) site title
	 * @param string $id
	 * @param bool $imageOnly Whether or not to generate the logo with only the image,
	 * or with a text link as well
	 *
	 * @return string html
	 */
	protected function getLogo( $id = 'p-logo', $imageOnly = false ) {
		$html = Html::openElement(
			'div',
			[
				'id' => $id,
				'class' => 'mw-portlet',
				'role' => 'banner'
			]
		);
		$html .= Html::element(
			'a',
			[
				'href' => $this->data['nav_urls']['mainpage']['href'],
				'class' => 'mw-wiki-logo',
			] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
		);
		if ( !$imageOnly ) {
			$language = $this->getSkin()->getLanguage();
			$siteTitle = $language->convert( $this->getMsg( 'sitetitle' )->escaped() );

			$html .= Html::rawElement(
				'a',
				[
					'id' => 'p-banner',
					'class' => 'mw-wiki-title',
					'href' => $this->data['nav_urls']['mainpage']['href']
				] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' ),
				$siteTitle
			);
		}
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Generates the search form
	 * @return string html
	 */
	protected function getSearch() {
		$html = Html::openElement(
			'form',
			[
				'action' => $this->get( 'wgScript' ),
				'role' => 'search',
				'class' => 'mw-portlet',
				'id' => 'p-search'
			]
		);
		$html .= Html::hidden( 'title', $this->get( 'searchtitle' ) );
		$html .= Html::rawElement(
			'h3',
			[],
			Html::label( $this->getMsg( 'search' )->text(), 'searchInput' )
		);
		$html .= $this->makeSearchInput( [ 'id' => 'searchInput', 'required' ] );
		$html .= $this->makeSearchButton( 'go', [ 'id' => 'searchGoButton', 'class' => 'searchButton' ] );
		$html .= Html::rawElement(
			'button',
			[
				'class' => 'clear-searchInput',
				'type' => 'reset'
			],
			''
		);

		$html .= Html::closeElement( 'form' );

		return $html;
	}

	/**
	 * Generates the sidebar
	 * Set the elements to true to allow them to be part of the sidebar
	 * Or get rid of this entirely, and take the specific bits to use wherever you actually want them
	 *  * Toolbox is the page/site tools that appears under the sidebar in vector
	 *  * Languages is the interlanguage links on the page via en:... es:... etc
	 *  * Default is each user-specified box as defined on MediaWiki:Sidebar; you will still need a foreach loop
	 *    to parse these.
	 * @return string html
	 */
	protected function getSiteNavigation() {
		$html = '';

		$sidebar = $this->getSidebar();
		$sidebar['SEARCH'] = false;
		$sidebar['TOOLBOX'] = true;
		$sidebar['LANGUAGES'] = true;

		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					$html .= $this->getSearch();
					break;
				case 'TOOLBOX':
					$html .= $this->getPortlet( 'tb', $this->getToolbox(), 'toolbox' );
					break;
				case 'LANGUAGES':
					$html .= $this->getLanguageLinks();
					break;
				default:
					// @phan-suppress-next-line SecurityCheck-DoubleEscaped
					$html .= $this->getPortlet( $name, $content['content'] );
					break;
			}
		}
		return $html;
	}

	/**
	 * In other languages list
	 *
	 * @return string html
	 */
	protected function getLanguageLinks() {
		$html = '';
		if ( $this->data['language_urls'] !== false ) {
			$html .= $this->getPortlet( 'lang', $this->data['language_urls'], 'otherlanguages' );
		}

		return $html;
	}

	/**
	 * Language variants. Displays list for converting between different scripts in the same language,
	 * if using a language where this is applicable (such as latin vs cyric display for serbian).
	 *
	 * @return string html
	 */
	protected function getVariants() {
		$html = '';
		if ( count( $this->data['content_navigation']['variants'] ) > 0 ) {
			$html .= $this->getPortlet(
				'variants',
				$this->data['content_navigation']['variants']
			);
		}

		return $html;
	}

	/**
	 * Generates page-related tools/links
	 * You will probably want to split this up and move all of these to somewhere that makes sense for your skin.
	 * @return string html
	 */
	protected function getPageLinks() {
		$leftNav = "";
		$rightNav = "";
		// Namespaces: links for 'content' and 'talk' for namespaces with talkpages. Otherwise is just the content.
		// Usually rendered as tabs on the top of the page.
		if (count($this->data['content_navigation']['namespaces']) > 0) {
			$leftNav .= $this->getPortlet(
				'namespaces',
				$this->data['content_navigation']['namespaces']
			);
		}
		// Language variant options
		$leftNav .= $this->getVariants();
		// 'View' actions for the page: view, edit, view history, etc
		if (count($this->data['content_navigation']['views']) > 0) {
			$leftNav .= $this->getPortlet(
				'views',
				$this->data['content_navigation']['views']
			);
		}
		$html = Html::rawElement(
			'div',
			['role' => 'navigation', 'id' => 'topNav-left', 'class' => 'topNav-container'],
			$leftNav
		);
		// Other actions for the page: move, delete, protect, everything else
		if (count($this->data['content_navigation']['actions']) > 0) {
			$rightNav .= $this->getPortlet(
				'actions',
				$this->data['content_navigation']['actions']
			);
			$html .= Html::rawElement(
				'div',
				['role' => 'navigation', 'id' => 'topNav-right', 'class' => 'topNav-container'],
				$rightNav
			);
		}
		return $html;
	}

	/**
	 * Generates URL for the user's Gravatar, or defaults to a generic face if no Gravatar
	 * @param bool $disableGravatar Whether or not to use Gravatar
	 * @return string html
	 */
    protected function getGravatarUrl() {
	$skinConfig = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig('Fluent');
	$isGravatarEnabled = $skinConfig->get('FluentDisableGravatar');
	$skin = $this->getSkin();
	$genericFace =
		$this->config->get( 'CanonicalServer' ) . $skin->getConfig()->get( 'StylePath' ) .
		'/Fluent/resources/default-user.png';
	if ( !$isGravatarEnabled ) {
		return $genericFace;
	} else {
		$gravatarUrl =
			'https://www.gravatar.com/avatar/' .
			md5( strtolower( trim( $this->getSkin()->getUser()->getEmail() ) ) ) . '?d=' .
			urlencode( $genericFace ) . '&s=' . 100;
	
		return $gravatarUrl;
	}
    }

	/**
	 * Generates user tools menu
	 * @return string html
	 */
	protected function getUserLinks() {
		$personalTools = $this->getPersonalTools();

		$html = '';

		// Move Echo badges out of default list - they should be visible outside of dropdown;
		// may not even work at all inside one
		$extraTools = [];
		if ( isset( $personalTools['notifications-alert'] ) ) {
			$extraTools['notifications-alert'] = $personalTools['notifications-alert'];
			unset( $personalTools['notifications-alert'] );
		}
		if ( isset( $personalTools['notifications-notice'] ) ) {
			$extraTools['notifications-notice'] = $personalTools['notifications-notice'];
			unset( $personalTools['notifications-notice'] );
		}
		// Move ULS trigger if you want to better support the user options trigger
		// if ( isset( $personalTools['uls'] ) ) {
		//	$extraTools['uls'] = $personalTools['uls'];
		//	unset( $personalTools['uls'] );
		// }

		$html .= Html::openElement( 'div', [ 'id' => 'mw-user-links' ] );

		// Place the extra icons/outside stuff
		if ( !empty( $extraTools ) ) {
			$iconList = '';
			foreach ( $extraTools as $key => $item ) {
				$iconList .= $this->makeListItem( $key, $item );
			}

			$html .= Html::rawElement(
				'div',
				[ 'id' => 'p-personal-extra', 'class' => 'p-body' ],
				Html::rawElement( 'ul', [], $iconList )
			);
		}

		$html .= $this->getPortlet( 'personal', $personalTools, 'personaltools' );






		$html .= Html::rawElement(
			'div',
			[ 'id' => 'p-dark-toggle', 'class' => 'mw-portlet' ],
			Html::rawElement(
				'div',
				[ 'id' => 'menu-dark-toggle', 'class' => 'mw-portlet-body' ],
				Html::rawElement(
					'ul',
					[ 'id' => 'ul-dark-toggle' ],
					Html::rawElement(
						'li',
						[ 'id' => 'li-dark-toggle' ],
						Html::rawElement(
							'a',
							[ "id" => "a-dark-toggle", "title" => "Toggle dark mode" ],
							"Toggle dark mode"
						)
					)
				)
			)
		);





		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Generates siteNotice, if any
	 * @return string html
	 */
	protected function getSiteNotice() {
		return $this->getIfExists( 'sitenotice', [
			'wrapper' => 'div',
			'parameters' => [ 'id' => 'siteNotice' ]
		] );
	}

	/**
	 * Generates new talk message banner, if any
	 * @return string html
	 */
	protected function getNewTalk() {
		return $this->getIfExists( 'newtalk', [
			'wrapper' => 'div',
			'parameters' => [ 'class' => 'usermessage' ]
		] );
	}

	/**
	 * Generates subtitle stuff, if any
	 * @return string html
	 */
	protected function getPageSubtitle() {
		return $this->getIfExists( 'subtitle', [ 'wrapper' => 'p' ] );
	}

	/**
	 * Generates category links, if any
	 * @return string html
	 */
	protected  function getCategoryLinks() {
		return $this->getIfExists( 'catlinks' );
	}

	/**
	 * Generates data after content stuff, if any
	 * @return string html
	 */
	protected function getDataAfterContent() {
		return $this->getIfExists( 'dataAfterContent' );
	}

	/**
	 * Simple wrapper for random if-statement-wrapped $this->data things
	 *
	 * @param string $object name of thing
	 * @param array $setOptions
	 *
	 * @return string html
	 */
	protected function getIfExists( $object, $setOptions = [] ) {
		$options = $setOptions + [
			'wrapper' => 'none',
			'parameters' => []
		];
		'@phan-var array{wrapper:string,parameters:array} $options';

		$html = '';

		if ( $this->data[$object] ) {
			if ( $options['wrapper'] === 'none' ) {
				$html .= $this->get( $object );
			} else {
				$html .= Html::rawElement(
					$options['wrapper'],
					$options['parameters'],
					$this->get( $object )
				);
			}
		}

		return $html;
	}

	/**
	 * Generates a block of navigation links with a header
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 * @param null|string|array $msg
	 * @param array $setOptions random crap to rename/do/whatever
	 *
	 * @return string html
	 */
	protected function getPortlet( $name, $content, $msg = null, $setOptions = [] ) {
		// random stuff to override with any provided options
		$options = $setOptions + [
			// extra classes/ids
			'id' => 'p-' . $name,
			'class' => 'mw-portlet',
			'extra-classes' => '',
			// what to wrap the body list in, if anything
			'body-wrapper' => 'div',
			'body-id' => 'menu-' . $name,
			'body-class' => 'mw-portlet-body',
			// makeListItem options
			'list-item' => [ 'text-wrapper' => [ 'tag' => 'span' ] ],
			// option to stick arbitrary stuff at the beginning of the ul
			'list-prepend' => '',
			// old toolbox hook support (use: [ 'SkinTemplateToolboxEnd' => [ &$skin, true ] ])
			'hooks' => ''
		];
		'@phan-var array{id:string,class:string|array,extra-classes:string|array,body-wrapper:string,body-id:?string,body-class:string,list-item:array,list-prepend:string, hooks:string|array} $options';

		// Handle the different $msg possibilities
		if ( $msg === null ) {
			$msg = $name;
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		}
		$msgObj = $this->getMsg( $msg );
		if ( $msgObj->exists() ) {
			if ( isset( $msgParams ) && !empty( $msgParams ) ) {
				$msgString = $this->getMsg( $msg, $msgParams )->parse();
			} else {
				$msgString = $msgObj->parse();
			}
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul',
				[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ]
			);
			$contentText .= $options['list-prepend'];
			foreach ( $content as $key => $item ) {
				$contentText .= $this->makeListItem( $key, $item, $options['list-item'] );
			}
			// Compatibility with extensions still using SkinTemplateToolboxEnd or similar
			if ( is_array( $options['hooks'] ) ) {
				foreach ( $options['hooks'] as $hook ) {
					if ( is_string( $hook ) ) {
						$hookOptions = [];
					} else {
						// it should only be an array otherwise
						$hookOptions = array_values( $hook )[0];
						$hook = array_keys( $hook )[0];
					}
					$contentText .= $this->deprecatedHookHack( $hook, $hookOptions );
				}
			}

			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		// Special handling for role=search and other weird things
		$divOptions = [
			'role' => 'navigation',
			'id' => Sanitizer::escapeIdForAttribute( $options['id'] ),
			'title' => Linker::titleAttrib( $options['id'] ),
			'aria-labelledby' => $labelId
		];
		$class = is_array( $options['class'] )
			? $options['class'] : [ $options['class'] ];
		$extraClasses = is_array( $options['extra-classes'] )
			? $options['extra-classes'] : [ $options['extra-classes'] ];
		$divOptions['class'] = array_merge( $class, $extraClasses );

		$labelOptions = [
			'id' => $labelId,
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		];

		if ( $options['body-wrapper'] !== 'none' ) {
			$bodyDivOptions = [ 'class' => $options['body-class'] ];
			if ( is_string( $options['body-id'] ) ) {
				$bodyDivOptions['id'] = $options['body-id'];
			}
			$body = Html::rawElement( $options['body-wrapper'], $bodyDivOptions,
				$contentText .
				$this->getSkin()->getAfterPortlet( $name )
			);
		} else {
			$body = $contentText . $this->getSkin()->getAfterPortlet( $name );
		}

		$html = Html::rawElement( 'div', $divOptions,
			Html::rawElement( 'h3', $labelOptions, $msgString ) .
			$body
		);

		return $html;
	}

	/**
	 * Wrapper to catch output of old hooks expecting to write directly to page
	 * We no longer do things that way.
	 *
	 * @param string $hook event
	 * @param array $hookOptions args
	 *
	 * @return string html
	 */
	protected function deprecatedHookHack( $hook, $hookOptions = [] ) {
		$hookContents = '';
		ob_start();
		Hooks::run( $hook, $hookOptions );
		$hookContents = ob_get_contents();
		ob_end_clean();
		if ( !trim( $hookContents ) ) {
			$hookContents = '';
		}

		return $hookContents;
	}

	/**
	 * Better renderer for getFooterIcons and getFooterLinks, based on Vector
	 *
	 * @param array $setOptions Miscellaneous other options
	 * * 'id' for footer id
	 * * 'class' for footer class
	 * * 'order' to determine whether icons or links appear first: 'iconsfirst' or links, though in
	 *   practice we currently only check if it is or isn't 'iconsfirst'
	 * * 'link-prefix' to set the prefix for all link and block ids; most skins use 'f' or 'footer',
	 *   as in id='f-whatever' vs id='footer-whatever'
	 * * 'icon-style' to pass to getFooterIcons: "icononly", "nocopyright"
	 * * 'link-style' to pass to getFooterLinks: "flat" to disable categorisation of links in a
	 *   nested array
	 *
	 * @return string html
	 */
	protected function getFooterBlock( $setOptions = [] ) {
		// Set options and fill in defaults
		$options = $setOptions + [
			'id' => 'footer',
			'class' => 'mw-footer',
			'order' => 'iconsfirst',
			'link-prefix' => 'footer',
			'icon-style' => 'icononly',
			'link-style' => null
		];
		'@phan-var array{id:string,class:string,order:string,link-prefix:string,icon-style:string,link-style:?string} $options';

		$validFooterIcons = $this->getFooterIcons( $options['icon-style'] );
		$validFooterLinks = $this->getFooterLinks( $options['link-style'] );

		$html = '';

		$html .= Html::openElement( 'div', [
			'id' => $options['id'],
			'class' => $options['class'],
			'role' => 'contentinfo',
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		] );

		$iconsHTML = '';
		if ( count( $validFooterIcons ) > 0 ) {
			$iconsHTML .= Html::openElement( 'ul', [ 'id' => "{$options['link-prefix']}-icons" ] );
			foreach ( $validFooterIcons as $blockName => $footerIcons ) {
				$iconsHTML .= Html::openElement( 'li', [
					'id' => Sanitizer::escapeIdForAttribute(
						"{$options['link-prefix']}-{$blockName}ico"
					),
					'class' => 'footer-icons'
				] );
				foreach ( $footerIcons as $icon ) {
					$iconsHTML .= $this->getSkin()->makeFooterIcon( $icon );
				}
				$iconsHTML .= Html::closeElement( 'li' );
			}
			$iconsHTML .= Html::closeElement( 'ul' );
		}

		$linksHTML = '';
		if ( count( $validFooterLinks ) > 0 ) {
			if ( $options['link-style'] === 'flat' ) {
				$linksHTML .= Html::openElement( 'ul', [
					'id' => "{$options['link-prefix']}-list",
					'class' => 'footer-places'
				] );
				foreach ( $validFooterLinks as $link ) {
					$linksHTML .= Html::rawElement(
						'li',
						[ 'id' => Sanitizer::escapeIdForAttribute( $link ) ],
						$this->get( $link )
					);
				}
				$linksHTML .= Html::closeElement( 'ul' );
			} else {
				$linksHTML .= Html::openElement( 'div', [ 'id' => "{$options['link-prefix']}-list" ] );
				foreach ( $validFooterLinks as $category => $links ) {
					$linksHTML .= Html::openElement( 'ul',
						[ 'id' => Sanitizer::escapeIdForAttribute(
							"{$options['link-prefix']}-{$category}"
						) ]
					);
					foreach ( $links as $link ) {
						$linksHTML .= Html::rawElement(
							'li',
							[ 'id' => Sanitizer::escapeIdForAttribute(
								"{$options['link-prefix']}-{$category}-{$link}"
							) ],
							$this->get( $link )
						);
					}
					$linksHTML .= Html::closeElement( 'ul' );
				}
				$linksHTML .= Html::closeElement( 'div' );
			}
		}

		if ( $options['order'] === 'iconsfirst' ) {
			$html .= $iconsHTML . $linksHTML;
		} else {
			$html .= $linksHTML . $iconsHTML;
		}

		$html .= $this->getClear() . Html::closeElement( 'div' );
		return $html;
	}
}
