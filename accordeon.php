<?php
require "connection.php";
if (isset($_SESSION['email'])) {
    $user =  $_SESSION["email"];
}

if (isset($_POST["ticker"])) {
    $ticker = $_POST["ticker"];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    //проверка на наличие акций у пользователя
    $stocksCheck = mysqli_query($connection, "SELECT * FROM `user_stocks` WHERE  `email` = '$user'");
    $deleteMoney = mysqli_query($connection, "UPDATE `users` SET `money` = `money` - '$price' WHERE `email` = '$user'");

    if (!$deleteMoney) {
        $responce = [
            "status" => false,
            "message" => "недостаточно средств"
        ];
        echo json_encode($responce);
        exit;
    }

    //если нет пользователя его добавить
    if (mysqli_num_rows($stocksCheck) == 0) {
        $result1 = mysqli_query($connection, "INSERT INTO `user_stocks` (`email`, `ticker`, `quantity`) VALUES ('$user', '$ticker', '$quantity')");
        $resp = [
            "status" => true,
            "ticker" => $ticker,
            "quantity" => $quantity,
            "newstock" => true
        ];
        echo json_encode($resp);
        exit;
    } else {

        //добавить акции если есть
        mysqli_query($connection, "UPDATE `user_stocks` SET `quantity` = quantity + '$quantity' WHERE `ticker`= '$ticker' AND `email` = '$user'");

        if (mysqli_affected_rows($connection) > 0) {
            $resp = [
                "status" => true,
                "ticker" => $ticker,
                "quantity" => $quantity,                
            ];
            echo json_encode($resp);
            exit;
        }
        //добавить акции купленные впервые

        if (!mysqli_affected_rows($connection)) {
            $result = mysqli_query($connection, "INSERT INTO `user_stocks` (`email`, `ticker`, `quantity`) VALUES ('$user', '$ticker', '$quantity')");
            if ($result == 1) {
                $resp = [
                    "status" => true,
                    "ticker" => $ticker,
                    "newstock" => true,
                    "quantity" => $quantity
                ];
                echo json_encode($resp);
                exit;
            }
        }
    }
}

// получение массива акций из бд
$count = mysqli_query($connection, "SELECT stock_id, logo, name, ticket FROM `stocks`");
$c = array();
while ($rws = mysqli_fetch_assoc($count)) {
    $c[] = $rws;
}

$curl = curl_init();

//распечатка аккордеона с ценами
foreach ($c as $k => $v) {

    $stock_id = $v["stock_id"];
    $logo = $v["logo"];
    $nameStock = $v["name"];
    $ticket = $v["ticket"];


    curl_setopt_array($curl, [
        CURLOPT_URL => "https://query1.finance.yahoo.com/v10/finance/quoteSummary/$ticket?modules=price",
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $response = curl_exec($curl);
    $arr = json_decode($response, true);

    //цена акции
    $regularMarketPrice = round($arr["quoteSummary"]["result"][0]["price"]["regularMarketPrice"]["raw"], 2);

    //изменение цены 
    $regularMarketChange = $arr["quoteSummary"]["result"][0]["price"]["regularMarketChange"]["fmt"];

    //изменение цены в процентах
    $regularMarketChangePercent = $arr["quoteSummary"]["result"][0]["price"]["regularMarketChangePercent"]["fmt"];

    //цвет текста изменения цены, красный и зеленый
    $priceStyle  = '';
    if ($regularMarketChange < 0) {
        $priceStyle = "style='color: red'";
    }
?>
    <div class="accordion-item">
        <h2 class="accordion-header " id="flush-heading<?php echo $stock_id ?>">
            <button id="buttonGraf<?php echo $stock_id ?>" class=" accButton row align-items-center text-start accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $stock_id ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $stock_id ?>">

                <div class="col-2"><img class="rounded-circle" src="images\tickets\<?php echo $logo ?>"></div>
                <div class="col-3 fw-bold"><span id="nameTickets" class="nameTickets"><?php echo $nameStock ?></span></div>
                <div class="col-1 text-start px-0"><span id="tickets<?php echo $stock_id ?>" class="tickets "><?php echo $ticket ?></span></div>
                <div class=" fs-6 col-3 text-end">
                    <span <?php echo $priceStyle; ?> class="priceChange"><?php echo ($regularMarketChange) ?></span>
                    <span <?php echo $priceStyle; ?> class="priceChangePercent ">(<?php echo ($regularMarketChangePercent) ?>)</span>
                </div>
                <div class="col-2 fw-bold text-end"><span id="priceTickets<?php echo $stock_id ?>" class="priceTickets"><?php echo ($regularMarketPrice) ?></span></div>

            </button>
        </h2>
        <div id="flush-collapse<?php echo $stock_id ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $stock_id ?>" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body  accordion-body1 overflow-scroll">
                <div class="tradingview-widget-container">
                    <div id="tradingview_bebeb<?php echo $stock_id ?>"></div>

                    <!--  сюда вставить График -->
                </div>

            </div>
            <div class="container-fluid w-100">
                <span class="col-md-2 col-sm-2">
                    <button type="button" id="openFormBuy<?php echo $stock_id ?>" class="openFormBuy btn col-md-2 col-sm-2 btn-buy btn-sm btn-success my-1 mx-2">Купить</button>
                    <span class=" mb-3  msgByu border-0 alert p-0 px-1 my-auto alert-danger none2 " role="alert"> Войдите или зарегистрируйтесь
                    </span>
                </span>
                <span class=" msgByuStocks none2 col-md-10 col-sm-10 px-0">
                    <form class="container mb-3 d-inline msgByuStocks border-0 alert p-0 px-1 my-auto none2 ">
                        <input type="text" id="priceStocksBuyInput<?php echo $stock_id ?>" min="1" readonly class="border border-light border-2 priceStocksBuyInput text-end my-1 col-md-2 col-2" placeholder="$цена">
                        <input type="number" id="stocksBuyInput<?php echo $stock_id ?>" min="1" class=" stocksBuyInput text-end my-1 col-md-2 col-2" placeholder="кол-во">

                        <span class="col-md-2">
                            <button type="submit" class=" btnBuyConfirm   btn col-md-2  btn-sm btn-outline-success my-1 mx-1 text-center">Ок</button>
                            <button type="button" class=" btnBuyCancel btn col-md-2 px-0 btn-sm btn-outline-danger my-1 mx-1 text-center">Отмена</button>
                        </span>
                    </form>
                </span>
                <div class="msgNoMoney mb-3 border-0 alert px-1 py-1 fs-6 my-2 alert-danger text-center none2"></div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById("buttonGraf" + "<?php echo $stock_id ?>").onclick = function() {
            var pole = document.getElementById("tradingview_bebeb" + "<?php echo $stock_id ?>");

            document.getElementById("tradingview_bebeb" + "<?php echo $stock_id ?>").innerHTML =
                ` <div id="linkGrafik<?php echo $stock_id ?>" class="tradingview-widget-copyright"><a href="https://ru.tradingview.com/symbols/NASDAQ-<?php echo $ticket ?>/" rel="noopener" target="_blank"><span class="blue-text">График <?php echo $ticket ?></span></a> от TradingView</div>`


            document.getElementById("linkGrafik" + "<?php echo $stock_id ?>").innerHTML = new TradingView.widget({
                "height": 350,
                "symbol": "<?php echo $ticket ?>",
                "interval": "1",
                "timezone": "Etc/UTC",
                "theme": "light",
                "style": "1",
                "locale": "ru",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "container_id": "tradingview_bebeb<?php echo $stock_id ?>"
            });;
        }
    </script>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<?php
}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var accItem = document.getElementsByClassName('accordion-item').length;

    //скрытие формы покупки если нет регистрации
    $('.btn-buy').click(function() {
        var userName = document.getElementById("nameUsers").innerHTML.trim().replace(/\r?\n/g, "")
        if (userName == "") {
            $('.msgByu').removeClass('none2');
        } else {
            $('.msgByuStocks').removeClass('none2');
        }
    })

    //скрытие формы покупки при отмене
    $('.accButton, .btnBuyCancel').click(function() {
        $('.stocksBuyInput').val('');
        $('.msgByuStocks').addClass('none2');
        $('.msgNoMoney').addClass('none2');
    })

    //ввод количества акций на покупку

    $('.openFormBuy').click(function() {
        var id = $(this).attr('id').substring(11); // номер из id

        var idQuan = '#stocksBuyInput' + id; // количество акций
        var idPrice = '#priceTickets' + id; // цена одной акции
        var idSumm = '#priceStocksBuyInput' + id; // цена введенного количества

        function count() {
            var quantity = $(idQuan).val();
            var price = $(idPrice).html();
            var summPrice = $(idSumm);
            var summ = "$" + (quantity * price).toFixed(2)
            $(idSumm).val(summ)
        }

        $('.stocksBuyInput').keyup(function() {
            count()
        })

        $('.stocksBuyInput').click(function() {
            count()
        })

    })

    //покупка
    $('.btnBuyConfirm').click(function(e) {
        e.preventDefault();
        var quantity;
        var ticker;
        var price;
        var balance = $('#balanceMoney').html();

        for (let i = 1; i <= accItem; i++) {
            if (quantity) {
                break;
            }
            var id1 = '#stocksBuyInput' + i;
            var id2 = '#tickets' + i;
            var id3 = '#priceTickets' + i;
            quantity = $(id1).val();
            ticker = $(id2).html();
            price = $(id3).html();
            price = price * quantity;
        }

        if (quantity > 0) {
            $('#nothing').addClass('none2');
            $.ajax({
                url: 'accordeon.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ticker: ticker,
                    quantity: quantity,
                    price: price

                },
                success(data) {
                    if (data.status) {
                        $('.msgNoMoney').addClass('none2').html();
                        $('#balanceMoney').html((balance - price).toFixed(2));
                        $('.priceStocksBuyInput').val('')
                        $('.stocksBuyInput').val('')
                        var add = parseInt($('#costMoney').html().substring(1)) + price;
                        $('#costMoney').html('$' + add.toFixed(2))

                        var oldCost
                        var oldQuan
                        var actTickArr = $('.ticketsList');
                        for (let i of actTickArr) {
                            if (i.innerHTML == data.ticker) {
                                oldCost = +$(i).parent().parent().children('.text-start').children().html().substring(1) + price
                                $(i).parent().parent().children('.text-start').children().html('$' + oldCost.toFixed(2))
                                oldQuan = +$(i).parent().parent().children('.col-sm-4').children().html() + (+quantity)
                                $(i).parent().parent().children('.col-sm-4').children().html(oldQuan)
                            }
                        }
                        //изменение max input
                        let arr = $('.item-del').find('.ticketsList')

                        for (var i of arr) {
                            if (i.innerHTML == ticker) {
                                $(this).parent().parent().parent().parent().children('.collapse').children('.msgSellStocks').find('.stocksSellInput').attr(max = oldQuan)
                            }
                        }

                        if (data.newstock) {

                            //снятие обработчика если есть

                            $('#reload').load('portfolio.php #accordionFlushExample1').unbind('click', newEvent);

                            //добавление обработчика при перезагрузке портфеля
                            var newEvent = function() {
                                var quantity;
                                var ticker
                                var fieldSellPrice
                                var idDel
                                $('.item-del').click(function() {
                                    idDel = '#' + $(this).attr('id')
                                })
                                $('.openFormSell').click(function() {

                                    var price = +$(this).parent().parent().parent().find('.priceTicketsList').html().substring(1);
                                    var quantity = +$(this).parent().parent().parent().find('.priceChangeList').html();
                                    ticker = $(this).parent().parent().parent().find('.ticketsList').html();

                                    var priceForOne = (price / quantity).toFixed(2);
                                    fieldSellPrice = $(this).parent().parent().find('.priceStocksSellInput')
                                    var fieldSellQuan = $(this).parent().parent().find('.stocksSellInput')

                                    $('.msgSellStocks').removeClass('none2');

                                    function count() {
                                        var q = fieldSellQuan.val()
                                        var s = '$' + (q * priceForOne).toFixed(2)
                                        fieldSellPrice.val(s)
                                    }

                                    $('.stocksSellInput').keyup(function() {
                                        count()
                                    })

                                    $('.stocksSellInput').click(function() {
                                        count()
                                    })

                                })
                                //скрытие формы продажи при отмене
                                $('.portButton, .btnSellCancel').click(function() {
                                    $('.stocksSellInput').val('');
                                    $('.msgSellStocks').addClass('none2');
                                })


                                //подсчет баланса

                                countBalance()

                                //продажа

                                $('.btnSellConfirm').click(function(e) {
                                    e.preventDefault();
                                    var quantity = $(this).parent().parent().find('.stocksSellInput').val();
                                    var price = +$(this).parent().parent().find('.priceStocksSellInput').val().substring(1);
                                    var newPrice = +$(this).parent().parent().parent().parent().parent().find('.priceTicketsList').html().substring(1)
                                    newPrice = newPrice.toFixed(2)
                                    $(this).parent().parent().parent().parent().parent().find('.priceTicketsList').html('$' + (newPrice - price).toFixed(2));
                                    var q = $(this).parent().parent().parent().parent().parent().find('.priceChangeList')
                                    $(this).parent().parent().find('.stocksSellInput').attr('max', (+q.html() - quantity))

                                    if (quantity > 0) {
                                        $.ajax({
                                            url: 'portfolio.php',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                ticker: ticker,
                                                quantity: quantity,
                                                price: price

                                            },
                                            success(data) {
                                                if (data.status) {
                                                    var balance = +$('#balanceMoney').html();
                                                    $('#balanceMoney').html((balance + price).toFixed(2));
                                                    q = q.html(q.html() - quantity)
                                                    var sub = parseInt($('#costMoney').html().substring(1)) - price;
                                                    $('#costMoney').html('$' + sub.toFixed(2))
                                                    $('.priceStocksSellInput').val('')
                                                    $('.stocksSellInput').val('')
                                                    countBalance()

                                                    if (data.isset == false) {
                                                        $(idDel).remove()
                                                    }
                                                }
                                            }
                                        });
                                    }
                                })
                            }
                            $('#reload').load('portfolio.php #accordionFlushExample1').one('click', newEvent);
                        }
                    } else {
                        $('.msgNoMoney').removeClass('none2').html(data.message);
                    }
                }
            });
        }
    })
</script>