import $ from "jquery";
import baseClass from "./baseClass";

baseClass.OnReadyArrAdd(function () {
  $(".js_al")
    .unbind("click")
    .click(function (e) {
      baseClass.loadDataAjax($(this));
      return false;
    });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_all")
    .unbind("click")
    .click(function (e) {
      baseClass.loadDataAjax($(this));
      return false;
    });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_alhl")
    .unbind("click")
    .click(function (e) {
      baseClass.loadDataAjaxHistory($(this));
      return false;
    });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_al_h")
    .unbind("click")
    .click(function (e) {
      var targetid = $(this).attr("data-targetid");
      var showclass = $(this).attr("data-showclass");
      var hideclass = $(this).attr("data-hideclass");

      var isloaded = $(this).attr("data-isloaded");
      if (isloaded != undefined && isloaded == "1") {
        if ($("#" + targetid).is(":visible")) {
          if (showclass != undefined) {
            $(this).removeClass(showclass);
          }
          if (hideclass != undefined) {
            $(this).addClass(hideclass);
          }
          $("#" + targetid).hide();
        } else {
          if (showclass != undefined) {
            $(this).addClass(showclass);
          }
          if (hideclass != undefined) {
            $(this).removeClass(hideclass);
          }
          $("#" + targetid).show();
        }
        return false;
      }

      $(this).attr("data-isloaded", '1');
      if (showclass != undefined) {
        $(this).addClass(showclass);
      }
      if (hideclass != undefined) {
        $(this).removeClass(hideclass);
      }
      $("#" + targetid).show();

      baseClass.loadDataAjax($(this));
      return false;
    });
});

