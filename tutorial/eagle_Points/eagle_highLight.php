<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OpenStreetMap &amp; OpenLayers - Marker Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--
        <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
        <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
        -->
        <link rel="stylesheet" href="http://localhost:8081/libs/openlayers/css/ol.css" type="text/css" />
        <script src="http://localhost:8081/libs/openlayers/build/ol.js" type="text/javascript"></script>
        <!--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
        -->
        <script src="http://localhost:8081/libs/jquery/jquery-3.4.1.min.js" type="text/javascript"></script>
    <body onload="initialize_map();">
        <table>
            <tr>
                <td>
                    <div id="map" style="width: 80vw; height: 100vh;"></div>
                </td>
                <td>
                    <button>Button</button>
                </td>
            </tr>
        </table>
        <!--<?php include 'eagle_pgsqlAPI.php' ?>-->
        <?php
            //$myPDO = initDB();
            //$mySRID = '4326';
            //$pointFormat = 'POINT(12,5)';

            //example1($myPDO);
            //example2($myPDO);
            //example3($myPDO,'4326','POINT(12,5)');
            //$result = getResult($myPDO,$mySRID,$pointFormat);

            //closeDB($myPDO);
        ?>
        <script>
            var format = 'image/png';
            var map;
            var minX = -105.231735229492;
            var minY = 39.8262786865234;
            var maxX = -104.006164550781;
            var maxY = 40.6606330871582;
            var cenX = (minX + maxX) / 2;
            var cenY = (minY + maxY) / 2;
            var mapLat = cenY;
            var mapLng = cenX;
            var mapDefaultZoom = 9;
            function initialize_map() {
                //*
                layerBG = new ol.layer.Tile({
                    source: new ol.source.OSM({})
                });
                //*/
                var layerEagle = new ol.layer.Image({
                    source: new ol.source.ImageWMS({
                        ratio: 1,
                        url: 'http://localhost:8080/geoserver/example/wms?',
                        params: {
                            'FORMAT': format,
                            'VERSION': '1.1.1',
                            STYLES: '',
                            LAYERS: 'eagle',
                        }
                    })
                });
                var viewMap = new ol.View({
                    center: ol.proj.fromLonLat([mapLng, mapLat]),
                    zoom: mapDefaultZoom
                    //projection: projection
                });
                map = new ol.Map({
                    target: "map",
                    layers: [layerBG, layerEagle],
                    //layers: [layerDuongDiaGioi],
                    view: viewMap
                });
                //map.getView().fit(bounds, map.getSize());
                
                var styles = {
                    //*
                    'Point': new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: 'yellow', 
                            width: 3
                        })
                    }),
                    //*/
                    /*
                    'Point': = new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 0.5],
                            anchorXUnits: "fraction",
                            anchorYUnits: "fraction",
                            src: "http://localhost:8081/gis/eagle/RedDot.svg"
                        })
                    }),
                    */
                    'MultiLineString': new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: 'yellow', 
                            width: 3
                        })
                    }),
                    'Polygon': new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: 'yellow', 
                            width: 3
                        })
                    })
                };
                var styleFunction = function (feature) {
                    return styles[feature.getGeometry().getType()];
                };
                var stylePoint = new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 0.5],
                        anchorXUnits: "fraction",
                        anchorYUnits: "fraction",
                        src: "http://localhost:8081/gis/eagle/Yellow_dot.svg"
                    })
                });
                var vectorLayer = new ol.layer.Vector({
                    //source: vectorSource,
                    //style: styleFunction
                    style: stylePoint
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
                    //alert("Full Json: " + strObjJson);
                    var objJson = JSON.parse(strObjJson);
                    //alert("Full Json: " + JSON.stringify(objJson));
                    //drawGeoJsonObj(objJson);
                    highLightGeoJsonObj(objJson);
                }
                map.on('singleclick', function (evt) {
                    //alert("coordinate: " + evt.coordinate);
                    //var myPoint = 'POINT(12,5)';
                    var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                    var lon = lonlat[0];
                    var lat = lonlat[1];
                    var myPoint = 'POINT(' + lon + ' ' + lat + ')';
                    //alert("myPoint: " + myPoint);
                    $.ajax({
                        type: "POST",
                        url: "eagle_pgsqlAPI.php",
                        //dataType: 'json',
                        data: {functionname: 'getGeoEagleToAjax', paPoint: myPoint},
                        success : function (result, status, erro) {
                            highLightObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                });
            };
        </script>
    </body>
</html>