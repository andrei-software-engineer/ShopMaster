import $ from "jquery";

var GENERALTOOLSCLASSFUNCT = function () {
  // ============================================================================
  this.getSiteVersion = function () {
    let tobj = $("#__meta_version");
    if (tobj == undefined) return '1.0.0';
    return tobj.attr("content");
  };

  // ============================================================================
  this.updateElements = function (data) {
    if (data.vals != undefined) this.updateElementsVals(data.vals);
  };

  // ============================================================================
  this.updateElementsVals = function (data) {
    if (Array.isArray(data)) {
      for (var i in data) {
        this.updateElementsValsItem(data[i]);
      }
    } else {
      this.updateElementsValsItem(data);
    }
  };

  // ============================================================================
  this.updateElementsValsItem = function (data) {
    if (data.selected == undefined) return;
    if (!data.selected) return;
    if (data.selected == null) return;

    var value = "";
    if (data.value != undefined && data.value != null) value = data.value;

    if (!$(data.selected).length) return;

    if ($(data.selected).prop("tagName").toLowerCase() == 'input')
    {
      $(data.selected).val(value);
      return;
    }

    
    if ($(data.selected).prop("tagName").toLowerCase() == "textarea") {
      if (
        $(data.selected).prop("class").toLowerCase().indexOf("jsckeditor") !=
          -1 &&
        CKEDITOR != undefined &&
        data.mainin != undefined
      ) {
        try {
          CKEDITOR.instances[data.mainin].setData(value);
        } catch (e) {}
      return;
      }
      $(data.selected).html(value);
      return;
    }
  };

  // ============================================================================
 this.uuidv4 = function () {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
      (
        c ^
        (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
      ).toString(16)
    );
  }

  // ============================================================================
};

var generalTools = new GENERALTOOLSCLASSFUNCT();

export default generalTools;
