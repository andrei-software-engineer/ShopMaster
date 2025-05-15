import $ from "jquery";
import baseClass from "./baseClass";

var PRODUCTCLASS = function () {
  // ============================================================================
  this.quantityUp = function (idquantity) {
    var obj = $("#" + idquantity);
    var q = productClass.getQuantity(obj);
    console.log('aaaa',q);
    q = q + 1;
    console.log('bbbb',q);
    productClass.setQuantity(obj, q);
  };

  // ============================================================================
  this.quantityDown = function (idquantity) {
    var obj = $("#" + idquantity);
    var q = productClass.getQuantity(obj);

    q = q - 1;
    productClass.setQuantity(obj, q);
  };

  // ============================================================================
  this.getQuantity = function (obj) {
    var q = parseInt(obj.val());
    if (isNaN(q) || q < 1) q = 1;
    return q;
  };

  // ============================================================================
  this.setQuantity = function (obj, q) {
    if (q == undefined) q = obj.val();
    q = parseInt(q);
    if (isNaN(q) || q < 1) q = 1;

    let min = productClass.getMin(obj);

    let max = productClass.getMax(obj);

    if (q < min) q = min;
    if (max > 0 && q > max) q = max;

    obj.val(q);

    productClass.processPrice(obj);

    productClass.saveOnServerQuantity(obj);
  };

  // ============================================================================
  this.processPrice = function (obj) {
    var q = obj.val();
    q = obj.val();

    var price = productClass.getPrice(obj, q);
    var idproduct = obj.attr("data-idproduct");

    $("#productPriceDetail_" + idproduct).html(price.total_realprice);

  };

  // ============================================================================
  this.saveOnServerQuantity = function (obj) {
    
    var updatewcart = obj.attr("data-updatewcart");
    if(updatewcart != 1){
      return;
    }

    if (!$(obj).hasClass("true_processcartquantity")){
      obj.addClass("true_processcartquantity");
      return; 
    }

    var q = obj.val();

    var href = obj.attr("data-UpdateURL");
    if (!href) return;
    
    href += href.indexOf("?") != -1 ? "&" : "?";
    href += "&quantity=" + q;
    href += "&rt=ajax";

    var params = {};
    params.inBackGround = true;
    params.type = "ajaxHTML";
    params.href = href;
    params.url = href;

    params.targetid = "messageresult";
    params.stopother = 0;
    
    baseClass.getAjaxHTML(params);
  };

  // ============================================================================
  this.getMin = function (obj) {
    let min = parseInt(obj.attr("data-min"));
    if (isNaN(min)) min = 1;
    if (min < 1) min = 1;
    return min;
  };

  // ============================================================================
  this.getMax = function (obj) {
    let max = parseInt(obj.attr("data-max"));
    if (isNaN(max)) max = -1;
    if (max < 1) max = -1;
    return max;
  };

  // ============================================================================
  this.getPrice = function (obj, q) {
    var idproduct = obj.attr("data-idproduct");

    var offers = $("#offerList_" + idproduct);

    var rez = {};
    rez.price = 0;
    rez.tax = 0;
    rez.discount = 0;
    rez.realprice = 0;

    var exist = false;

    offers.find("tr").each(function () {
      if (exist) return;

      let min = productClass.getMin($(this));

      let max = productClass.getMax($(this));

      if (q < min) return;

      if (max > 0 && q > max) return;

      exist = true;

      var tobj = $(this).find("td").first();
      rez.price = parseFloat(tobj.attr("data-price"));
      rez.tax = parseFloat(tobj.attr("data-tax"));
      rez.discount = parseFloat(tobj.attr("data-discount"));
      rez.realprice = parseFloat(tobj.attr("data-realprice"));
    });

    rez.total_price = Math.round(rez.price * q * 100) / 100;
    rez.total_tax = Math.round(rez.tax * q * 100) / 100;
    rez.total_discount = Math.round(rez.discount * q * 100) / 100;
    rez.total_realprice = Math.round(rez.realprice * q * 100) / 100;

    return rez;
  };

};

var productClass = new PRODUCTCLASS();

baseClass.OnReadyArrAdd(function () {
  $(".js_plus_btn").unbind('click').click(function () {
    let idquantity = $(this).attr("data-idquantity");
    productClass.quantityUp(idquantity);
    return false;
  });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_minus_btn")
    .unbind("click")
    .click(function () {
      let idquantity = $(this).attr("data-idquantity");
      productClass.quantityDown(idquantity);
      return false;
    });
});

baseClass.OnReadyArrAdd(function () {
  $(".js_product_quantity").each(function () {
    if ($(this).hasClass("true_js_product_quantity")) return;
    $(this).addClass("true_js_product_quantity");

    var obj = $(this);

    productClass.setQuantity(obj);
  });
    
  $(".js_product_quantity")
    .unbind("focus")
    .focus(function () {
      productClass.setQuantity($(this));
    });
    
  $(".js_product_quantity")
    .unbind("blur")
    .blur(function () {
      productClass.setQuantity($(this));
    });
    
  $(".js_product_quantity")
    .unbind("keyup")
    .keyup(function () {
      productClass.setQuantity($(this));
    });
});

export default productClass;
