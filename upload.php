<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=0" />

    <title>Onyx Web Development Nuggets - DropzoneJS example with everything you will need, translations, custom preview and a powerful PHP code to handle upload/delete file</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://onyxdev.net/files/assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="https://onyxdev.net/files/assets/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://onyxdev.net/files/assets/images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="https://onyxdev.net/files/assets/images/favicons/manifest.json">
    <link rel="mask-icon" href="https://onyxdev.net/files/assets/images/favicons/safari-pinned-tab.svg" color="#34b2a7">
    <link rel="shortcut icon" href="https://onyxdev.net/files/assets/images/favicons/favicon.ico">
    <meta name="msapplication-config" content="https://onyxdev.net/files/assets/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#34b2a7">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,600,700|Open+Sans" rel="stylesheet">

    <!-- Libraries/Plugins -->
    <link id="bootstrap-css" href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link id="dropzone-css" href="assets/css/dropzone.css" rel="stylesheet">

    <!-- Icons Library -->
    <link id="font-awesome-css" href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link id="onyx-css" href="style.css" rel="stylesheet">
    <style>
        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-shadow: rgba(0, 0, 0, 0.01) 0 0 1px;
            text-rendering: optimizeLegibility;
            background-color: #29323c;
        }

        body {
            background-color: #fff;
            font-family: 'Open Sans', Arial, sans-serif;
            letter-spacing: normal;
            line-height: 1.5;
            overflow-x: hidden;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.25px;

            background-image: linear-gradient(60deg, #29323c 0%, #485563 100%);
        }

        * {
            outline: 0;
        }

        a,
        a:hover,
        a:focus {
            text-decoration: none;
        }

        a:focus,
        a:hover,
        button:focus,
        button:hover {
            outline: none;
            color: #fff;
        }

        button {
            cursor: pointer;
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        ::selection {
            background: #e84158;
            color: #ffffff;
        }

        ::-moz-selection {
            background: #e84158;
            color: #ffffff;
        }

        ::-webkit-selection {
            background: #e84158;
            color: #ffffff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 500;
            line-height: 1;
        }

        h1>span:first-of-type,
        h2>span:first-of-type,
        h3>span:first-of-type,
        h4>span:first-of-type,
        h5>span:first-of-type,
        h6>span:first-of-type {
            font-weight: 300;
        }

        /************************************************************
    Common styles
*************************************************************/

        /* Transitions
*************************************/
        .file-item:before,
        .file-item,
        .file-item .fake button i,
        .remove-file:before,
        .files-container {
            -webkit-transition: all 0.15s ease-in-out;
            -moz-transition: all 0.15s ease-in-out;
            -ms-transition: all 0.15s ease-in-out;
            -o-transition: all 0.15s ease-in-out;
            transition: all 0.15s ease-in-out;
        }

        /* Content
*************************************/
        .section-sub-title {
            font-family: 'Montserrat', Arial, Sans-serif;
            font-size: 18px;
            line-height: 1.35;
            text-transform: capitalize;
        }

        .text-center {
            text-align: center;
        }

        /************************************************************
    Sections
*************************************************************/

        /* Wrapper
*************************************/
        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* BGs
*************************************/
        .full-dark-bg {
            margin: 5% auto;
            background-color: rgba(0, 0, 0, 0.25);
            padding: 5%;
        }

        /************************************************************
    DropzoneJS Example
*************************************************************/

        .inner-page .section-title {
            font-size: 28px;
            text-transform: uppercase;
            position: relative;
        }

        .inner-page .section-sub-title {
            margin-top: 10px;
            text-transform: uppercase;
            color: #fff;
        }

        .inner-page .section-sub-title:not(:first-child) {
            margin-top: 35px;
        }

        /* Upload files
*************************************/
        .files-container {
            position: relative;
            margin: 30px 2px 15px 2px;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .files-container span {
            display: block;
            text-align: center;
            padding: 50px 25px;
            font-size: 13px;
            text-transform: capitalize;
        }

        /*** Dropzone ***/
        .files-container.hover {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px dashed rgba(255, 255, 255, 0.5);
            color: rgba(255, 255, 255, 0.85);
        }

        .files-container {
            position: relative;
            border: 1px dashed rgba(255, 255, 255, 0.25);
            min-height: auto;
        }

        .files-container #upload-label {
            background: rgba(231, 97, 92, 0);
            color: #fff;
            position: absolute;
            height: 115px;
            top: 20%;
            left: 0;
            right: 0;
            margin-right: auto;
            margin-left: auto;
            min-width: 20%;
            text-align: center;
            cursor: pointer;
        }

        .files-container.active {
            background: #fff;
        }

        .files-container.active #upload-label {
            background: #fff;
            color: #e7615c;
        }

        .files-container #upload-label i:hover {
            color: #444;
            font-size: 9.4rem;
            -webkit-transition: width 2s;
        }

        .files-container #upload-label span.title {
            font-size: 1em;
            font-weight: bold;
            display: block;
        }

        span.tittle {
            position: relative;
            top: 222px;
            color: #bdbdbd;
        }

        .files-container #upload-label i {
            text-align: center;
            display: block;
            color: #e7615c;
            height: 115px;
            font-size: 9.5rem;
            position: absolute;
            top: -12px;
            left: 0;
            right: 0;
            margin-right: auto;
            margin-left: auto;
        }

        /** Preview of collections of uploaded documents **/
        .preview-container {
            position: relative;
            visibility: hidden;
        }

        .preview-container #previews .onyx-dropzone-info {
            display: flex;
            flex-wrap: nowrap;
            padding-top: 15px;
            width: 100%;
        }

        .preview-container #previews .onyx-dropzone-info>.thumb-container {
            flex: 0 0 50px;
            max-width: 50px;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 17px;
        }

        .preview-container #previews .onyx-dropzone-info img {
            max-width: 100%;
            height: auto;
        }

        .preview-container #previews .onyx-dropzone-info>.details {
            position: relative;
            flex: 0 0 calc(100% - 50px);
            max-width: calc(100% - 50px);
            padding-right: 30px;
        }

        .preview-container #previews .onyx-dropzone-info .actions {
            position: absolute;
            right: 0;
            top: 50%;
            line-height: 1;
            transform: translateY(-50%);
        }

        #previews>div {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: flex-start;
            -ms-flex-align: flex-start;
            align-items: flex-start;
        }

        /* Uploaded files
*************************************/
        .no-files-uploaded {
            display: block;
        }

        .uploaded-files {
            margin-top: 10px;
            transition: all 0.3s ease-in-out;
        }

        .uploaded-files span,
        .uploaded-files a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }

        .uploaded-files a:hover {
            text-decoration: underline !important;
        }

        .uploaded-files i {
            position: relative;
            margin-right: 7px;
            font-size: 12px;
            color: #de1500;
        }

        /* File types
*************************************/
        .thumb-container {
            position: relative;
        }

        div.type-pdf .thumb-container:after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-size: cover;
            background-size: 90% 100%;
            background-position: left center;
            background-repeat: no-repeat;
        }

        div.type-pdf .thumb-container:after {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTYgNTYiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU2IDU2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4uc3Qwe2ZpbGw6I0UyNTc0Qzt9LnN0MXtmaWxsOiNCNTM2Mjk7fS5zdDJ7ZmlsbDojRkZGRkZGO308L3N0eWxlPjxnPjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0zNi45LDBoLTI5QzcuMiwwLDYuNCwwLjYsNi40LDEuOVY1NWMwLDAuNCwwLjYsMSwxLjUsMWg0MC4xYzAuNywwLDEuNS0wLjYsMS41LTFWMTNjMC0wLjctMC4xLTAuOS0wLjMtMS4xTDM3LjcsMC4zQzM3LjQsMC4xLDM3LjIsMCwzNi45LDBMMzYuOSwweiIvPjxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik0zNy40LDAuMVYxMmgxMS45TDM3LjQsMC4xeiIvPjxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik0xNy4zLDM0LjNoLTEuNlYyNC4xaDIuOWMwLjQsMCwwLjksMC4xLDEuMiwwLjNjMC40LDAuMSwwLjcsMC40LDEuMSwwLjZjMC40LDAuMywwLjYsMC42LDAuNywxYzAuMywwLjQsMC4zLDAuOSwwLjMsMS4yYzAsMC41LTAuMSwxLTAuMywxLjRjLTAuMSwwLjQtMC40LDAuNy0wLjcsMWMtMC4zLDAuMy0wLjYsMC41LTEuMSwwLjZjLTAuNCwwLjEtMC45LDAuMy0xLjUsMC4zaC0xLjN2My44SDE3LjN6IE0xNy4zLDI1LjR2NGgxLjVjMC4zLDAsMC40LDAsMC42LTAuMXMwLjQtMC4xLDAuNS0wLjRjMC4xLTAuMSwwLjMtMC40LDAuNC0wLjZzMC4xLTAuNiwwLjEtMWMwLTAuMSwwLTAuNC0wLjEtMC42YzAtMC4zLTAuMS0wLjQtMC4zLTAuNmMtMC4xLTAuMy0wLjQtMC40LTAuNi0wLjVjLTAuMy0wLjEtMC42LTAuMy0xLTAuM2gtMS4xVjI1LjR6Ii8+PHBhdGggY2xhc3M9InN0MiIgZD0iTTMyLjIsMjguOWMwLDAuOS0wLjEsMS41LTAuMywyLjFjLTAuMSwwLjYtMC40LDEuMS0wLjYsMS41Yy0wLjMsMC40LTAuNiwwLjctMC45LDFjLTAuNCwwLjMtMC42LDAuNC0xLDAuNWMtMC40LDAuMS0wLjYsMC4xLTAuOSwwLjNjLTAuMywwLTAuNSwwLTAuNiwwaC0zLjlWMjQuMWgzYzAuOSwwLDEuNiwwLjEsMi4yLDAuNGMwLjYsMC4zLDEuMSwwLjYsMS42LDEuMWMwLjQsMC41LDAuNywxLDEsMS41QzMyLjEsMjcuOCwzMi4yLDI4LjQsMzIuMiwyOC45TDMyLjIsMjguOXogTTI3LjMsMzNjMS4xLDAsMS45LTAuNCwyLjQtMS4xYzAuNS0wLjcsMC43LTEuOCwwLjctMy4xYzAtMC40LDAtMC45LTAuMS0xLjJzLTAuMy0wLjctMC42LTEuMWMtMC4zLTAuNC0wLjYtMC42LTEuMS0wLjdjLTAuNS0wLjMtMS4xLTAuMy0xLjktMC4zaC0xVjMzTDI3LjMsMzNMMjcuMywzM3oiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNMzYuMiwyNS40djMuMWg0LjN2MS4xaC00LjN2NC41aC0xLjZWMjRoNi4zdjEuM2gtNC42VjI1LjR6Ii8+PC9nPjwvc3ZnPg==);
        }

        div.type-jpg .thumb-container:after {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1NiA1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYgNTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPi5zdDB7ZmlsbDojMjZCOTlBO30uc3Qxe2ZpbGw6IzE0QTA4NTt9LnN0MntmaWxsOiNGRkZGRkY7fTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM3LDBIOEM3LjIsMCw2LjUsMC43LDYuNSwxLjlWNTVjMCwwLjMsMC43LDEsMS41LDFINDhjMC44LDAsMS41LTAuNywxLjUtMVYxM2MwLTAuNy0wLjEtMC45LTAuMy0xLjFMMzcuNiwwLjNDMzcuNCwwLjEsMzcuMiwwLDM3LDB6Ii8+PHBvbHlnb24gY2xhc3M9InN0MSIgcG9pbnRzPSIzNy41LDAuMiAzNy41LDEyIDQ5LjMsMTIgIi8+PGc+PHBhdGggY2xhc3M9InN0MiIgZD0iTTIxLjMsMjQuOHY3LjhjMCwwLjUtMC4xLDAuOS0wLjMsMS4yYy0wLjIsMC4zLTAuNCwwLjYtMC43LDAuOGMtMC4zLDAuMi0wLjYsMC4zLTEsMC40Yy0wLjQsMC4xLTAuOCwwLjEtMS4yLDAuMWMtMC4yLDAtMC40LDAtMC43LTAuMWMtMC4zLDAtMC41LTAuMS0wLjgtMC4ycy0wLjYtMC4yLTAuOC0wLjNjLTAuMy0wLjEtMC41LTAuMi0wLjctMC40bDAuNy0xLjFjMC4xLDAuMSwwLjIsMC4xLDAuNCwwLjJjMC4yLDAuMSwwLjQsMC4xLDAuNiwwLjJjMC4yLDAuMSwwLjQsMC4xLDAuNiwwLjJzMC40LDAuMSwwLjYsMC4xYzAuNSwwLDAuOS0wLjEsMS4yLTAuM3MwLjQtMC41LDAuNS0xdi03LjdIMjEuM3oiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNMjUuNCwzNS4xaC0xLjZWMjVoMi45YzAuNCwwLDAuOSwwLjEsMS4zLDAuMnMwLjgsMC4zLDEuMSwwLjZjMC4zLDAuMywwLjYsMC42LDAuOCwxczAuMywwLjgsMC4zLDEuM2MwLDAuNS0wLjEsMS0wLjMsMS40cy0wLjQsMC44LTAuNywxcy0wLjcsMC41LTEuMSwwLjdzLTAuOSwwLjItMS40LDAuMmgtMS4yTDI1LjQsMzUuMUwyNS40LDM1LjF6IE0yNS40LDI2LjN2NGgxLjVjMC4yLDAsMC40LDAsMC42LTAuMWMwLjItMC4xLDAuNC0wLjIsMC41LTAuM3MwLjMtMC40LDAuNC0wLjZzMC4xLTAuNiwwLjEtMWMwLTAuMiwwLTAuNC0wLjEtMC42YzAtMC4yLTAuMS0wLjQtMC4zLTAuNmMtMC4xLTAuMi0wLjMtMC40LTAuNi0wLjVjLTAuMy0wLjEtMC42LTAuMi0xLTAuMkgyNS40eiIvPjxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik0zOS40LDI5Ljl2My45Yy0wLjIsMC4zLTAuNCwwLjUtMC43LDAuNnMtMC41LDAuMy0wLjgsMC40cy0wLjYsMC4yLTAuOSwwLjJjLTAuMywwLTAuNiwwLjEtMC45LDAuMWMtMC42LDAtMS4yLTAuMS0xLjctMC4zcy0wLjktMC41LTEuMy0xcy0wLjctMS0wLjktMS42Yy0wLjItMC42LTAuMy0xLjQtMC4zLTIuMnMwLjEtMS42LDAuMy0yLjJjMC4yLTAuNiwwLjUtMS4yLDAuOS0xLjZjMC40LTAuNCwwLjgtMC44LDEuMy0xYzAuNS0wLjIsMS4xLTAuMywxLjctMC4zYzAuNSwwLDEuMSwwLjEsMS41LDAuM2MwLjUsMC4yLDAuOSwwLjUsMS4zLDAuOGwtMS4xLDFjLTAuMi0wLjMtMC41LTAuNS0wLjgtMC42Yy0wLjMtMC4xLTAuNi0wLjItMC45LTAuMmMtMC4zLDAtMC43LDAuMS0xLDAuMmMtMC4zLDAuMS0wLjYsMC4zLTAuOCwwLjZjLTAuMiwwLjMtMC40LDAuNy0wLjYsMS4ycy0wLjIsMS4xLTAuMiwxLjhjMCwwLjcsMC4xLDEuMywwLjIsMS44YzAuMSwwLjUsMC4zLDAuOSwwLjUsMS4yczAuNSwwLjYsMC44LDAuN2MwLjMsMC4yLDAuNiwwLjIsMC45LDAuMmMwLjEsMCwwLjIsMCwwLjQsMGMwLjIsMCwwLjMsMCwwLjUtMC4xYzAuMiwwLDAuMy0wLjEsMC41LTAuMXMwLjMtMC4xLDAuMy0wLjJWMzFoLTEuN3YtMS4xTDM5LjQsMjkuOUwzOS40LDI5Ljl6Ii8+PC9nPjwvc3ZnPg==);
        }

        div.type-png .thumb-container:after {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1NiA1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYgNTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPi5zdDB7ZmlsbDojODhDMDU3O30uc3Qxe2ZpbGw6IzY1OUMzNTt9LnN0MntmaWxsOiNGRkZGRkY7fTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM3LDBIOEM3LjIsMCw2LjUsMC43LDYuNSwxLjlWNTVjMCwwLjMsMC43LDEsMS41LDFINDhjMC44LDAsMS41LTAuNywxLjUtMVYxM2MwLTAuNy0wLjEtMC45LTAuMy0xLjFMMzcuNiwwLjNDMzcuNCwwLjEsMzcuMiwwLDM3LDB6Ii8+PHBvbHlnb24gY2xhc3M9InN0MSIgcG9pbnRzPSIzNy41LDAuMiAzNy41LDEyIDQ5LjMsMTIgIi8+PGc+PHBhdGggY2xhc3M9InN0MiIgZD0iTTE2LjksMzUuMWgtMS42VjI1aDIuOWMwLjQsMCwwLjksMC4xLDEuMywwLjJzMC44LDAuMywxLjEsMC42YzAuMywwLjMsMC42LDAuNiwwLjgsMXMwLjMsMC44LDAuMywxLjNjMCwwLjUtMC4xLDEtMC4zLDEuNHMtMC40LDAuOC0wLjcsMXMtMC43LDAuNS0xLjEsMC43cy0wLjksMC4yLTEuNCwwLjJoLTEuMkwxNi45LDM1LjFMMTYuOSwzNS4xeiBNMTYuOSwyNi4zdjRoMS41YzAuMiwwLDAuNCwwLDAuNi0wLjFjMC4yLTAuMSwwLjQtMC4yLDAuNS0wLjNjMC4yLTAuMiwwLjMtMC40LDAuNC0wLjZzMC4xLTAuNiwwLjEtMWMwLTAuMiwwLTAuNC0wLjEtMC42YzAtMC4yLTAuMS0wLjQtMC4zLTAuNmMtMC4xLTAuMi0wLjMtMC40LTAuNi0wLjVzLTAuNi0wLjItMS0wLjJMMTYuOSwyNi4zTDE2LjksMjYuM3oiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNMzAuOSwyNXYxMC4xaC0xLjdsLTQtNi45djYuOWgtMS43VjI1aDEuN2w0LDYuOVYyNUgzMC45eiIvPjxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik00MC43LDI5Ljl2My45Yy0wLjIsMC4zLTAuNCwwLjUtMC43LDAuNnMtMC41LDAuMy0wLjgsMC40cy0wLjYsMC4yLTAuOSwwLjJjLTAuMywwLTAuNiwwLjEtMC45LDAuMWMtMC42LDAtMS4yLTAuMS0xLjctMC4zcy0wLjktMC41LTEuMy0xcy0wLjctMS0wLjktMS42Yy0wLjItMC42LTAuMy0xLjQtMC4zLTIuMnMwLjEtMS42LDAuMy0yLjJjMC4yLTAuNiwwLjUtMS4yLDAuOS0xLjZjMC40LTAuNCwwLjgtMC44LDEuMy0xYzAuNS0wLjIsMS4xLTAuMywxLjctMC4zYzAuNSwwLDEuMSwwLjEsMS41LDAuM2MwLjUsMC4yLDAuOSwwLjUsMS4zLDAuOGwtMS4xLDFjLTAuMi0wLjMtMC41LTAuNS0wLjgtMC42Yy0wLjMtMC4xLTAuNi0wLjItMC45LTAuMmMtMC4zLDAtMC43LDAuMS0xLDAuMmMtMC4zLDAuMS0wLjYsMC4zLTAuOCwwLjZjLTAuMiwwLjMtMC40LDAuNy0wLjYsMS4ycy0wLjIsMS4xLTAuMiwxLjhjMCwwLjcsMC4xLDEuMywwLjIsMS44YzAuMSwwLjUsMC4zLDAuOSwwLjUsMS4yczAuNSwwLjYsMC44LDAuN2MwLjMsMC4yLDAuNiwwLjIsMC45LDAuMmMwLjEsMCwwLjIsMCwwLjQsMGMwLjIsMCwwLjMsMCwwLjUtMC4xYzAuMiwwLDAuMy0wLjEsMC41LTAuMXMwLjMtMC4xLDAuMy0wLjJWMzFoLTEuN3YtMS4xTDQwLjcsMjkuOUw0MC43LDI5Ljl6Ii8+PC9nPjwvc3ZnPg==);
        }

        div.type-doc .thumb-container:after {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1NiA1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYgNTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPi5zdDB7ZmlsbDojMDA5NkU2O30uc3Qxe2ZpbGw6IzAwNjJCMjt9LnN0MntmaWxsOiNGRkZGRkY7fTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM3LDBIOEM3LjIsMCw2LjUsMC43LDYuNSwxLjlWNTVjMCwwLjMsMC43LDEsMS41LDFINDhjMC44LDAsMS41LTAuNywxLjUtMVYxM2MwLTAuNy0wLjEtMC45LTAuMy0xLjFMMzcuNiwwLjNDMzcuNCwwLjEsMzcuMiwwLDM3LDB6Ii8+PHBvbHlnb24gY2xhc3M9InN0MSIgcG9pbnRzPSIzNy41LDAuMiAzNy41LDEyIDQ5LjMsMTIgIi8+PGc+PHBhdGggY2xhc3M9InN0MiIgZD0iTTIyLjUsMjkuOGMwLDAuOC0wLjEsMS41LTAuMywyLjFzLTAuNCwxLjEtMC43LDEuNXMtMC42LDAuNy0wLjksMC45cy0wLjcsMC40LTEsMC41QzE5LjMsMzQuOSwxOSwzNSwxOC44LDM1Yy0wLjMsMC0wLjUsMC0wLjYsMGgtMy44VjI1aDNjMC44LDAsMS42LDAuMSwyLjIsMC40czEuMiwwLjYsMS42LDEuMXMwLjcsMSwxLDEuNUMyMi40LDI4LjYsMjIuNSwyOS4yLDIyLjUsMjkuOHogTTE3LjYsMzMuOWMxLjEsMCwxLjktMC40LDIuNC0xLjFzMC43LTEuNywwLjctMy4xYzAtMC40LDAtMC44LTAuMS0xLjJjLTAuMS0wLjQtMC4zLTAuOC0wLjYtMS4xcy0wLjctMC42LTEuMi0wLjhzLTEuMS0wLjMtMS45LTAuM2gtMXY3LjZDMTYsMzMuOSwxNy42LDMzLjksMTcuNiwzMy45eiIvPjxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik0zMi41LDMwYzAsMC44LTAuMSwxLjYtMC4zLDIuMnMtMC41LDEuMi0wLjksMS42Yy0wLjQsMC40LTAuOCwwLjgtMS4zLDFzLTEuMSwwLjMtMS43LDAuM3MtMS4yLTAuMS0xLjctMC4zcy0wLjktMC41LTEuMy0xcy0wLjctMS0wLjktMS42cy0wLjMtMS40LTAuMy0yLjJzMC4xLTEuNiwwLjMtMi4yYzAuMi0wLjYsMC41LTEuMiwwLjktMS42YzAuNC0wLjQsMC44LTAuOCwxLjMtMXMxLjEtMC4zLDEuNy0wLjNzMS4yLDAuMSwxLjcsMC4zczAuOSwwLjUsMS4zLDFjMC40LDAuNCwwLjcsMSwwLjksMS42QzMyLjQsMjguNCwzMi41LDI5LjIsMzIuNSwzMHogTTI4LjIsMzMuOGMwLjMsMCwwLjctMC4xLDEtMC4yYzAuMy0wLjEsMC42LTAuMywwLjgtMC42YzAuMi0wLjMsMC40LTAuNywwLjYtMS4yczAuMi0xLjEsMC4yLTEuOGMwLTAuNy0wLjEtMS4zLTAuMi0xLjdjLTAuMS0wLjUtMC4zLTAuOS0wLjUtMS4ycy0wLjUtMC41LTAuOC0wLjdjLTAuMy0wLjEtMC42LTAuMi0wLjktMC4yYy0wLjMsMC0wLjcsMC4xLTEsMC4yYy0wLjMsMC4xLTAuNiwwLjMtMC44LDAuNmMtMC4yLDAuMy0wLjQsMC43LTAuNiwxLjJzLTAuMiwxLjEtMC4yLDEuOGMwLDAuNywwLjEsMS4zLDAuMiwxLjhzMC4zLDAuOSwwLjUsMS4yczAuNSwwLjUsMC44LDAuN0MyNy42LDMzLjcsMjcuOSwzMy44LDI4LjIsMzMuOHoiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNNDEuNiwzNC4xYy0wLjQsMC40LTAuOCwwLjYtMS4zLDAuOGMtMC41LDAuMi0xLDAuMy0xLjUsMC4zYy0wLjYsMC0xLjItMC4xLTEuNy0wLjNzLTAuOS0wLjUtMS4zLTFzLTAuNy0xLTAuOS0xLjZzLTAuMy0xLjQtMC4zLTIuMnMwLjEtMS42LDAuMy0yLjJjMC4yLTAuNiwwLjUtMS4yLDAuOS0xLjZjMC40LTAuNCwwLjgtMC44LDEuMy0xYzAuNS0wLjIsMS4xLTAuMywxLjctMC4zYzAuNSwwLDEuMSwwLjEsMS41LDAuM2MwLjUsMC4yLDAuOSwwLjUsMS4zLDAuOGwtMS4xLDFjLTAuMi0wLjMtMC41LTAuNS0wLjgtMC42cy0wLjYtMC4yLTAuOS0wLjJjLTAuMywwLTAuNywwLjEtMSwwLjJjLTAuMywwLjEtMC42LDAuMy0wLjgsMC42Yy0wLjIsMC4zLTAuNCwwLjctMC42LDEuMnMtMC4yLDEuMS0wLjIsMS44YzAsMC43LDAuMSwxLjMsMC4yLDEuOHMwLjMsMC45LDAuNSwxLjJzMC41LDAuNSwwLjgsMC43YzAuMywwLjEsMC42LDAuMiwwLjksMC4yczAuNi0wLjEsMC45LTAuMnMwLjUtMC4zLDAuOC0wLjZMNDEuNiwzNC4xeiIvPjwvZz48L3N2Zz4=);
        }

        div.type-zip .thumb-container:after {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1NiA1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTYgNTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPi5zdDB7ZmlsbDojNTU2MDgwO30uc3Qxe2ZpbGw6IzNGNDg1RTt9LnN0MntmaWxsOiNGRkZGRkY7fTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM3LDBIOEM3LjIsMCw2LjUsMC43LDYuNSwxLjlWNTVjMCwwLjMsMC43LDEsMS41LDFINDhjMC44LDAsMS41LTAuNywxLjUtMVYxM2MwLTAuNy0wLjEtMC45LTAuMy0xLjFMMzcuNiwwLjNDMzcuNCwwLjEsMzcuMiwwLDM3LDB6Ii8+PHBvbHlnb24gY2xhc3M9InN0MSIgcG9pbnRzPSIzNy41LDAuMiAzNy41LDEyIDQ5LjMsMTIgIi8+PGc+PHBhdGggY2xhc3M9InN0MiIgZD0iTTI0LjksMjV2MS4zbC00LjgsNy4ybC0wLjMsMC4yaDUuMVYzNWgtNi43di0xLjNsNC44LTcuMmwwLjMtMC4yaC01LjFWMjVIMjQuOXoiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNMjguOSwzNWgtMS43VjI1aDEuN1YzNXoiLz48cGF0aCBjbGFzcz0ic3QyIiBkPSJNMzMsMzVoLTEuNlYyNWgyLjljMC40LDAsMC45LDAuMSwxLjMsMC4yczAuOCwwLjMsMS4xLDAuNmMwLjMsMC4zLDAuNiwwLjYsMC44LDFzMC4zLDAuOCwwLjMsMS4zYzAsMC41LTAuMSwxLTAuMywxLjRjLTAuMiwwLjQtMC40LDAuOC0wLjcsMWMtMC4zLDAuMy0wLjcsMC41LTEuMSwwLjdzLTAuOSwwLjItMS40LDAuMkgzM0wzMywzNUwzMywzNXogTTMzLDI2LjJ2NGgxLjVjMC4yLDAsMC40LDAsMC42LTAuMWMwLjItMC4xLDAuNC0wLjIsMC41LTAuM3MwLjMtMC40LDAuNC0wLjZzMC4yLTAuNiwwLjItMWMwLTAuMiwwLTAuNC0wLjEtMC42YzAtMC4yLTAuMS0wLjQtMC4zLTAuNmMtMC4xLTAuMi0wLjMtMC40LTAuNi0wLjVzLTAuNi0wLjItMS0wLjJMMzMsMjYuMkwzMywyNi4yeiIvPjwvZz48L3N2Zz4=);
        }

        /* Warnings
*************************************/
        #warnings {
            display: none;
            padding-top: 30px;
        }

        #warnings span {
            display: block;
            padding: 15px 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>

    <!-- Wrapper -->
    <div class="wrapper">

        <section class="container-fluid inner-page">

            <div class="row">

                <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-12 full-dark-bg">

                    <!-- Files section -->
                    <h4 class="section-sub-title"><span>Upload</span> Your Files</h4>

                    <form action="file-upload.php" class="dropzone files-container">
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                        </div>
                    </form>

                    <!-- Notes -->
                    <span>Only JPG, PNG, PDF, DOC (Word), XLS (Excel), PPT, ODT and RTF files types are supported.</span>
                    <span>Maximum file size is 25MB.</span>

                    <!-- Uploaded files section -->
                    <h4 class="section-sub-title"><span>Uploaded</span> Files (<span class="uploaded-files-count">0</span>)</h4>
                    <span class="no-files-uploaded">No files uploaded yet.</span>

                    <!-- Preview collection of uploaded documents -->
                    <div class="preview-container dz-preview uploaded-files">
                        <div id="previews">
                            <div id="onyx-dropzone-template">
                                <div class="onyx-dropzone-info">
                                    <div class="thumb-container">
                                        <img data-dz-thumbnail />
                                    </div>
                                    <div class="details">
                                        <div>
                                            <span data-dz-name></span> <span data-dz-size></span>
                                        </div>
                                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                        <div class="actions">
                                            <a href="#!" data-dz-remove><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Warnings -->
                    <div id="warnings">
                        <span>Warnings will go here!</span>
                    </div>

                </div>
            </div><!-- /End row -->

        </section>

    </div>
    <!-- /Wrapper -->

    <!-- JQuery -->
    <script src="assets/js/jquery-1.10.2.min.js"></script>

    <!-- Dropzone JS -->
    <script src="assets/js/dropzone.min.js"></script>

    <!-- Main JS file -->
    <script src="assets/js/scripts.js"></script>

</body>

</html>