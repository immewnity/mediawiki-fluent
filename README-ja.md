[English README is here](https://github.com/immewnity/mediawiki-fluent/blob/main/README.md)

# MediaWikiのためのFluentスキン

これは[Microsoft's Fluent design system](https://en.wikipedia.org/wiki/Fluent_Design_System)に基づいた[MediaWikiスキン](https://www.mediawiki.org/wiki/Manual:Skins)です。

インストールするには、Fluentフォルダを「\skins」に置き、`wfLoadSkin( 'Fluent' );`をLocalSettingsに追加してください。

## 既知の問題

* [SkinMustache](https://www.mediawiki.org/wiki/Manual:How_to_make_a_MediaWiki_skin/Migrating_SkinTemplate_based_skins_to_SkinMustache)に移行する必要があります。
* テーマカラーがハードコードされている。
* ダークモードの設定がうまくコーディングされていない。
* ダーク/ライトモードはシステム設定に基づいて強制される。
* Special:Preferences、Special:RecentChanges、および同様の特別なページには、適切なフォントとダークモードのスタイルがありません。
* 検索ドロップダウンがウィンドウサイズ変更時に正しく再調整されない。

## 望ましい改善点

* いくつかのシャドウとアニメーションは、Fluent のデザイン言語により合うよう にすると便利かもしれません。
* SemanticMediaWikiのフォントとダークモードのスタイル
