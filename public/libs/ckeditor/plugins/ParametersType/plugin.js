(function () {
  CKEDITOR.plugins.add("ParametersType", {
    requires: ["richcombo"], //, 'styles' ],
    init: function (editor) {
      var config = editor.config,
          lang = editor.lang.format;
       
       var tags = []; 
       
      tags[0] = ["[contact_name]", "Name", "Name"];
      tags[1] = ["[contact_email]", "email", "email"];
      tags[2] = ["[contact_user_name]", "User name", "User name"];
      editor.ui.addRichCombo("ParametersType", {
        label: "Parameters",
        title: "Parameters",
        voiceLabel: "Parameters",
        className: "cke_format",
        multiSelect: false,
        panel: {
          css: [
            config.contentsCss,
            CKEDITOR.getUrl("skins/moono/editor_gecko.css"),
          ],
          voiceLabel: lang.panelVoiceLabel,
        },
        init: function () {
           this.startGroup("Parameters");
           
          var list = this;

          const tbelem = document.getElementById(
            editor.element.getId() + "__tb_tagslist"
          );

          if (tbelem != undefined) {
            const rows = tbelem.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
              const tdVal = rows[i].querySelectorAll('td[data-name="value"]');
              const tdText = rows[i].querySelectorAll(
                'td[data-name="drop_text"]'
              );
              const tdLabel = rows[i].querySelectorAll(
                'td[data-name="drop_label"]'
              );

              if (
                tdVal == undefined ||
                tdText == undefined ||
                tdLabel == undefined
              )
                continue;

              list.add(
                tdVal[0].innerHTML,
                tdText[0].innerHTML,
                tdLabel[0].innerHTML
              );
            }
          }
        },
        onClick: function (value) {
          editor.focus();
          editor.fire("saveSnapshot");
          if (value.indexOf("IMG=") == 0) {
            value = value.replace(/IMG=/, "");
            editor.insertHtml('<img src="' + value + '" />');
          } else if (value.indexOf("A=") == 0) {
            value = value.replace(/A=/, "");
            editor.insertHtml('<a href="' + value + '" >' + value + "</a>");
          } else {
            editor.insertHtml(value);
          }
          editor.fire("saveSnapshot");
        },
      });
    },
  });
})();
