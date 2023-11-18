[日本語のREADMEはこちら](https://github.com/immewnity/mediawiki-fluent/blob/main/README-ja.md)

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
