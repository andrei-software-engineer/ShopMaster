import $ from "jquery";
import generalTools from "./generalTools";
import baseClass from "./baseClass";

var PRODUCTVARFUNCT = function () {

  this.quantity = 1;

  // ============================================================================
  this.getPrice = function (obj) {
    var price = obj.attr("always");

    return true;
  };

};

var productVar = new PRODUCTVARFUNCT();

export default productVar;