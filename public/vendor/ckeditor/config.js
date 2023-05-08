/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
/**
* Full Button
config.toolbar = [
  { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
  { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
  { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
  { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
  '/',
  { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
  { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
  { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
  { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
  '/',
  { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
  { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
  { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
  { name: 'others', items: [ '-' ] },
  { name: 'about', items: [ 'About' ] }
];
*/

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  config.language = 'th';
  config.uiColor = '#ECF0F1';
  config.allowedContent = false;
  config.enterMode = CKEDITOR.ENTER_BR;
  config.shiftEnterMode = CKEDITOR.ENTER_P;
  // config.extraPlugins = 'linkbutton,linkembed';
  config.extraPlugins = 'linkbutton,linkembed,wordcount,notification';

  // config.toolbar = [
  //   { name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source'] },
  //   { name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
  //   { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
  //   { name: 'insert', items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
  //   { name: 'tools', items: ['ShowBlocks'] },
  //   '/',
  //   { name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
  //   { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
  //   '/',
  //   { name: 'styles', items: ['Styles', 'Format', 'FontSize'] },
  //   { name: 'colors', items: ['TextColor', 'BGColor'] },
  //   { name: 'others', items: ['linkbutton', '-', 'linkembed'] }
  // ];

  config.toolbar = [
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] }
    , { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
    , { name: 'styles', items: [ 'Format', 'FontSize' ] }
    , { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
    , { name: 'insert', items: [ 'Table' ] }
    , { name: 'clipboard', items: [ 'Undo', 'Redo'  ] }
    , { name: 'others', items: [ 'Link', 'Unlink', 'Source' ] }
    , { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
  ];

  config.wordcount = {

    // Whether or not you Show Remaining Count (if Maximum Word/Char/Paragraphs Count is set)
    showRemaining: false,

    // Whether or not you want to show the Paragraphs Count
    showParagraphs: false,

    // Whether or not you want to show the Word Count
    showWordCount: false,

    // Whether or not you want to show the Char Count
    showCharCount: true,

    // Whether or not you want to Count Bytes as Characters (needed for Multibyte languages such as Korean and Chinese)
    countBytesAsChars: false,

    // Whether or not you want to count Spaces as Chars
    countSpacesAsChars: false,

    // Whether or not to include Html chars in the Char Count
    countHTML: true,

    // Whether or not to include Line Breaks in the Char Count
    countLineBreaks: false,

    // Whether or not to prevent entering new Content when limit is reached.
    hardLimit: true,

    // Whether or not to to Warn only When limit is reached. Otherwise content above the limit will be deleted on paste or entering
    warnOnLimitOnly: false,

    // Maximum allowed Word Count, -1 is default for unlimited
    maxWordCount: -1,

    // Maximum allowed Char Count, -1 is default for unlimited
    maxCharCount: 4000,

    // Maximum allowed Paragraphs Count, -1 is default for unlimited
    maxParagraphs: -1,

    // How long to show the 'paste' warning, 0 is default for not auto-closing the notification
    pasteWarningDuration: 0,

    // Add filter to add or remove element before counting (see CKEDITOR.htmlParser.filter), Default value : null (no filter)
    filter: new CKEDITOR.htmlParser.filter({
      elements: {
        div: function (element) {
          if (element.attributes.class == 'mediaembed') {
            return false;
          }
        }
      }
    })
  };

};

CKEDITOR.on("instanceReady", function(event) {
  event.editor.on("beforeCommandExec", function(event) {
    // Show the paste dialog for the paste buttons and right-click paste
    if (event.data.name == "paste") {
      event.editor._.forcePasteDialog = true;
    }
    // Don't show the paste dialog for Ctrl+Shift+V
    if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
      event.cancel();
    }
  })
});
