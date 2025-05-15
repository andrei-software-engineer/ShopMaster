import $ from "jquery";
import { decode } from "punycode";
import axiosClass from "./axiosClass";
import baseClass from "./baseClass";

function processDataObject(obj, val) {
  var infoparser = obj.attr("data-infoparser");
  infoparser = infoparser != undefined ? JSON.parse(infoparser) : false;
  infoparser =
    val && infoparser && infoparser[val] != undefined ? infoparser[val] : false;

  var params = [
    "remove",
    "redirecturl",
    "updateurl",
    "href",
    "targetid",
    "toggleinfo",
    "hideinfo",
    "showinfo",
    "classshow",
    "classshide",
    "classinfo",
    "submit",
    "stopother",
    "click",
  ];

  var rez = {};
  for (var i in params) {
    var t = params[i];
    var tv = obj.attr("data-" + t);

    tv = tv != undefined ? tv : infoparser[t] != undefined ? infoparser[t] : tv;
    rez[t] = tv;
  }

  rez["specval"] = infoparser ? "" : val;
  return rez;
}

function customaction(obj, val, ischecked) {
  val = val != undefined ? val : "";

  var objParams = processDataObject(obj, val);

  // ---------------------------

  if (objParams.classinfo == undefined) var classobj = obj;
  else var classobj = $(objParams.classinfo);

  if (objParams.remove != undefined) {
    $(objParams.remove).remove();
  }

  if (objParams.redirecturl != undefined) {
    objParams.redirecturl += objParams.specval;
    window.location.href = objParams.redirecturl;
  }

  if (objParams.updateurl != undefined) {
    objParams.updateurl += objParams.specval;
    axiosClass.updateElements(objParams.updateurl);
  }

  if (objParams.href != undefined) {
    baseClass.loadDataAjax(obj, objParams);
    axiosClass.updateElements(objParams.updateurl);
  }

  if (objParams.toggleinfo != undefined) {
    $(objParams.toggleinfo + objParams.specval).each(function () {
      $(this).toggle();
      if (objParams.classshow != undefined) {
        if ($(this).is(":visible")) classobj.addClass(objParams.classshow);
        else classobj.removeClass(objParams.classshow);
      }
      if (objParams.classshide != undefined) {
        if ($(this).is(":hidden")) classobj.addClass(objParams.classshide);
        else classobj.removeClass(objParams.classshide);
      }
    });
  }

  if (objParams.hideinfo != undefined) {
    $(objParams.hideinfo + objParams.specval).each(function () {
      $(this).hide();
    });
  }

  if (objParams.showinfo != undefined) {
    $(objParams.showinfo + objParams.specval).each(function () {
      $(this).show();
    });
  }

  if (objParams.submit != undefined) {
    $(objParams.submit + objParams.specval).each(function () {
      $(this).submit();
    });
  }

  if (objParams.click != undefined) {
    $(objParams.click + objParams.specval).each(function () {
      $(this).click();
    });
  }
}

function getCheckedValue(obj, defaultValue) {
  if (defaultValue == undefined) defaultValue = 1;

  var tval = obj.attr("data-checked");
  if (tval != undefined) return tval;

  tval = obj.val();
  if (tval != undefined) return tval;

  return defaultValue;
}

function getUnCheckedValue(obj, defaultValue) {
  if (defaultValue == undefined) defaultValue = 0;

  var tval = obj.attr("data-unchecked");
  if (tval != undefined) return tval;

  tval = obj.val();
  if (tval != undefined) return tval;

  return defaultValue;
}

function set_jsmover(obj, isshow) {
  if (isshow == undefined) isshow = true;

  var toggleinfo = obj.attr("data-toggleinfo");
  var showinfo = obj.attr("data-showinfo");
  var hideinfo = obj.attr("data-hideinfo");
  var classinfo = obj.attr("data-classinfo");
  var parent = obj.attr("data-parent");

  if (isshow) {
    obj.addClass("js_mover");
    if (toggleinfo != undefined) $(toggleinfo).addClass("js_mover");
    if (showinfo != undefined) $(showinfo).addClass("js_mover");
    if (hideinfo != undefined) $(hideinfo).addClass("js_mover");
    if (classinfo != undefined) $(classinfo).addClass("js_mover");
    if (parent != undefined) $(parent).addClass("js_mover");
  } else {
    obj.removeClass("js_mover");
    if (toggleinfo != undefined) $(toggleinfo).removeClass("js_mover");
    if (showinfo != undefined) $(showinfo).removeClass("js_mover");
    if (hideinfo != undefined) $(hideinfo).removeClass("js_mover");
    if (classinfo != undefined) $(classinfo).removeClass("js_mover");
    if (parent != undefined) $(parent).removeClass("js_mover");
  }
}

// =============================================

baseClass.OnReadyArrAdd(function () {
  $(".js_CA_select").each(function () {
    if ($(this).hasClass("true_js_CA_select")) return;
    var obj = $(this);
    obj.addClass("true_js_CA_select");

    var oneach = obj.attr("data-oneach");

    if (oneach != undefined) {
      var useSelected = $(this).attr("data-useselected");
      var selected = $(this).find(":selected");
      var tval = selected.val();
      if (useSelected != undefined && useSelected) {
        customaction(selected, tval);
      } else {
        customaction($(this), tval);
      }
    }

    obj.unbind("change").change(function () {
      var useSelected = $(this).attr("data-useselected");
      var selected = $(this).find(":selected");
      var tval = selected.val();
      if (useSelected != undefined && useSelected) {
        customaction(selected, tval);
      } else {
        customaction($(this), tval);
      }
    });
  });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_CA_checkbox").each(function () {
    if ($(this).hasClass("true_js_CA_checkbox")) return;
    var obj = $(this);
    obj.addClass("true_js_CA_checkbox");

    var oneach = obj.attr("data-oneach");

    if (oneach != undefined) {
      var tischecked = obj.is(":checked");
      var tval = tischecked ? getCheckedValue(obj) : getUnCheckedValue(obj);
      customaction(obj, tval, tischecked);
    }

    obj.unbind("change").change(function () {
      var tischecked = $(this).is(":checked");
      var tval = tischecked ? getCheckedValue(obj) : getUnCheckedValue(obj);
      customaction($(this), tval, tischecked);
    });
  });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_CA_click")
    .unbind("click")
    .click(function (e) {
      console.log("sd");
      var sp = $(this).attr("data-stopp");
      if (sp != undefined && sp == "1") e.stopPropagation();

      customaction($(this));
    })
    .unbind("mouseenter")
    .mouseenter(function () {
      set_jsmover($(this));
    })
    .unbind("mouseleave")
    .mouseleave(function () {
      set_jsmover($(this), false);
    });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_CA_enter").keyup(function (e) {
    if (e.keyCode == 13) {
      customaction($(this));
    }
  });
});

