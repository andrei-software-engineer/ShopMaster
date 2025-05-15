import $ from "jquery";
import baseClass from "../base/baseClass";

var ANIMFADECOMPLEX = function () {
  // ------------------------------------
  this.delayss = 8000;
  this.timetransition = 1000;
  this.timefadein = 1000;
  this.timefadeout = 1000;

  // ------------------------------------
  this.moveleft = function (obj, force, index) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    if (force == undefined) force = false;
    var play = parseInt(containerobj.attr("play"));
    if (!play && !force) return;

    if (containerobj.find(".js_animobj").length <= 1) return;

    // -----------------------------------
    containerobj.find(".js_animobj").stop();
    this.updatetonext(obj);
    this.setcurrentslideposition(obj);
    // -----------------------------------
    if (index == undefined || parseInt(index) == -1) {
      this.setnextleft(obj);
    } else {
      if (parseInt(containerobj.attr("current")) == parseInt(index)) return;
      containerobj.attr("n", index);
    }
    // -----------------------------------

    var current = containerobj.attr("current");
    var n = containerobj.attr("n");

    if (n == -1) return;
    // -----------------------------------
    if (current == n) current = -1;

    this.startanimations(obj, current, n);
  };

  // ------------------------------------
  this.moveright = function (obj, force, index) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    if (force == undefined) force = false;
    var play = parseInt(containerobj.attr("play"));
    if (!play && !force) return;

    if (containerobj.find(".js_animobj").length <= 1) return;

    // -----------------------------------
    containerobj.find(".js_animobj").stop();
    this.updatetonext(obj);
    this.setcurrentslideposition(obj);
    // -----------------------------------
    if (index == undefined || parseInt(index) == -1) {
      this.setnextright(obj);
    } else {
      if (parseInt(containerobj.attr("current")) == parseInt(index)) return;
      containerobj.attr("n", index);
    }
    // -----------------------------------

    var current = containerobj.attr("current");
    var n = containerobj.attr("n");

    if (n == -1) return;
    // -----------------------------------

    if (current == n) current = -1;

    this.startanimations(obj, current, n);
  };

  // ------------------------------------
  this.startanimations = function (obj, current, n) {
    if (current == n || current == -1 || n == -1) return;

    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    var currentobj = containerobj.find(".js_animobj").eq(current);
    var nextobj = containerobj.find(".js_animobj").eq(n);

    currentobj.css("display", ""); // --------------------
    currentobj.find(".js_showfade").css("display", ""); // --------------------
    currentobj.find(".js_showfade").fadeTo(animfadecompl.timefadeout, 0);
    currentobj.fadeTo(animfadecompl.timetransition, 0);
    nextobj.fadeTo(animfadecompl.timetransition, 1, function () {
      animfadecompl.finishtransition(obj);
    });
  };

  // ------------------------------------
  this.finishtransition = function (obj) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    containerobj.find(".js_animobj").stop();
    this.updatetonext(obj);
    this.setcurrentslideposition(obj);

    var play = parseInt(containerobj.attr("play"));
    if (!play) return;

    var direction = containerobj.attr("direction");

    var delay = parseInt(obj.attr("delay"));
    if (delay == undefined || isNaN(delay) || !delay) delay = this.delayss;

    if (direction == "toleft") {
      var timeout = setTimeout(function () {
        animfadecompl.moveleft(obj);
      }, delay);
    } else {
      var timeout = setTimeout(function () {
        animfadecompl.moveright(obj);
      }, delay);
    }
  };

  // ------------------------------------
  this.setfirst = function (obj) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    containerobj.attr("current", "0");
    this.setcurrentslideposition(obj, true);
  };

  // ------------------------------------
  this.updatetonext = function (obj) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    var n = parseInt(containerobj.attr("n"));
    if (n == -1) return;

    containerobj.attr("current", containerobj.attr("n"));

    containerobj.attr("n", "-1");
  };

  // ------------------------------------
  this.setnextleft = function (obj) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    var current = parseInt(containerobj.attr("current"));

    var totalobj = containerobj.find(".js_animobj").length;
    totalobj--;

    var n = -1;

    if (totalobj >= 2) {
      if (current < totalobj) n = current + 1;
      else n = 0;
    } else {
      if (current == 0) {
        n = 1;
      } else {
        n = 0;
      }
    }

    containerobj.attr("n", n);
  };

  // ------------------------------------
  this.setnextright = function (obj) {
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    var current = parseInt(containerobj.attr("current"));

    var totalobj = containerobj.find(".js_animobj").length;
    totalobj--;

    var n = -1;

    if (totalobj >= 2) {
      if (current > 0) n = current - 1;
      else n = totalobj;
    } else {
      if (current == 0) {
        n = 1;
      } else {
        n = 0;
      }
    }

    containerobj.attr("n", n);
  };

  // ------------------------------------
  this.setcurrentslideposition = function (obj, isfirst) {
    if (isfirst == undefined) isfirst = false;
    var containerobj = this.getcontainerobj(obj);
    // -----------------------------------------
    var current = parseInt(containerobj.attr("current"));

    var currentobj = containerobj.find(".js_animobj").eq(current);
    var otherobjects = containerobj
      .find(".js_animobj")
      .not(":eq(" + current + ")");

    currentobj.css("opacity", 1);
    otherobjects.each(function () {
      $(this).find(".js_showfade").css("opacity", 0);
      $(this).css("opacity", 0);
      $(this).find(".js_showfade").css("display", "none"); // -----------
      $(this).css("display", "none"); // -----------
    });

    if (!isfirst) {
      currentobj.find(".js_showfade").each(function () {
        $(this).fadeTo(animfadecompl.timefadein, 1);
      });
    } else {
      currentobj.find(".js_showfade").css("opacity", 1);
    }

    // ------------------------------------------------
    var buttonsobj = obj.find(".js_animbuttons");
    if (buttonsobj != undefined) {
      buttonsobj
        .find(".js_button")
        .not(":eq(" + current + ")")
        .each(function () {
          $(this).find(".js_button_select").hide();
          $(this).find(".js_button_simple").show();
        });
      buttonsobj.find(".js_button:eq(" + current + ")").each(function () {
        $(this).find(".js_button_simple").hide();
        $(this).find(".js_button_select").show();
      });
    }
  };

  // ------------------------------------
  this.getcontainerobj = function (obj) {
    var containerobj = obj.find(".js_animcontainer").first();
    return containerobj;
  };

  // ------------------------------------
};

var animfadecompl = new ANIMFADECOMPLEX();

export default animfadecompl;

