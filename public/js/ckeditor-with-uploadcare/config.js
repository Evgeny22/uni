/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.skin = 'bootstrapck';
    config.removePlugins = 'autosave,bidi,find,flash,forms,newpage,templates,sourcearea,save,preview,print,copyformatting,removeformat,blockquote,div,language,magicline,pagebreak,table,tabletools,tableselection,horizontalrule,htmlwriter,iframe,font,format,stylescombo,a11yhelp,entities,showblocks,showborders,resize,wsc,videodetector,maximize,specialchar,dialogadvtab,gg,wordcount';
    config.scayt_autoStartup = true;
    config.height = '150px';
    config.toolbar = [
        ['Bold','Italic','Underline','-','NumberedList','BulletedList','-','Link','Smiley']
    ];
};
