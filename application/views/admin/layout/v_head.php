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

    <!-- choice  -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/base.min.css"/> -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/choices.js/public/assets/styles/choices.css">
    <script src="<?= base_url() ?>/assets/choices.js/public/assets/scripts/choices.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script> -->

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
        .small-font {
            font-size: 11pt; Atur ukuran font sesuai kebutuhan Anda
        }
        .statistik h6{
            font-size:11pt;
        }

    </style>

</head>

<body>
    <div id="app">