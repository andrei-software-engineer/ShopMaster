CKEDITOR.editorConfig = function( config )
{
    config.language = 'en';
    config.height = '100';
    config.width = '100%';
    config.indent = false;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.breakAfterOpen = false
    config.resize_enabled = false;
    config.htmlEncodeOutput = false;
	config.removePlugins = 'elementspath';
    config.toolbar = [['ParametersType']];
	config.extraPlugins = 'ParametersType';
	config.allowedContent = true;
    config.extraAllowedContent = 'style;*[id,rel](*){*};img[src,alt,width,height]';//
    config.removeFormatAttributes = '';
};