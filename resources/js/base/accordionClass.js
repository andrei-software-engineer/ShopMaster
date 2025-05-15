import $ from "jquery";
import baseClass from "./baseClass";

var ACCORDIONCLASS = function () {
  this.delay = 300;

  // ============================================================================
  this.process = function (obj) {
    if (this.inTransition(obj)) return;

    if (this.isOpened(obj)) return this.hideObject(obj);
    return this.showObject(obj);
  };

  // ============================================================================
  this.inTransition = function (obj) {
    let t = obj.attr("data-intransition");
    if (t == "1") return true;
    return false;
  };

  // ============================================================================
  this.isOpened = function (obj) {
    let state = obj.attr("data-state");
    if (state == "0" || state == undefined) return false;
    return true;
  };

  // ============================================================================
  this.getDelay = function (obj) {
    let d = obj.attr("data-delay");
    if (d == undefined) d = this.delay;
    d = parseInt(d);
    if (isNaN(d)) d = this.delay;
    return d;
  };

  // ============================================================================
  this.showObject = function (obj) {
    let containerid = obj.attr("data-containerid");
    var tobj = $("#" + containerid);
    var initHeight = tobj.attr("data-initheight");

    obj.attr("data-intransition", "1");

    tobj.animate(
      { height: initHeight + "px" },
      accordionClass.getDelay(obj),
      "linear",
      function () {
        accordionClass.finishAnimate(obj, true);
      }
    );

    this.hideOther(obj);
  };

  // ============================================================================
  this.hideOther = function (obj) {
    let usesingle = obj.attr("data-usesingle");
    let prefixbtid = obj.attr("data-prefixbtid");
    let id = obj.attr("id");

    if (usesingle != undefined && usesingle) return;

    $('[id^=' + prefixbtid + ']:not(#' + id + ')').each(function () { 
      accordionClass.hideObject($(this));
    });
  };

  // ============================================================================
  this.hideObject = function (obj) {
    let containerid = obj.attr("data-containerid");
    var tobj = $("#" + containerid);

    obj.attr("data-intransition", "1");

    tobj.animate(
      { height: "0px" },
      accordionClass.getDelay(obj),
      "linear",
      function () {
        accordionClass.finishAnimate(obj);
      }
    );
  };

  // ============================================================================
  this.finishAnimate = function (obj, isShow) {
    isShow = isShow == undefined ? false : isShow;

    let classshow = obj.attr("data-classshow");
    let classhide = obj.attr("data-classhide");

    obj.attr("data-intransition", "0");

    if (isShow) {
      obj.attr("data-state", 1);
      if (classshow != undefined) {
        obj.addClass(classshow);
      }
      if (classhide != undefined) {
        obj.removeClass(classhide);
      }
    } else {
      obj.attr("data-state", 0);
      if (classshow != undefined) {
        obj.removeClass(classshow);
      }
      if (classhide != undefined) {
        obj.addClass(classhide);
      }
    }
  };
};

var accordionClass = new ACCORDIONCLASS();

baseClass.OnReadyArrAdd(function () {
  $(".js_accordion").click(function () {
    accordionClass.process($(this));

    return false;
  });

  $(".js_accordion").each(function () {
    if ($(this).hasClass("true_js_accordion")) return;
    var obj = $(this);
    obj.addClass("true_js_accordion");

    let containerid = $(this).attr("data-containerid");
    var tobj = $("#" + containerid);
    if (tobj == undefined) return;

    tobj.css("height", "auto");
    tobj.css("overflow", "auto");
    let initHeight = tobj.height();

    tobj.css("overflow", "hidden");
    tobj.css("height", "0px");
    tobj.attr("data-initheight", initHeight);
    obj.attr("data-state", 0);
  });
});

export default accordionClass;
