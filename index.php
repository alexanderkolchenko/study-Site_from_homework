<?php
require "connection.php";
//session_start();

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="styles/style.css">
    <title>StocksMarket</title>
</head>

<body class="text-body">
    <div class="row">
        <div class="col-1"></div>
        <div class=" col-10">
            <nav class=" navbar bg-white navbar-expand-lg navbar-light bg-light">
                <div class=" container"> 
                    <a href="#"><img class = "logo" src="images/logo.png"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarScroll">
                        <ul class=" navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                            <li class=" ms-lg-5 nav-item">
                                <a class="nav-link text-dark" aria-current="page" href="#">Новости</a>
                            </li>
                            <li class=" nav-item">
                                <a class=" nav-link text-dark" href="#">Биржа</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link text-dark" href="#">Контакты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#">Поддержка</a>
                            </li>

                        </ul>
                        <div id="nameUsers" class="col-md-3 col-sm-4 text-start mt-sm-4 mt-lg-0 mt-md-4">
                            <?php

                            if (isset($_SESSION['email'])) {
                                echo $_SESSION['email'];
                            }
                            ?>
                        </div>
                        <div class="col-md-2 text-start text-md-end mt-sm-4  mt-lg-0 mt-md-4">
                            <?php if (!isset($_SESSION['email'])) {
                            ?>
                                <a data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Войти<img src="images/box-arrow-in-right.svg"></a>
                            <?
                            }
                            ?>
                            <?php if (isset($_SESSION['email'])) {
                            ?>
                                <a href="exit.php">Выйти<img src="images/box-arrow-in-left.svg"></a>

                            <?
                            }
                            ?>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Вход</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php include "login.php" ?>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#exampleModal1">Регистрация</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Регистрация</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            include "regForm.php";
                                            ?>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm  btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-1"></div>
    </div>
    <hr id="hr1">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">

            <nav class="navbar bg-white navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <div class=" collapse navbar-collapse nav4 " id="navbarScroll">

                        <ul class=" navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                            <li class=" nav-item">
                                <a class="nav-link text-dark" aria-current="page" href="#">Портфель</a>
                            </li>
                            <li class=" nav-item  ">
                                <a class=" nav-link text-dark" href="#">Инвестиционные идеи</a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link text-dark" href="#">Образование</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark" href="#">Планирование</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark" href="#">Рынки</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark" href="#">Криптовалюты</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark" href="#">Прогнозы</a>
                            </li>

                        </ul>


                    </div>
                </div>
            </nav>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="container px-5 px-sm-5">
        <div class="row  justify-content-md-center px-0">

            <form class="d-flex col-md-10 my-3 px-0">
                <input class="w-50 form-control bg-light border-secondary me-2" type="search" placeholder="Поиск..." aria-label="Search">
                <button class="btn btn-outline-secondary bg-light" type="submit"><img src="images/search.svg"></button>
            </form>
        </div>
    </div>
    <div class="container px-0">

        <div id="carouselExampleControls" data-bs-interval="0" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php include "carousel.php" ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                <span class="visually-hidden">Предыдущий</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="false"></span>
                <span class="visually-hidden">Следующий</span>
            </button>
        </div>
        <div class=" row ">
            <div class="col-lg-10 col-sm-12  mx-lg-auto mx-sm-0 line1">
            </div>

        </div>

    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-6 line2">
                <a class="col" href="#">Акции</a>
                <a class="col" href="#">Валюта</a>
                <a class="col" href="#">Облигации</a>
                <a class="col" href="#">Фонды</a>
                <a class="col" href="#">Нефть</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1"> </div>
            <div class="col-lg-6 clas1 mt-2">
                <div class="accordion accordion1 accordion-flush" id="accordionFlushExample">
                    <?php include "accordeon.php"; ?>
                </div>
            </div>
            <div class="col-lg-1"> </div>

            <div class=" InnerMyPortfolio border col-xl-3 col-lg-3">
                <div class="container myPortfolio">
                    <?php
                    if (isset($_SESSION['email'])) include "portfolio.php";
                    else {
                    ?>
                        <div class="container text-center my-5 border">
                            <button type="button" class="btn my-3 btn-warning btn-lg" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#exampleModal1">Открыть счет</button>
                            <div class="text-center">Если у вас уже есть счет, войдите в <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-primary" href="#">личный кабинет</a></div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-1"> </div>
        </div>
    </div>
    <hr>

    <footer class="footer">

        <div class="container c1">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="container">
                        <div class="row mt-3 r2">
                            <div class="col-md-3"><a href="#">Партнерство</a></div>
                            <div class="col-md-2"><a href="#">Работа</a></div>
                            <div class="col-md-2"><a href="#">Контакты</a></div>
                            <div class="col-md-2"><a href="#">Помощь</a></div>
                            <div class="col-md-3 text-lg-end align-self-end"><a href="#">8-800-555-35-35</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
        <div class="container c1">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="container">
                        <div class="row mt-3 r2">
                            <div class="col-md-9 col-sm-9 col-9"></div>
                            <div class="col-md-3 col-sm-3 text-lg-end col-3 text-center">
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                    </svg></a>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                                    </svg></a>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                    </svg></a>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                    </svg></a>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </footer>
    <script>
        (function() {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>