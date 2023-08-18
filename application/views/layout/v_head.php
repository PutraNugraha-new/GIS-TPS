<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SILOKAT | KPU Provinsi Kalimantan Tengah</title>
        <link href="<?= base_url() ?>assets/user/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="<?= base_url() ?>assets/user/css/custom.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/user/js/custom.js" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <script src="<?= base_url() ?>assets/user/js/custom.js" defer></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="shortcut icon" href="<?= base_url() ?>/assets/user/image/logo-kpu.png" type="image/png">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <link rel="stylesheet" href="<?= base_url() ?>/assets/user/css/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="<?= base_url() ?>/assets/user/css/leaflet-panel-layers.css" />

    <style>
        #map { 
            height: 70vh;
            /* width:50%; */
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
            line-height: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        
    </style>
    </head>
<body>


