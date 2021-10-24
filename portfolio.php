<?php
require "connection.php";
/* require "reg.php";
require "autoriz.php"; */
$user =  $_SESSION["email"];
$balance = mysqli_query($connection, "SELECT `money` FROM `users` WHERE `email` = '$user'");
$balance = mysqli_fetch_array($balance);
$balance  = $balance['money'];



//пополнение
if (isset($_POST['up']) && $_POST['up'] > 0) {

    $summUP = $_POST['up'];
    $balanceUp = mysqli_query($connection, "UPDATE `users` SET `money` =  `money` + '$summUP' WHERE `email` = '$user'");
    $balance = mysqli_query($connection, "SELECT `money` FROM `users` WHERE `email` = '$user'");
    $balance = mysqli_fetch_array($balance);
    $balance  = $balance['money'];
    $responce = [
        "status" => true,
        "message" => $balance
    ];
    echo json_encode($responce);
    exit;
}
if (isset($_POST['up']) && $_POST['up'] <= 0) { {
        $responce = [
            "status" => false,
            "message" => "сумма должна быть положительной"
        ];
        echo json_encode($responce);
        exit;
    }
}
//снятие
if (isset($_POST['down']) && $_POST['down'] > 0) {
    $summDown = $_POST['down'];
    $balanceDown = mysqli_query($connection, "UPDATE `users` SET `money` =  `money` - '$summDown' WHERE `email` = '$user'");

    if (mysqli_affected_rows($connection) <= 0) {
        $responce = [
            "status" => false,
            "message" => "недостаточно средств"
        ];
        echo json_encode($responce);
        exit;
    }

    $balance = mysqli_query($connection, "SELECT `money` FROM `users` WHERE `email` = '$user'");
    $balance = mysqli_fetch_array($balance);
    $balance  = $balance['money'];

    if (mysqli_affected_rows($connection) > 0) {
        $responce = [
            "status" => true,
            "message" => $balance
        ];
        echo json_encode($responce);
        exit;
    }
}
if (isset($_POST['down']) && $_POST['down'] <= 0) { {
        $responce = [
            "status" => false,
            "message" => "сумма должна быть положительной"
        ];
        echo json_encode($responce);
        exit;
    }
}

//продажа
if (isset($_POST['ticker'])) {
    $ticker = $_POST["ticker"];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $user =  $_SESSION["email"];

    $subtractStock = mysqli_query($connection, "UPDATE `user_stocks` SET `quantity` = quantity - '$quantity' WHERE `ticker`= '$ticker' AND `email` = '$user'");
    if (mysqli_affected_rows($connection) > 0) {
        require "trySell.php";
    } else {
        $responce = [
            "status" => false,
            "message" => "недостаточно акций"
        ];
        echo json_encode($responce);
        exit;
    }
}

?>
<div class="balance col-md-12 text-start">
    <h4>Баланс:</h4>
    <span class="costMoney">$</span><span id="balanceMoney" class="balanceMoney"><?php echo $balance; ?></span>
    <div class="d-grid gap-2 col-lg-6 col-sm-2 col-2  col-md-2">
        <button class="btn btn-my btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#topUp">Пополнить</button>
        <div class="modal fade" id="topUp" tabindex="-1" aria-labelledby="topUpLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpLabel">Пополнить баланс</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="topUpBs" class="form-label">Введите сумму</label>
                                <input id="topUpBalance" type="number" class="form-control" id="topUpBs">
                                <div id="msg4" class=" mb-3 border-0 alert px-3 fs-6 my-2 alert-danger none2" role="alert">
                                </div>
                            </div>
                            <button id="topUpBalanceBtn" type="submit" class="btn btn-sm btn-success">Подтвердить</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-sm btn-danger " data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn  btn-sm btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#withdraw">Вывести</button>
        <div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="withdrawLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawLabel">Вывести деньги</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="withdrawBs" class="form-label">Введите сумму</label>
                                <input id="topDownBalance" type="number" class="form-control" id="withdrawBs">
                                <div id="msg3" class=" mb-3 border-0 alert px-3 fs-6 my-2 alert-danger none2" role="alert">
                                </div>
                                <button id="topDownBalanceBtn" type="submit" class="btn btn-sm btn-success">Подтвердить</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn  btn-sm  btn-danger" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cost px-2 col-md-10 text-start">
    <h4>Стоимость активов:</h4>
    <span id="costMoney" class="costMoney"></span><br>
    <span class="costMoneyPercent">
        <!-- +$25,38 (0,12%) -->
    </span>

</div>
<div class="container border stocksList ">
    <div class="row text-start stocksListString ">

        <div class="col-lg-3 col-md-4 col-sm-4 col-4 ">Тикер</div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-4 "></div>
        <div class="col-lg-3 col-md-4 col-sm-4 col-4 colprice ">Цена</div>

    </div>

    <div class="row">
        <div id="reload" class="col-lg-12">
            <div class="accordion  acc-user accordion2 accordion-flush" id="accordionFlushExample1">

                <?php

                $count = mysqli_query($connection, "SELECT id, ticker, quantity FROM `user_stocks` WHERE `email` = '$user'");
                $c = array();
                while ($rws = mysqli_fetch_assoc($count)) {
                    $c[] = $rws;
                }
                $curl = curl_init();
                $cn = 1;

                foreach ($c as $k => $v) {

                    $ticker = $v["ticker"];
                    $quantity = $v["quantity"];
                    $id = $v["id"];
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://query1.finance.yahoo.com/v10/finance/quoteSummary/$ticker?modules=price",
                        CURLOPT_RETURNTRANSFER => true,
                    ]);

                    $response = curl_exec($curl);
                    $arr = json_decode($response, true);

                    //цена акции
                    $regularMarketPrice1 = round($arr["quoteSummary"]["result"][0]["price"]["regularMarketPrice"]["raw"], 2);
                ?>


                    <div id="item-del<?php echo $cn  ?>" class="accordion-item item-del">
                        <h2 class="accordion-header" id="heading<?php echo $id ?>">
                            <button class="accordion-button portButton collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $id ?>" aria-expanded="false" aria-controls="collapse<?php echo $id ?>">
                                <div class="col-4 "><span class="ticketsList"><?php echo $ticker ?></span></div>
                                <div class="col-4 col-sm-4">
                                    <span class="priceChangeList"><?php echo $quantity ?></span>
                                </div>
                                <div class="col-4 col-sm-3 text-start">
                                    <span class="priceTicketsList" id="priceTicketsList<?php echo $id ?>">$<?php echo ($regularMarketPrice1 * $quantity) ?></span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $id ?>" data-bs-parent="#accordionFlushExample1">
                            <div class="  d-grid gap-2 col-lg-6 col-sm-2 col-2 py-1 col-md-2"> <button type="button" id="openFormSell<?php echo $id ?>" class=" openFormSell btn ms-1 btn-warning btn-sm">Продать</button></div>
                            </span>
                            <div class="  msgSellStocks none2 px-0">
                                <form class="container mb-3 d-inline msgSellStocks border-0 alert p-0 px-1 my-auto none2 ">
                                    <div class="d-flex justify-content-around container-fluid px-1">
                                        <input type="text" id="priceStocksSellInput<?php echo $id ?>" min="1" readonly class="border border-light  col-5  border-2 priceStocksSellInput text-end my-1 " placeholder="$цена">
                                        <input type="number" id="stocksSellInput<?php echo $id ?>" min="1" max="<?php echo $quantity  ?>" class=" stocksSellInput  col-5 text-end my-1 " placeholder="кол-во">
                                    </div>
                                    <div class="container-fluid d-flex px-1 justify-content-around">
                                        <button type="submit" class=" btnSellConfirm btn btn-sm btn-outline-success my-1 col-5  mx-1 text-center">Ок</button>
                                        <button type="button" class=" btnSellCancel btn  px-0 btn-sm btn-outline-danger col-5  my-1 mx-1 text-center">Отмена</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                <?php
                    $cn++;
                }
                ?>

            </div>
        </div>

    </div>

</div>
<div id="nothing" class=" none2 text-center my-5 fs-4 text-success font-weight-bold ">Выберите акции для покупки</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // пополнение
    $('#topUpBalanceBtn').click(function(e) {
        e.preventDefault();
        var up = $('#topUpBalance').val();
        $.ajax({
            url: 'portfolio.php',
            type: 'POST',
            dataType: 'json',
            data: {
                up: up
            },
            success(data) {
                if (data.status) {
                    /* document.location = 'index.php'; */
                    $('.balanceMoney').text(data["message"]);
                    $('#msg4').addClass('none2')
                } else {
                    $('#msg4').removeClass('none2').text(data["message"]);
                }
            }
        });
    })

    //снятие 

    $('#topDownBalanceBtn').click(function(e) {
        e.preventDefault();
        var down = $('#topDownBalance').val();
        $.ajax({
            url: 'portfolio.php',
            type: 'POST',
            dataType: 'json',
            data: {
                down: down
            },
            success(data) {
                if (data.status) {
                    /*  document.location = 'index.php'; */
                    $('.balanceMoney').text(data["message"]);
                    $('#msg3').addClass('none2')

                } else {
                    $('#msg3').removeClass('none2').text(data["message"]);
                }
            }
        });
    })

    //ввод количества акций на продажу

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
    function countBalance() {
        var actSummArr = $('.priceTicketsList');
        var actSumm = 0;
        for (let i of actSummArr) {
            actSumm += +i.innerHTML.substring(1)
        }
        $('#costMoney').html('$' + (actSumm.toFixed(2)))
       
        if (actSumm == 0) {
            $('#nothing').removeClass('none2');
        }

    }

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
</script>