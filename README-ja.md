## <div align="center"><b><a href="README.md">English</a> | <a href="README-ja.md">日本語</a></b></div>

<div align="center">

[![download](https://img.shields.io/github/downloads/immewnity/mediawiki-fluent/total.svg?color=green&label=ダウンロード)](https://github.com/immewnity/mediawiki-fluent/releases)
[![Open issue](https://img.shields.io/github/issues/immewnity/mediawiki-fluent?color=red)](https://github.com/immewnity/mediawiki-fluent/issues)
[![Closed issue](https://img.shields.io/github/issues-closed/immewnity/mediawiki-fluent?color=blue)](https://github.com/immewnity/mediawiki-fluent/issues)

</div>

# MediaWikiのためのFluentスキン

[Microsoft's Fluent design system](https://en.wikipedia.org/wiki/Fluent_Design_System)に基づいた[MediaWikiスキン](https://www.mediawiki.org/wiki/Manual:Skins)です。

インストールするには、Fluentフォルダを「\skins」に置き、`wfLoadSkin( 'Fluent' );`をLocalSettingsに追加してください。

## 既知の問題

* [SkinMustache](https://www.mediawiki.org/wiki/Manual:How_to_make_a_MediaWiki_skin/Migrating_SkinTemplate_based_skins_to_SkinMustache)に移行する必要があります。
* テーマカラーがハードコードされています。
* ダークモードの設定がうまくコーディングされていないです。
* ダーク/ライトモードはシステム設定に基づいて強制されます。
* Special:Preferences、Special:RecentChanges、および同様の特別なページには、適切なフォントとダークモードのスタイルがありません。
* 検索ドロップダウンがウィンドウサイズ変更時に正しく再調整されない。

## 望ましい改善点

* いくつかのシャドウとアニメーションは、Fluent のデザイン言語により合うよう にすると便利かもしれません。
* SemanticMediaWikiのフォントとダークモードのスタイルを導入したい。
