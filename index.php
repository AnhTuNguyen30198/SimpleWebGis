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
            height: 772px;
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="Bandovung/polygon.php"><i class="fas fa-user"></i><span>Bản Đồ Vùng</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="Bandoduong/road.php"><i class="fas fa-user-circle"></i><span>Bản đồ Đường</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="Bandodiem/point.php"><i class="fas fa-key"></i><span>Bản đồ điểm</span></a></li>
                </ul>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
                <div id = "map" class="map">
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
                            var viewMap = new ol.View({
                                center: ol.proj.fromLonLat([mapLng, mapLat]),
                                zoom: mapDefaultZoom
                            });
                            map = new ol.Map({
                                target: "map",
                                layers: [layerBG],
                                view: viewMap
                            });
                        };
                </script>
                </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
