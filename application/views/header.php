<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('/asset/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/asset/datatable/css/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/asset/datatable/css/responsive.bootstrap.css'); ?>">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <script src="<?php echo base_url('/asset/js/jquery.slim.min.js'); ?>" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('/asset/js/jquery-3.7.0.js'); ?>" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('/asset/js/jquery.validate.min.js'); ?>" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="<?php echo base_url('/asset/toastr/css/toastr.min.css'); ?>">
    <script src="<?php echo base_url('/asset/toastr/js/toastr.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('/asset/dropzone/css/dropzone.min.css'); ?>">
    <script src="<?php echo base_url('/asset/dropzone/js/dropzone.min.js'); ?>"></script>
    <script src="<?php echo base_url('/asset/select2/js/select2.min.js'); ?>"></script>
    <link href="<?php echo base_url('/asset/select2/css/select2.min.css'); ?>" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/fonts/boxicons.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/core.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/theme-default.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/demo.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/perfect-scrollbar.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/apex-charts.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/theme/css/page-auth.css'); ?>" />
    <script src="<?php echo base_url('asset/theme/js/helpers.js'); ?>"></script>
    <script src="<?php echo base_url('asset/theme/js/config.js'); ?>"></script>

    <title><?php echo $title ?? '' ?></title>

    <style>
        @font-face {
            font-family: 'Graphik Web';
            src: url('Graphik-SuperItalic-Web.eot');
            src: url('Graphik-SuperItalic-Web.eot?#iefix') format('embedded-opentype'),
                url('Graphik-SuperItalic-Web.woff2') format('woff2'),
                url('Graphik-SuperItalic-Web.woff') format('woff');
            font-weight: 900;
            font-style: italic;
            font-stretch: normal;
        }

        .error {
            color: red;
        }

        body {
            font-family: " Graphik";
            font-weight: 500;
            margin: 0;
            padding: 0;
        }

        input:focus {
            outline: none;
        }

        .form-control:focus {
            color: #495057;
            background-color: #b5e7ee;
            border-color: black;
            outline: 0;
            box-shadow: #b5e7ee;
        }

        .custom-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* align-items: center; */
            padding: 20px;
        }

        .custom-input {
            border: 2px solid black;
            background-color: #b5e7ee;
            width: 100%;
        }

        .custom-button {
            padding: 5px 25px;
            font-weight: 600;
            font-size: 25px;
            border: 2px solid black;
        }

        .btn-color {
            background: linear-gradient(to right, #ccffcc 0%, #99ccff 100%);
        }

        .btn {
            width: 100%;
            margin: 0px 0;
        }

        .custom-container {
            min-height: 60vh;
            display: flex;
            justify-content: center;
            /* align-items: center; */
        }

        .header_title {
            border-bottom: 2px solid black;
            padding-bottom: 5px;
            text-align: center;
            font-weight: 600;
        }

        @media (max-width: 767px) {

            h1 {
                font-size: 40px;
            }

            h4 {
                font-size: 25px;
            }

            .btn {
                width: 100%;
            }

            .btn-lg {
                padding: 12px 20px;
                font-size: 25px;
            }
        }

        #category_list.dataTable th,
        #category_list.dataTable td {
            border: none;
            padding: 8px;
        }

        #admin_user_list.dataTable th,
        #admin_user_list.dataTable td {
            border: none;
            padding: 8px;
        }


        #loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        const base_url = '<?php echo base_url() ?>';
        window.showLoader = function() {
            $('#loader-container').show();
        };

        // Define the hideLoader function
        window.hideLoader = function() {
            $('#loader-container').hide();
        };
        $(document).ready(function() {
            // Hide the loader initially
            $('#loader-container').hide();

            // Example: Simulate a delay and hide the loader after 3 seconds
            setTimeout(hideLoader, 3000);

            // You can call showLoader and hideLoader functions as needed in your application
        });
    </script>
</head>

<body>
    <div id="loader-container">
        <div class="loader"></div>
    </div>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">