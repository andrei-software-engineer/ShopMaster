import $ from "jquery";
import baseClass from "../base/baseClass";
import generalTools from "../base/generalTools";

function SET_CKEDITOR(obj, fileconfig) {
  if (obj.hasClass("true")) return;
  obj.addClass("true");

  var id = obj.attr("id");
  if (id == undefined) {
    id = "id_" + generalTools.uuidv4();
    obj.attr("id", id);
  }

  var siteversion = generalTools.getSiteVersion();

  window.CKEDITOR_BASEPATH = "/libs/ckeditor/";
  baseClass.loadScript("/libs/ckeditor/ckeditor.js");
  CKEDITOR.timestamp = siteversion;

  try {
    var instance = CKEDITOR.instances[id];
    if (instance) {
      CKEDITOR.remove(CKEDITOR.instances[id]);
    }
    CKEDITOR.replace(id, {
      customConfig: "/scripts/ckeditor/" + fileconfig + ".js",
    });
  } catch (e) {
    console.log(e);
  }
}

baseClass.OnReadyArrAdd(function () {
    $(".jsCkeditor").each(function () {
      SET_CKEDITOR($(this), "editor.config");
  });
});

baseClass.OnReadyArrAdd(function () {
    $(".jsCkeditor_OnlyParameters").each(function () {
      SET_CKEDITOR($(this), "editoronlyparameters.config");
    });
});

baseClass.OnReadyArrAdd(function () {
    $(".jsCkeditorUser").each(function () {
      SET_CKEDITOR($(this), "editorUser.config");
    });
});

baseClass.OnReadyArrAdd(function () {
    $(".jsCkeditor_Parameters").each(function () {
      SET_CKEDITOR($(this), "editorparameters.config");
    });
});
