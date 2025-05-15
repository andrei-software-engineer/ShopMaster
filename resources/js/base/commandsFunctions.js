

import $ from "jquery";

import baseClass from "./baseClass";


baseClass.CommandExecuterAdd("jscChangeHTML", function (obj) {
  try {
    let selector = obj.selector;
    let html = obj.html;
    console.log(html);
    $(selector).html(html);
  } catch (e) {
    console.log("err: jscChangeHTML");
  }
});

baseClass.CommandExecuterAdd("jscAddClass", function (obj) {
  // console.log('jscAddClass', obj);
  try {
    let selector = obj.selector;
    let _class = obj.class;
    $(selector).addClass(_class);
  } catch (e) {
    console.log("err: jscAddClass");
  }
});

baseClass.CommandExecuterAdd("jscRemClass", function (obj) {
  // console.log("jscRemClass", obj);
  try {
    let selector = obj.selector;
    let _class = obj.class;
    $(selector).removeClass(_class);
  } catch (e) {
    console.log("err: jscRemClass");
  }
});


baseClass.CommandExecuterAdd("jscRemove", function (obj) {
  // console.log("jscRemove", obj);
  try {
    let selector = obj.selector;
    $(selector).remove();
  } catch (e) {
    console.log("err: jscRemove");
  }
});

baseClass.CommandExecuterAdd("jscChangeBrowserLocation", function (obj) {
  // console.log("jscChangeBrowserLocation", obj);
  try {

    let href = obj.href;
    history.pushState({}, null, href);
    
  } catch (e) {
    console.log("err: jscChangeBrowserLocation");
  }
});