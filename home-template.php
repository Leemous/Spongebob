<?php
/**
 * Created by PhpStorm.
 * User: limeng
 * Date: 2017/6/22
 * Time: 23:32
 * Template Name: Home
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title>海绵BB的BB站</title>
    <link href="<?php echo esc_url(get_option( 'favicon', '' )) ?>" rel="icon" type="image/png" />
    <link rel="shortcut icon" href="<?php echo esc_url(get_option( 'favicon', '' )) ?>" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <style type="text/css">
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .az-main-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .az-main-wrapper:before,
        .az-main-wrapper:after {
            content: '';
            display: table;
        }

        .az-main-wrapper:after {
            clear: both;
        }

        .az-nav-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 300px;
            z-index: 1000;
            padding-top: 40px;
            border-right: 1px solid #2A2871;
        }

        .az-nav-wrapper h1 {
            text-transform: uppercase;
            color: #FFF;
            padding-left: 40px;
            letter-spacing: 4px;
        }

        .az-nav-wrapper .az-nav-bar {
            margin-top: 50px;
        }

        .az-nav-bar>ul {
            padding-left: 60px;
            list-style: none;
        }

        .az-nav-bar>ul>li {
            position: relative;
            padding-left: 15px;
            margin: 30px 0;
        }

        .az-nav-bar>ul>li>a {
            position: relative;
            display: block;
            text-decoration: none;
            color: #FFF;
            padding-top: 25px;
        }

        .az-nav-bar>ul>li>a>span {
            text-transform: uppercase;
        }

        .az-nav-bar>ul>li>a .az-nav-text {
            font-size: 16px;
            letter-spacing: 2px;
        }

        .az-nav-bar>ul>li>a .az-nav-shadow {
            position: absolute;
            left: 10px;
            bottom: 0;
            z-index: -1;
            font-size: 30px;
            letter-spacing: 6px;
            color: #322D6F;
        }

        .az-nav-bar>ul>li.az-active:before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 3px;
            width: 4px;
            height: 20px;
            background-color: #6E87D7;
        }

        .az-main-content {
            position: absolute;
            top: 0;
            left: 300px;
            bottom: 0;
            right: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .slogan {
            width: 100%;
            font-size: 30px;
            height: 50px;
            line-height: 50px;
            color: #FFF;
            position: absolute;
            top: 50%;
            margin-top: -25px;
            text-align: center;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <canvas id="myCanvas"></canvas>
    <div class="az-main-wrapper">
        <div class="az-nav-wrapper">
            <h1>Yungjen</h1>
            <nav class="az-nav-bar">
                <ul>
                    <li>
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">design</span>
                            <span class="az-nav-shadow">vision</span>
                        </a>
                    </li>
                    <li class="az-active">
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">ux</span>
                            <span class="az-nav-shadow">user x</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">lab</span>
                            <span class="az-nav-shadow">lab</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">movie</span>
                            <span class="az-nav-shadow">movie</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">music</span>
                            <span class="az-nav-shadow">music</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span class="az-nav-text">about me</span>
                            <span class="az-nav-shadow">Yungjen</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="az-main-content">
            <div class="slogan">永恒的都不畅销，我还是为你倾倒</div>
        </div>
    </div>
    <script type="text/javascript">
        var _canvas = document.getElementById('myCanvas');
        _canvas.width = window.innerWidth;
        _canvas.height = window.innerHeight;
        _canvas.style.backgroundColor = '#301B56';

        var _ctx = _canvas.getContext('2d');
        // 绘制波纹
        var xPoint = _canvas.width / 2;
        var yPoint = -50;
        console.log(xPoint);

        _ctx.beginPath();
        _ctx.strokeStyle = '#2d526f';
        _ctx.arc(xPoint, yPoint, 100, 0, Math.PI, false);
        _ctx.stroke();

        _ctx.arc(xPoint, yPoint, 105, 0, Math.PI, false);
        _ctx.stroke();
    </script>
</body>
</html>