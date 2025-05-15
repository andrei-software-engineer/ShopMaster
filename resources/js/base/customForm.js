import $ from "jquery";
import ajaxSubmit from "jquery-form";
import ajaxForm from "jquery-form";

// import '../../libs/jquery/jquery.form.min';

import baseClass from "./baseClass";
import generalTools from "./generalTools";
  

var CUSTOMFORMVAR = function () {
  this.currentformid = "";

  // ============================================================================
  this.afterSuccesFormSubmit = function (res, status, xhr) {
    baseClass.processAjaxResultSuccessProcessCommands('', res, status, xhr);
    baseClass.OnReadyAll();
    baseClass.HideIsLoadingInProgress();
  };

  // ============================================================================
  this.manuallyBeforeFormSubmit = function (obj) {
  };
};

var customFormObj = new CUSTOMFORMVAR();

baseClass.OnReadyArrAdd(function () {
  
  $(".js_af")
    .submit(function () {      
      customFormObj.currentformid = $(this).attr("id");
      
      var valfunc = $(this).attr("data-valfunc");
      var aftfunc = $(this).attr("data-aftfunc");
      
      if (valfunc) if (!eval(valfunc)) return false;
      

      var loadind = $(this).attr("data-loadind");

      var targetid = $(this).attr("data-targetid");
      if (!targetid) targetid = "main";
      
      if (loadind == undefined) {
        baseClass.ShowIsLoadingInProgress();
      } else {
        if (loadind == "mini") baseClass.putloadinindicator(targetid);
      }
      
      var href = $(this).attr("action");
      
      var varResetForm = $(this).attr("data-resetForm");
      if (varResetForm) varResetForm = true;
      else varResetForm = false;
      
      if (href.indexOf("?") >= 0) href += "&rt=ajax";
      else href += "?rt=ajax";
      

      href = href.replace("/?", "?");
      var lastChar = href[href.length - 1];
      if (lastChar == "/") {
        href = href.substring(0, href.length - 1);
      }

      console.log(href);
      console.log(targetid);
      
      $(this).attr("action", href);
      $(this).attr("method", "post");
      $(this).attr("enctype", "multipart/form-data");
      
      customFormObj.manuallyBeforeFormSubmit($(this));

      var options = {
        url: href,
        target: '#' + targetid,
        beforeSubmit: customFormObj.beforeFormSubmit,
        success: customFormObj.afterSuccesFormSubmit,
        resetForm: varResetForm,
      };
      
      $(this).ajaxSubmit(options);
      
      return false;
    })
  ;


 $(".js_af").each(function () {
    if ($(this).hasClass("true_js_af")) return;
    var obj = $(this);
    obj.addClass("true_js_af");


    var currentformid = $(this).attr("id");
    if (currentformid == undefined)
    {
      currentformid = generalTools.uuidv4();
      obj.attr('id', currentformid);
    }

   ajaxForm($(this));

  });
});
