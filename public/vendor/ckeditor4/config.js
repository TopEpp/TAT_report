/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// CKEDITOR.editorConfig = function( config ) {
// 	// Define changes to default configuration here. For example:
// 	// config.language = 'fr';
// 	// config.uiColor = '#AADC6E';
// 	// %REMOVE_START%
// 	config.plugins =
// 		'about,' +
// 		'a11yhelp,' +
// 		'basicstyles,' +
// 		'bidi,' +
// 		'blockquote,' +
// 		'clipboard,' +
// 		'colorbutton,' +
// 		'colordialog,' +
// 		'copyformatting,' +
// 		'contextmenu,' +
// 		'dialogadvtab,' +
// 		'div,' +
// 		'elementspath,' +
// 		'enterkey,' +
// 		'entities,' +
// 		'filebrowser,' +
// 		'find,' +
// 		'floatingspace,' +
// 		'font,' +
// 		'format,' +
// 		'forms,' +
// 		'horizontalrule,' +
// 		'htmlwriter,' +
// 		'image,' +
// 		'iframe,' +
// 		'indentlist,' +
// 		'indentblock,' +
// 		'justify,' +
// 		'language,' +
// 		'link,' +
// 		'list,' +
// 		'liststyle,' +
// 		'magicline,' +
// 		'maximize,' +
// 		'newpage,' +
// 		'pagebreak,' +
// 		'pastefromgdocs,' +
// 		'pastefromlibreoffice,' +
// 		'pastefromword,' +
// 		'pastetext,' +
// 		'editorplaceholder,' +
// 		'preview,' +
// 		'print,' +
// 		'removeformat,' +
// 		'resize,' +
// 		'save,' +
// 		'selectall,' +
// 		'showblocks,' +
// 		'showborders,' +
// 		'smiley,' +
// 		'sourcearea,' +
// 		'specialchar,' +
// 		'stylescombo,' +
// 		'tab,' +
// 		'table,' +
// 		'tableselection,' +
// 		'tabletools,' +
// 		'templates,' +
// 		'toolbar,' +
// 		'undo,' +
// 		'uploadimage,' +
// 		'wysiwygarea';
// 	// %REMOVE_END%
// };

// %LEAVE_UNMINIFIED% %REMOVE_LINE%
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'th';
	config.uiColor = '#ECF0F1';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.extraPlugins = 'linkbutton,linkembed,wordcount';
	config.toolbar = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		{ name: 'tools', items: [ 'ShowBlocks' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'others', items: [ 'linkbutton', '-', 'linkembed' ] }
	];
	config.wordcount = {
		showParagraphs: false,
		showWordCount: false,
		countHTML: true,
		countSpacesAsChars: true,
		showCharCount: true,
		maxCharCount: 4000
	}
};