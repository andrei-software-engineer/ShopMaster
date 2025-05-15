

import $ from "jquery";

import baseClass from "./baseClass";

window.addEventListener("popstate", function () {
  baseClass.processPopState();
});

$(document).ready(function () {
  baseClass.OnLoadAll();
  baseClass.OnReadyAll();

});

document.addEventListener("turbo:load", () => {
  baseClass.OnLoadAll();
  baseClass.OnReadyAll();

});