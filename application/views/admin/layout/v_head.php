<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILOKAT | KPU Provinsi Kalimantan Tengah</title>
    
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/main/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/main/app-dark.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.css">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/user/image/logo-kpu.png" type="image/png">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/shared/iconly.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- cluster -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/user/cluster/MarkerCluster.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/user/cluster/MarkerCluster.Default.css" />
        <script src="<?= base_url() ?>assets/user/cluster/leaflet.markercluster-src.js"></script>

        <!-- Load Esri Leaflet from CDN -->
        <script src="https://unpkg.com/esri-leaflet@3.0.10/dist/esri-leaflet.js"></script>
        <script src="https://unpkg.com/esri-leaflet-vector@4.1.0/dist/esri-leaflet-vector.js"></script>

        <!-- Load Esri Leaflet Geocoder from CDN -->
        <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>


        <!-- routing machine -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

        <!-- datatables -->
        <link rel="stylesheet" href="<?= base_url() ?>/assets/css/pages/fontawesome.css">
        <link rel="stylesheet" href="<?= base_url() ?>/assets/extensions/simple-datatables/style.css">
        <link rel="stylesheet" href="<?= base_url() ?>/assets/css/pages/simple-datatables.css">


        


        <style>
        #map { 
            height: 70vh;
            border-radius:5px; 
        }
        #edit-map { 
            height: 70vh;
            border-radius:5px; 
        }
        .custom-icon {
            text-align: center;
            color: white;
        }   

        .icon-container {
            background-color: #B10505;
            border-radius: 50%;
            width: auto;
            height: 40px;
            line-height: 40px;
        }

        .icon-number {
            font-weight: bold;
        }

        /* Gaya umum untuk klaster */
        .custom-cluster-icon {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        font-weight: bold;
        color: white;
    }

    .cluster-icon {
            background-size: cover;
            cursor: pointer;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            /* line-height: 40px; */
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            /* color:red; */
            margin-top:-2em;
        }

        .kecamatan-cluster-icon {
        background-color: #007BFF;
        /* border-radius: 50%; */
        text-align: center;
        line-height: 30px;
        color: white;
    }
    .kecamatan-name {
        font-size: 12px;
        font-weight: bold;
        /* margin :2px; */
    }
        .small-font {
            font-size: 11pt;
        }
        .statistik h6{
            font-size:11pt;
        }
        
    </style>

</head>

<body>
<div id="loader">
    <!-- partial:index.partial.html -->
    <svg class="pl" viewBox="0 0 200 200" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="pl-grad1" x1="1" y1="0.5" x2="0" y2="0.5">
                <stop offset="0%" stop-color="hsl(313,90%,55%)" />
                <stop offset="100%" stop-color="hsl(223,90%,55%)" />
            </linearGradient>
            <linearGradient id="pl-grad2" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="hsl(313,90%,55%)" />
                <stop offset="100%" stop-color="hsl(223,90%,55%)" />
            </linearGradient>
        </defs>
        <circle class="pl__ring" cx="100" cy="100" r="82" fill="none" stroke="url(#pl-grad1)" stroke-width="36" stroke-dasharray="0 257 1 257" stroke-dashoffset="0.01" stroke-linecap="round" transform="rotate(-90,100,100)" />
        <line class="pl__ball" stroke="url(#pl-grad2)" x1="100" y1="18" x2="100.01" y2="182" stroke-width="36" stroke-dasharray="1 165" stroke-linecap="round" />
    </svg>
    <!-- partial -->
</div>
    <div id="app">