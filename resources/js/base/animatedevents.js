import $ from "jquery";
import baseClass from "./baseClass";
import animfadecompl from "../animated/animfadecomplex";

baseClass.OnReadyArrAdd(function () {
  $(".js_animfadecomplex").each(function () {
    if ($(this).hasClass("true")) return;
    $(this).addClass("true");

    var obj = $(this);
    if (!obj.find(".js_animobj").length) return;

    var delay = parseInt(obj.attr("delay"));
    if (!isNaN(delay) && delay) animfadecompl.delayss = delay;
    if (delay == undefined || isNaN(delay) || !delay)
      delay = animfadecompl.delayss;

    var containerobj = obj.find(".js_animcontainer");

    var play = containerobj.attr("play");
    if (play == undefined) containerobj.attr("play", "1");

    obj.find(".js_gotoleft").each(function () {
      $(this).css("cursor", "pointer");
    });
    obj.find(".js_gotoright").each(function () {
      $(this).css("cursor", "pointer");
    });

    obj
      .find(".js_gotoleft")
      .unbind("click")
      .click(function () {
        containerobj.attr("play", "0");
        animfadecompl.moveright(obj, true);
      });

    obj
      .find(".js_gotoright")
      .unbind("click")
      .click(function () {
        containerobj.attr("play", "0");
        animfadecompl.moveleft(obj, true);
      });

    animfadecompl.setfirst(obj);
    var buttonsobj = obj.find(".js_animbuttons");

    if (containerobj.find(".js_animobj").length <= 1) {
      obj.find(".js_gotoright").hide();
      obj.find(".js_gotoleft").hide();
      if (buttonsobj != undefined) {
        buttonsobj.find(".js_button").hide();
      }
      return;
    }

    var direction = "toleft";
    containerobj.attr("direction", direction);

    if (direction == "toleft") {
      var timeout = setTimeout(function () {
        animfadecompl.moveleft(obj);
      }, delay);
    } else {
      var timeout = setTimeout(function () {
        animfadecompl.moveright(obj);
      }, delay);
    }

    if (buttonsobj != undefined) {
      buttonsobj.find(".js_button").each(function () {
        $(this).css("cursor", "pointer");
      });

      obj
        .find(".js_button")
        .unbind("click")
        .click(function () {
          containerobj.attr("play", "0");
          var index = $(this).attr("index");
          var current = containerobj.attr("current");

          animfadecompl.moveleft(obj, true, index);
        });
    }
  });
});
