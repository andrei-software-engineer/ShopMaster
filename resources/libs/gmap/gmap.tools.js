import $ from "jquery";
import baseClass from "../../js/base/baseClass";
import generalTools from "../../js/base/generalTools";
import gmapstyles from "./gmap.styles";

// ============================================================================
// ============================================================================
// ============================================================================
var GMAPTOOLS = function () {
  // ============================================================================
  this.t_gmap_obj_id = "";
  this.t_gmap_function = "";
  this.generalicon = "";

  this.dinamicallymarkers = new Array();
  this.infowindow = new Object();
  this.maps = new Object();
  this.mapsmarkers = new Object();

  this.clustericonpath = "";

  this.clustersmarker = new Object();
  this.genclustersname = "__general";

  // ============================================================================
  this.setInitialData = function () {
    // gmaptools.generalicon = "assets/images/map/google_map_icon.png";

    gmaptools.clustericonpath = "assets/images/map/cluster/";
  }

  // ============================================================================
  this.pre_load_map = function (obj, f) {
    gmaptools.setInitialData();

    var id = obj.attr('id');
    if (id == undefined) {
      id = generalTools.uuidv4();
      obj.attr("id", id);
    }


    if (typeof google != "undefined" && typeof google.maps != "undefined") {
      gmaptools[f](obj);
    } else {
      if (
        gmaptools.t_gmap_obj_id != undefined &&
        gmaptools.t_gmap_obj_id == obj.attr("id")
      ) {
        return;
      }

      gmaptools.t_gmap_obj_id = obj.attr("id");
      gmaptools.t_gmap_function = f;

      var url =
        "https://maps.googleapis.com/maps/api/js?key=" +
        $("#__meta_googlekeymap").attr("content") +
        "&sensor=false&callback=initialize_gmap";

      $.ajaxSetup({ cache: true });
      $.getScript(url, function () { });
    }
  };

  // ============================================================================
  this.setmarker = function (obj) {
    var zoomMap = parseInt(obj.attr("data-zoom"));
    var centerLatMap = parseFloat(obj.attr("data-lat"));
    var centerLngMap = parseFloat(obj.attr("data-lng"));

    if (isNaN(zoomMap)) zoomMap = 13;
    if (isNaN(centerLatMap)) centerLatMap = 47;
    if (isNaN(centerLngMap)) centerLngMap = 28.5;

    var mapOptions = {
      center: new google.maps.LatLng(centerLatMap, centerLngMap),
      zoom: zoomMap,
      scrollwheel: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    };

    var map = new google.maps.Map(
      document.getElementById(obj.attr("id")),
      mapOptions
    );

    
    // var icon = new google.maps.MarkerImage("assets/images/map/google_map_icon.png");
    // var icon = new google.maps.MarkerImage(gmaptools.generalicon);
    // console.log(icon);

    var MarkerT = new google.maps.Marker({
      position: new google.maps.LatLng(centerLatMap, centerLngMap),
      title: "Drag marker",
      draggable: true,
      // icon: icon,
    });
    MarkerT.setMap(map);

    var lngT = $("#" + obj.attr("id") + "_lng");
    var latT = $("#" + obj.attr("id") + "_lat");

    google.maps.event.addListener(MarkerT, "mouseup", function () {
      google.maps.event.trigger(map, "resize");
      gmaptools.updateinputcoordinates(obj.attr("id"), MarkerT);
      //	map.setCenter(MarkerT.getPosition());
    });

    obj.bind("resize", function () {
      google.maps.event.trigger(map, "resize");
      map.setCenter(MarkerT.getPosition());
    });

    map.addListener("click", function (event) {
      console.log('click');
      var coordobj = { lat: event.latLng.lat(), lng: event.latLng.lng() };
      gmaptools.movemarker(obj.attr("id"), coordobj);
      
      console.log(coordobj);
    });


    // --------------------
    obj.removeClass("jsGMap3_SetMarker");

    gmaptools.maps[obj.attr("id")] = map;
    gmaptools.mapsmarkers[obj.attr("id")] = new Array();
    gmaptools.mapsmarkers[obj.attr("id")].push(MarkerT);
  };

  // ============================================================================
  this.showmarkers = function (obj) {
    var mapstyles = gmapstyles.getstyles(obj);
    var zoomMap = parseInt(obj.attr("data-zoom"));
    var centerLatMap = parseFloat(obj.attr("data-lat"));
    var centerLngMap = parseFloat(obj.attr("data-lng"));



    if (isNaN(zoomMap)) zoomMap = 13;
    if (isNaN(centerLatMap)) centerLatMap = 47;
    if (isNaN(centerLngMap)) centerLngMap = 28.5;


    var mapOptions = {
      center: new google.maps.LatLng(centerLatMap, centerLngMap),
      zoom: zoomMap,
      scrollwheel: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: mapstyles,
    };

    var markersMap = [];
    var bounds = new google.maps.LatLngBounds();

    // console.log('centerLatMap: ' + centerLatMap);

    obj.find(".jsGMap3_Marker").each(function () {
      var mobject = new Object();
      mobject.lat = parseFloat($(this).attr("data-lat"));
      mobject.lng = parseFloat($(this).attr("data-lng"));
      mobject.title = $(this).attr("data-title");
      mobject.iconpath = $(this).attr("data-iconpath");
      mobject.cluster = $(this).attr("data-cluster");
      mobject.dburl = $(this).attr("data-dburl");

      console.log(mobject.iconpath);

      var infowindow = $(this).attr("data-infowindow");
      if (infowindow != undefined) mobject.infowindow = infowindow;

      markersMap.push(mobject);
    });

    var map = new google.maps.Map(
      document.getElementById(obj.attr("id")),
      mapOptions
    );

    gmaptools.prepareinfowindow(obj);
    // gmaptools.prepareclusters(obj, map);

    for (var i in markersMap) {
      gmaptools.setmarkeronmap(obj, map, bounds, markersMap[i]);
    }

    map.fitBounds(bounds);

    // --------------------
    var listener = google.maps.event.addListener(map, "idle", function () {
      if (map.getZoom() > zoomMap) map.setZoom(zoomMap);
      google.maps.event.removeListener(listener);
    });
    // --------------------

    obj.bind("resize", function () {
      google.maps.event.trigger(map, "resize");
    });

    // --------------------
    obj.removeClass("jsGMap3_ShowMarkers");

    gmaptools.maps[obj.attr("id")] = map;
  };

  // ============================================================================
  this.showdinamically = function (obj) {
    var mapstyles = gmapstyles.getstyles(obj);
    var zoomMap = parseInt(obj.attr("zoom"));
    var centerLatMap = parseFloat(obj.attr("lat"));
    var centerLngMap = parseFloat(obj.attr("lng"));
    var mapOptions = {
      center: new google.maps.LatLng(centerLatMap, centerLngMap),
      zoom: zoomMap,
      scrollwheel: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: mapstyles,
    };

    var bounds = new google.maps.LatLngBounds();

    var map = new google.maps.Map(
      document.getElementById(obj.attr("id")),
      mapOptions
    );

    var href = obj.attr("href");

    gmaptools.dinamicallymarkers = new Array();
    gmaptools.prepareinfowindow(obj);
    gmaptools.prepareclusters(obj, map);

    map.addListener("dragend", function () {
      gmaptools.getdinamicallymarkers(obj, map, href, bounds);
    });

    map.addListener("zoom_changed", function () {
      gmaptools.getdinamicallymarkers(obj, map, href, bounds);
    });

    map.addListener("tilesloaded", function () {
      gmaptools.getdinamicallymarkers(obj, map, href, bounds);
    });

    obj.bind("resize", function () {
      google.maps.event.trigger(map, "resize");
    });

    // --------------------
    obj.removeClass("jsGMap3_ShowDinamically");

    gmaptools.maps[obj.attr("id")] = map;
  };

  // ============================================================================
  this.getdinamicallymarkers = function (obj, map, href, bounds) {
    if (href == undefined) return;

    var b = map.getBounds();

    var lat0 = b.getNorthEast().lat();
    var lng0 = b.getNorthEast().lng();
    var lat1 = b.getSouthWest().lat();
    var lng1 = b.getSouthWest().lng();

    var suffix = "";
    suffix += "lat0=" + lat0;
    suffix += "&lng0=" + lng0;
    suffix += "&lat1=" + lat1;
    suffix += "&lng1=" + lng1;
    if (href.indexOf("?") >= 0) href += "&" + suffix;
    else href += "?" + suffix;

    ajaxrequest.sendajaxrequest(
      {
        url: href,
        cache: false,
        dataType: "json",
        type: "GET",
        success: function (data) {
          gmaptools.processdinamicallymarkers(obj, map, href, data, bounds);
          return;
        },
        error: function (data) {
          return;
        },
      },
      1
    );
  };

  // ============================================================================
  this.processdinamicallymarkers = function (obj, map, href, data, bounds) {
    if (data.objects != undefined) {
      for (var i in data.objects) {
        var o = data.objects[i];

        if ($.inArray(o.id, gmaptools.dinamicallymarkers) != -1) {
          continue;
        }
        gmaptools.dinamicallymarkers.push(o.id);

        gmaptools.setmarkeronmap(obj, map, bounds, o);
      }
    }
    if (data.nextpageurl != undefined) {
      gmaptools.getdinamicallymarkers(obj, map, data.nextpageurl, bounds);
    }
  };

  // ============================================================================
  this.setmarkeronmap = function (obj, map, bounds, mobject) {
    var lat = parseFloat(mobject.lat);
    var lng = parseFloat(mobject.lng);
    var title = mobject.title;
    var iconpath = mobject.iconpath;
    var dburl = mobject.dburl;
    if (iconpath == undefined) iconpath = "../assets/images/map/google_map_icon.png";
    // if (iconpath == undefined) iconpath = "assets/images/map/google_map_icon.png";
    // if (iconpath == undefined) iconpath = gmaptools.generalicon;

    console.log(iconpath);

    var cluster = mobject.cluster;
    // if (cluster == undefined) cluster = gmaptools.genclustersname;

    var icon = new google.maps.MarkerImage(
      iconpath
      , null
      , null
      , null
      , new google.maps.Size(42, 68)
    );

    bounds.extend(new google.maps.LatLng(lat, lng));

    var m = new google.maps.Marker({
      position: new google.maps.LatLng(lat, lng),
      title: title,
      icon: icon,
      cluster: cluster,
      id: mobject.id,
      map: map,
      infowindowcontent: mobject.infowindow,
    });

    (function (marker) {
      google.maps.event.addListener(marker, "click", function (e) {
        if (marker.infowindowcontent != undefined) {
          gmaptools.infowindow.setContent(marker.infowindowcontent);
          gmaptools.infowindow.open(map, marker);
        }
      });
    })(m);

    if (dburl != undefined) {
      (function (marker) {
        google.maps.event.addListener(marker, "dblclick", function (e) {
          //js AjaxLinkHistoryLoad
          //   mainClass.ShowIsLoadingInProgress();

          //   var hash = dburl;
          //   hash = hash.replace(/^.*#/, "");
          //   mainClass.targid = "sitecontent";
          //   mainClass.goTo(hash);
        });
      })(m);
    }

    if (gmaptools.clustersmarker[m.cluster] != undefined) {
      gmaptools.clustersmarker[m.cluster].addMarker(m);
    } else {
      // gmaptools.clustersmarker[gmaptools.genclustersname].addMarker(m);
    }
  };

  // ============================================================================
  this.prepareclusters = function (obj, map) {
    gmaptools.clustersmarker = new Object();

    gmaptools.prepareclusterssetone(map);

    obj.find(".jsGMap3_Cluster").each(function () {
      gmaptools.prepareclusterssetone(map, $(this));
    });
  };

  // ============================================================================
  this.prepareinfowindow = function (obj) {
    gmaptools.infowindow = new google.maps.InfoWindow();

    google.maps.event.addListener(
      gmaptools.infowindow,
      "domready",
      function () {
        baseClass.OnReadyAll();
      }
    );
  };

  // ============================================================================
  this.prepareclusterssetone = function (map, obj) {
    var mcopt = new Object();

    if (obj == undefined) {
      var name = gmaptools.genclustersname;

      mcopt.gridSize = 30;
      mcopt.maxZoom = 20;
      mcopt.styles = new Array();

      // -------------------------
      var tobj = new Object();
      tobj.height = 53;
      tobj.width = 53;
      tobj.url = gmaptools.clustericonpath + "general_cl_1_53_53.png";

      mcopt.styles.push(tobj);
      // -------------------------

      // -------------------------
      var tobj = new Object();
      tobj.height = 56;
      tobj.width = 56;
      tobj.url = gmaptools.clustericonpath + "general_cl_2_56_56.png";

      mcopt.styles.push(tobj);
      // -------------------------

      // -------------------------
      var tobj = new Object();
      tobj.height = 66;
      tobj.width = 66;
      tobj.url = gmaptools.clustericonpath + "general_cl_3_66_66.png";

      mcopt.styles.push(tobj);
      // -------------------------

      // -------------------------
      var tobj = new Object();
      tobj.height = 78;
      tobj.width = 78;
      tobj.url = gmaptools.clustericonpath + "general_cl_4_78_78.png";

      mcopt.styles.push(tobj);
      // -------------------------

      // -------------------------
      var tobj = new Object();
      tobj.height = 90;
      tobj.width = 90;
      tobj.url = gmaptools.clustericonpath + "general_cl_5_90_90.png";

      mcopt.styles.push(tobj);
      // -------------------------
    } else {
      var name = obj.attr("name");
      if (name == undefined) return;

      mcopt.gridSize = obj.attr("gridSize");
      mcopt.maxZoom = obj.attr("maxZoom");
      mcopt.styles = new Array();

      obj.find(".jsGMap3_ClusterStyle").each(function () {
        // -------------------------
        var tobj = new Object();
        tobj.height = $(this).attr("height");
        tobj.width = $(this).attr("width");
        tobj.url = $(this).attr("iconurl");

        mcopt.styles.push(tobj);
        // -------------------------
      });
    }

    var mc = new MarkerClusterer(map, [], mcopt);

    gmaptools.clustersmarker[name] = mc;
  };

  // ============================================================================
  this.setcenter = function (idmap, coordobj) {
    if (gmaptools.maps[idmap] == undefined) return;
    if (coordobj.lat == undefined) return;
    if (coordobj.lng == undefined) return;

    //        gmaptools.maps[idmap].setCenter(new google.maps.LatLng(coordobj.lat,coordobj.lng));
    gmaptools.maps[idmap].setCenter(coordobj);
  };

  // ============================================================================
  this.movemarker = function (idmap, coordobj) {
    if (gmaptools.mapsmarkers[idmap] == undefined) return;
    if (!gmaptools.mapsmarkers[idmap].length) return;

    var marker = gmaptools.mapsmarkers[idmap][0];
    marker.setPosition(coordobj);

    gmaptools.updateinputcoordinates(idmap, marker);
  };

  // ============================================================================
  this.updateinputcoordinates = function (idmap, marker) {
    var lngT = $("#" + idmap + "_lng");
    var latT = $("#" + idmap + "_lat");

    lngT.val(marker.position.lng());
    latT.val(marker.position.lat());
  };

  // ============================================================================
};

var gmaptools = new GMAPTOOLS();

// ------------------------------------
baseClass.OnReadyArrAdd(function () {
  // ------------------------------------
  $(".jsGMap3_SetMarker").each(function (e) {
    if ($(this).hasClass("true")) return;
    $(this).addClass("true");

    var executed = $(this).attr("executed");
    if (!executed) {
      var obj = $(this);
      setTimeout(function () {
        gmaptools.pre_load_map(obj, "setmarker");
      }, 50);
    }
  });

  // ------------------------------------
  $(".jsGMap3_ShowMarkers").each(function (e) {
    if ($(this).hasClass("true")) return;
    $(this).addClass("true");

    // console.log('each: jsGMap3_ShowMarkers');

    var executed = $(this).attr("executed");
    if (!executed) {
      var obj = $(this);
      setTimeout(function () {
        gmaptools.pre_load_map(obj, "showmarkers");
      }, 50);
    }
  });
  // ------------------------------------

  $(".jsGMap3_ShowDinamically").each(function (e) {
    if ($(this).hasClass("true")) return;
    $(this).addClass("true");

    // console.log('each: jsGMap3_ShowDinamically');

    var executed = $(this).attr("executed");
    if (!executed) {
      var obj = $(this);
      setTimeout(function () {
        gmaptools.pre_load_map(obj, "showdinamically");
      }, 50);
    }
  });
  // ------------------------------------
});


// --------------------------------------------------
window.initialize_gmap = () => {
  console.log('initialize_gmap t_gmap_obj_id: ' + gmaptools.t_gmap_obj_id);

  var obj = $("#" + gmaptools.t_gmap_obj_id);
  obj.attr("executed", "1");
  var f = gmaptools.t_gmap_function;
  gmaptools[f](obj);
}
// --------------------------------------------------

export default gmaptools;

