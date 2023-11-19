## <div align="center"><b><a href="README.md">English</a> | <a href="README-ja.md">日本語</a></b></div>

<div align="center">

[![download](https://img.shields.io/github/downloads/immewnity/mediawiki-fluent/total.svg?color=green)](https://github.com/immewnity/mediawiki-fluent/releases)
[![Open issue](https://img.shields.io/github/issues/immewnity/mediawiki-fluent?color=red)](https://github.com/immewnity/mediawiki-fluent/issues)
[![Closed issue](https://img.shields.io/github/issues-closed/immewnity/mediawiki-fluent?color=blue)](https://github.com/immewnity/mediawiki-fluent/issues)

</div>

# Fluent skin for MediaWiki

This is a [MediaWiki skin](https://www.mediawiki.org/wiki/Manual:Skins) based on [Microsoft's Fluent design system](https://en.wikipedia.org/wiki/Fluent_Design_System).

To install, place the Fluent folder in \skins and add `wfLoadSkin( 'Fluent' );` to LocalSettings.

## Known issues

* Have only tested in 1.35, known issue in 1.39 - needs to be migrated to [SkinMustache](https://www.mediawiki.org/wiki/Manual:How_to_make_a_MediaWiki_skin/Migrating_SkinTemplate_based_skins_to_SkinMustache)
* Theme colors are hardcoded, should give a way to set this via LocalSettings
* Dark mode settings are poorly coded, lots of !important
* Dark/light mode is forced based on system settings, should allow a manual toggle
* Special:Preferences, Special:RecentChanges, and similar special pages are missing proper font and dark mode styles
* Search dropdown does not properly realign on window resize

## Desired improvements

* Some shadows and animations could be useful to better fit the Fluent design language
* Font and dark mode styles for SemanticMediaWiki
