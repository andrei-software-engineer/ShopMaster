CKEDITOR.editorConfig = function( config )
{
    config.language = 'en';
    config.height = '100';
    config.indent = false;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.breakAfterOpen = false
    config.resize_enabled = false;
    config.htmlEncodeOutput = false;
//    config.filebrowserUploadUrl = '/files/uploadfromCK?&rt=ajax';
//	config.filebrowserUploadMethod = 'form';
//	config.removePlugins = 'elementspath';
	config.removePlugins = 'toolbar,elementspath';
//	config.contentsCss = '/libs/ckeditor/customcss/customuser.minAsist.css';
//    config.toolbar = [
//                   	/*['Source','-', 'Save','NewPage','Preview','-', 'Templates'],*/
//                 	/*['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],*/
//                 	/*['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],*/
//                 	/*
//					 * [ 
//                	 * 'Form', 'Checkbox',
//                	 * 'Radio', 'TextField',
//                	 * 'Textarea', 'Select',
//                	 * 'Button',
//                	 * 'HiddenField'
//					 * ],
//                	 */
//                 	/*'/',*/
//                 	/*['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],*/
//                 	/*['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],*/
//                 	/*['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], */
//                 	/*['ImageButton','Link','Unlink','Anchor'],*/
//                 	/*[ 'Image', 'Flash', 'Table','HorizontalRule','Smiley','SpecialChar' ,'PageBreak' ],*/
//                 	/*'/',*/
//                 	/*['Styles','Format','Font','FontSize'],*/
//                 	/*['TextColor','BGColor'],
//                 	['Maximize', 'ShowBlocks' ,'-','About' ]*/
//                ];
	config.allowedContent = true;
    config.extraAllowedContent = 'style;*[id,rel](*){*};img[src,alt,width,height]';//
    config.removeFormatAttributes = '';
};