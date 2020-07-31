<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Map</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/css/ol.css" type="text/css">
    <style>
        .map {
            height: 650px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/build/ol.js"></script>
</head>

<body id="page-top" onload="initialize_map()">
<div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Home</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Bản Đồ Nền</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="bandochuyende.php"><i class="fas fa-user"></i><span>Bản Đồ Chuyên Đề</span></a></li>
                <!-- i class="far fa-user-circle"></i><span>Login</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="register.html"><i class="fas fa-user-circle"></i><span>Register</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="forgot-password.html"><i class="fas fa-key"></i><span>Forgotten Password</span></a></li> -->
            </ul>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav flex-nowrap ml-auto">
                        <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                            <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto navbar-search w-100">
                                    <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                        <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                    <a
                                            class="dropdown-item" role="presentation" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <div id = "map" class="map">
                    <?php include 'polygonpgsqlAPI.php' ?>
                        <script type="text/javascript">
                            var format = 'image/png';
                            var map;
                            var minX = 102.144584655762;
                            var minY = 8.38135528564453;
                            var maxX = 109.469177246094;
                            var maxY = 23.3926944732666;
                            var cenX = (minX + maxX) / 2;
                            var cenY = (minY + maxY) / 2;
                            var mapLat = cenY;
                            var mapLng = cenX;
                            var mapDefaultZoom = 5.8;
                            function initialize_map(){
                                layerBG = new ol.layer.Tile({
                                    source: new ol.source.OSM({})
                                });

                                var layerVN = new ol.layer.Image({
                                    source: new ol.source.ImageWMS({
                                        ratio: 1,
                                        url: 'http://localhost:8888/geoserver/SimplClimate/wms?',
                                        params: {
                                            'FORMAT': format,
                                            'VERSION': '1.1.1',
                                            STYLES: '',
                                            LAYERS: 'gadm36_vnm_1',
                                        }
                                    })
                                });
                                var viewMap = new ol.View({
                                    center: ol.proj.fromLonLat([mapLng, mapLat]),
                                    zoom: mapDefaultZoom
                                });
                                map = new ol.Map({
                                    target: "map",
                                    layers: [layerBG,layerVN],
                                    view: viewMap
                                });
                                //map.getView().fit(bounds, map.getSize());

                                var styles = {
                                    'MultiPolygon': new ol.style.Style({
                                        fill: new ol.style.Fill({
                                            color: 'orange'
                                        }),
                                        stroke: new ol.style.Stroke({
                                            color: 'yellow',
                                            width: 2
                                        })
                                    })
                                };
                                var styleFunction = function (feature) {
                                    return styles[feature.getGeometry().getType()];
                                };
                                var vectorLayer = new ol.layer.Vector({
                                    //source: vectorSource,
                                    style: styleFunction
                                });
                                map.addLayer(vectorLayer);

                                function createJsonObj(result) {
                                    var geojsonObject = '{'
                                        + '"type": "FeatureCollection",'
                                        + '"crs": {'
                                        + '"type": "name",'
                                        + '"properties": {'
                                        + '"name": "EPSG:4326"'
                                        + '}'
                                        + '},'
                                        + '"features": [{'
                                        + '"type": "Feature",'
                                        + '"geometry": ' + result
                                        + '}]'
                                        + '}';
                                    return geojsonObject;
                                }
                                function drawGeoJsonObj(paObjJson) {
                                    var vectorSource = new ol.source.Vector({
                                        features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                                            dataProjection: 'EPSG:4326',
                                            featureProjection: 'EPSG:3857'
                                        })
                                    });
                                    var vectorLayer = new ol.layer.Vector({
                                        source: vectorSource
                                    });
                                    map.addLayer(vectorLayer);
                                }
                                function highLightGeoJsonObj(paObjJson) {
                                    var vectorSource = new ol.source.Vector({
                                        features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                                            dataProjection: 'EPSG:4326',
                                            featureProjection: 'EPSG:3857'
                                        })
                                    });
                                    vectorLayer.setSource(vectorSource);
                                    /*
                                    var vectorLayer = new ol.layer.Vector({
                                        source: vectorSource
                                    });
                                    map.addLayer(vectorLayer);
                                    */
                                }
                                function highLightObj(result) {
                                    //alert("result: " + result);
                                    var strObjJson = createJsonObj(result);
                                    //alert(strObjJson);
                                    var objJson = JSON.parse(strObjJson);
                                    //alert(JSON.stringify(objJson));
                                    //drawGeoJsonObj(objJson);
                                    highLightGeoJsonObj(objJson);
                                }
                                function displayObjInfo(result, coordinate)
                                {
                                    alert("result: " + result);
                                    //alert("coordinate des: " + coordinate);
                                    map.addPopup(result);
                                }
                                map.on('singleclick', function (evt) {
                                    //alert("coordinate: " + evt.coordinate);
                                    //var myPoint = 'POINT(12,5)';
                                    var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                                    var lon = lonlat[0];
                                    var lat = lonlat[1];
                                    var myPoint = 'POINT(' + lon + ' ' + lat + ')';
                                    //alert("myPoint: " + myPoint);
                                    //*
                                    $.ajax({
                                        type: "POST",
                                        url: "polygonpgsqlAPI.php",
                                        //dataType: 'json',
                                        data: {functionname: 'getGeoCMRToAjax', paPoint: myPoint},
                                        success : function (result, status, erro) {
                                            highLightObj(result);
                                        },
                                        error: function (req, status, error) {
                                            alert(req + " " + status + " " + error);
                                        }
                                    });
                                    $.ajax({
                                        type: "POST",
                                        url: "polygonpgsqlAPI.php",
                                        //dataType: 'json',
                                        //data: {functionname: 'reponseGeoToAjax', paPoint: myPoint},
                                        data: {functionname: 'getInfoCMRToAjax', paPoint: myPoint},
                                        success : function (result, status, erro) {
                                            displayObjInfo(result, evt.coordinate );
                                        },
                                        error: function (req, status, error) {
                                            alert(req + " " + status + " " + error);
                                        }
                                    });
                                    //*/
                                });

                            };
                        </script>

                </div>
                <div>

                </div>

            </div>
        </div>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/theme.js"></script>
</body>

</html>