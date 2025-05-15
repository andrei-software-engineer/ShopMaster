import $ from "jquery";
import generalTools from "./generalTools";


// import jquery from "jquery";
// window.$ = window.jQuery = jquery

// var jQuery = $;
// jQuery = window.$ = window.jQuery = $;

// import "../../../node_modules/jquery-history/dist/jquery.history.min";

/// acum de facut history link
// acum trebuie de facut si la categoriii sa apara cu link  cu ajax

var BASECLASSFUNCT = function () {
  this.OnLoadArr = new Array();
  this.OnReadyArr = new Array();

  this.OnUnLoadArr = new Array();
  this.OnReadyEventsArr = new Array();
  this.CommandExecuters = new Array();
  this.loadedScripts = new Array();

  this.BeginedInSite = 1;
  this.siteStartLocation;
  this.targetid;
  this.currentformid = "";


  this.needtwocheck = false;

  // ============================================================================
  this.CommandExecuterAdd = function (com_name, func) {
    this.CommandExecuters[com_name] = func;
  };

  // ============================================================================
  this.loadScript = function (url) {
    var siteversion = generalTools.getSiteVersion();
    if (url.indexOf("?") >= 0) url += "&v=" + siteversion;
    else url += "?v=" + siteversion;

    for (var i in this.loadedScripts) {
      if (this.loadedScripts[i] == url) return true;
    }

    // set options
    var options = {
      dataType: "script",
      cache: true,
      url: url,
      async: false,
    };

    this.loadedScripts[this.loadedScripts.length + 1] = url;

    // Use $.ajax() since it is more flexible than $.getScript
    // Return the jqXHR object so we can chain callbacks
    $.ajax(options);
    return true;
  };

  // ============================================================================
  this.isforalways = function (obj) {
    var always = obj.attr("always");
    if (always == undefined) return false;
    if (always != "1") return false;
    return true;
  };
  // ============================================================================
  this.OnLoadArrAdd = function (func) {
    this.OnLoadArr[this.OnLoadArr.length + 1] = func;
  };

  // ============================================================================
  this.OnLoadAll = function () {
    for (var i in this.OnLoadArr) this.OnLoadArr[i]();
  };

  // ============================================================================
  this.OnReadyArrAdd = function (func) {
    this.OnReadyArr[this.OnReadyArr.length + 1] = func;
  };

  // ============================================================================
  this.OnReadyAll = function () {
    for (var i in this.OnReadyArr) this.OnReadyArr[i]();
  };

  // ============================================================================
  this.ParseForAjax = function (obj, type, objParams) {
    objParams = objParams == undefined ? false : objParams;

    type = type != undefined ? type : "ajaxHTML";
    var rez = {};

    rez.type = type;

    var href = obj.attr("href");
    if (!href || href == undefined) href = obj.attr("href");
    if (!href || href == undefined) href = obj.attr("data-href");

    if (
      (!href || href == undefined) &&
      objParams &&
      objParams.href != undefined
    )
      href = objParams.href;

    if (!href || href == undefined) return false;

    var url = href;
    url += url.indexOf("?") != -1 ? "&" : "?";
    url += "rt=ajax";

    rez.href = href;
    rez.url = url;

    rez.targetid = obj.attr("data-targetid");
    if (
      (!rez.targetid || rez.targetid == undefined) &&
      objParams &&
      objParams.targetid != undefined
    )
      rez.targetid = objParams.targetid;
    if (!rez.targetid || rez.targetid == undefined) rez.targetid = "main";

    rez.stopother = obj.attr("data-stopother");
    if (
      (!rez.stopother || rez.stopother == undefined) &&
      objParams &&
      objParams.stopother != undefined
    )
      rez.stopother = objParams.stopother;
    if (!rez.stopother || rez.stopother == undefined) rez.stopother = 0;

    return rez;
  };

  // ============================================================================
  this.loadDataAjax = function (obj, objParams) {

    var info = this.ParseForAjax(obj, "ajaxHTML", objParams);
    if (!info) return false;

    return this.getAjaxHTML(info);
  };

  // ============================================================================
  this.processPopState = function () {
    console.log("ssxxxxxx");
    console.log(history.state);
    console.log(window.location);

    if (!history.state) {
      window.location = window.location;
      return;
    }

    var info = history.state;
    info._notPushState = 1;

    return this.getAjaxHTML(info);
  };

  // ============================================================================
  this.loadDataAjaxHistory = function (obj) {
    var info = this.ParseForAjax(obj, "ajaxHistory");
    if (!info) return false;
    info.showLoading = true;

    return this.getAjaxHTML(info);
  };

  // ============================================================================
  this.processAjaxResultSuccessProcessCommands = function (
    data,
    info,
    status,
    xhr
  ) {
    var commands = xhr.getResponseHeader("commands");
    if (!commands) return;

    try {
      commands = JSON.parse(commands);
    } catch (e) {
      return;
    }

    for (var i in commands) {
      try {
        var c = commands[i];
        if (this.CommandExecuters[c.name] != undefined) {
          this.CommandExecuters[c.name](c);
        }
      } catch (e) { }
    }
  };

  // ============================================================================
  this.processAjaxResultSuccessProcessMeta = function (
    data,
    info,
    status,
    xhr
  ) {
    var metaInfo = xhr.getResponseHeader("metaInfo");
    if (!metaInfo) return;

    try {
      metaInfo = JSON.parse(metaInfo);
    } catch (e) {
      return;
    }

    if (metaInfo.title != undefined) {
      $("title").html(metaInfo.title);
      $('meta[name="DC.Title"]').attr("content", metaInfo.title);
      $('meta[property="og:title"]').attr("content", metaInfo.title);
      $('meta[property="twitter:title"]').attr("content", metaInfo.title);
    }

    if (metaInfo.metaKeyWords != undefined) {
      $('meta[name="keywords"]').attr("content", metaInfo.metaKeyWords);
    }

    if (metaInfo.metaDescription != undefined) {
      $('meta[name="description"]').attr("content", metaInfo.metaDescription);
      $('meta[property="og:description"]').attr(
        "content",
        metaInfo.metaDescription
      );
      $('meta[property="twitter:description"]').attr(
        "content",
        metaInfo.metaDescription
      );
    }

    if (metaInfo.metaImage != undefined) {
      $('meta[property="og:image"]').attr("content", metaInfo.metaImage);
      $('meta[property="twitter:image"]').attr("content", metaInfo.metaImage);
    }

    if (metaInfo.metaAuthor != undefined) {
      $('meta[name="author"]').attr("content", metaInfo.metaAuthor);
    }

    if (metaInfo.canonical != undefined) {
      $('link[rel="canonical"]').attr("href", metaInfo.canonical);
      $('meta[property="og:url"]').attr("content", metaInfo.canonical);
      $('meta[property="twitter:url"]').attr("content", metaInfo.canonical);
    }
  };

  // ============================================================================
  this.processAjaxResultSuccessProcessHistory = function (data, info) {
    if (info.type == "ajaxHistory" && !info._notPushState) {
      var title = "";
      history.pushState(info, title, info.href);
    }
  };

  // ============================================================================
  this.processAjaxResultSuccessProcessContent = function (data, info) {
    // console.log('data');
    // console.log(data);
    if (info.type == "ajaxHTML" || info.type == "ajaxHistory") {
      $("#" + info.targetid).html(data);
    }
  };
  // ============================================================================
  this.processAjaxResultSuccessProcessFinish = function (data, info) {
    this.OnReadyAll();

    this.HideIsLoadingInProgress();
    // se cheama stopul
  };

  // ============================================================================
  this.processAjaxResultSuccess = function (data, info, status, xhr) {
    this.processAjaxResultSuccessProcessMeta(data, info, status, xhr);
    this.processAjaxResultSuccessProcessHistory(data, info);
    this.processAjaxResultSuccessProcessContent(data, info);
    this.processAjaxResultSuccessProcessCommands(data, info, status, xhr);
    this.processAjaxResultSuccessProcessFinish(data, info);
  };

  // ============================================================================
  this.processAjaxResultError = function (data, info) {
    this.processAjaxResultSuccessProcessFinish(data, info);
  };

  // ============================================================================
  this.getAjaxHTML = function (info) {
    // se cheama afisre loading ca inof
    if (info.inBackGround == undefined) {
      this.ShowIsLoadingInProgress();
    }
    $.ajax({
      url: info.url,
      method: "get",
      dataType: "html",
      success: function (data, status, xhr) {
        baseClass.processAjaxResultSuccess(data, info, status, xhr);
      },
      error: function (data, status, xhr) {
        baseClass.processAjaxResultError(data, info, status, xhr);
      },
    });
  };

  // ============================================================================
  // ============================================================================
  // ============================================================================

  // ============================================================================
  this.OnReadyEventsAll = function (data, hideloading, targetid, allsite) {
    // -----------------------------------------------
    if (targetid == undefined) targetid = false;
    if (allsite == undefined) allsite = false;

    if (targetid && !allsite) {
      var findobj = $("#" + targetid);
    } else {
      var findobj = $("html");
    }
    // -----------------------------------------------

    this.needtwocheck = false;

    if (hideloading == undefined) hideloading = true;
    if (hideloading && data) {
      if (data != undefined && data && $(data).find(".js_nothideload").length) {
        hideloading = false;
      }
    }

    this.execreadall(data, findobj);

    if (this.needtwocheck)
      setTimeout(function () {
        this.execreadall(data, findobj);
      }, 50);

    if (!this.BeginedInSite && hideloading) this.HideIsLoadingInProgress();

    this.needtwocheck = false;
  };

  // ============================================================================
  this.execreadall = function (htmldata, findobj, afterfunction) {
    if (findobj == undefined) return;
    for (var i in this.OnReadyEventsArr) {
      try {
        this.OnReadyEventsArr[i](htmldata, findobj);
      } catch (e) {
        console.log(e);
      }
    }

    if (afterfunction != undefined) {
      try {
        afterfunction();
      } catch (e) {
        console.log(e);
      }
    }
  };

  // ============================================================================
  this.ShowIsLoadingInProgress = function () {
    var obj = $("#loadingind");
    //	if (obj) obj.show();
    if (obj && obj != undefined) obj.show();
  };

  // ============================================================================
  this.HideIsLoadingInProgress = function () {
    var obj = $("#loadingind");
    //	if (obj) obj.hide();
    obj.hide();
  };

  // ============================================================================
  this.putloadinindicator = function (targetid) {
    var obj = $("#loadingind-mini");
    if (obj != undefined) {
      var newobj = obj.clone();
      newobj.attr("id", "");
      newobj.show();
      $("#" + targetid).html(newobj);
    }
  };

  // ============================================================================
  this.manuallyBeforeFormSubmit = function (obj) {
    try {
      // CKEDITOR - updateElement
      //	for(var i in CKEDITOR.instances) 
      //	{
      //		CKEDITOR.instances[i].updateElement();
      //	}
      obj.find('[class^="jsCkeditor"]').each(function () {
        var id = $(this).attr('id');
        var instance = CKEDITOR.instances[id];
        if (instance) {
          CKEDITOR.instances[id].updateElement();
        }
      });

      ajaxrequest.abandoneall();
    } catch (e) { }


    // -----------------------
    var hascutomcheckbox = obj.attr('hascutomcheckbox');
    var customcheckboxobjects = obj.attr('customcheckboxobjects');
    var cutomcheckboxname = obj.attr('cutomcheckboxname');

    if (hascutomcheckbox == '1') {
      $(customcheckboxobjects + ':checked').each(function () {
        obj.append('<input type="hidden" name="' + cutomcheckboxname + '" value="' + $(this).val() + '" /> ');
      });
    }
    // -----------------------
  };

  // ============================================================================
};

var baseClass = new BASECLASSFUNCT();

export default baseClass;
