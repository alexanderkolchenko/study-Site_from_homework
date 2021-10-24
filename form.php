<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://query1.finance.yahoo.com/v10/finance/quoteSummary/FB?modules=price",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curl);
$arr = json_decode($response, true);

//цена акции
$regularMarketPrice = $arr["quoteSummary"]["result"][0]["price"]["regularMarketPrice"]["raw"];

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
    <h2 class="accordion-header " id="flush-headingOne">
        <button class=" accButton row align-items-center text-start accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">

            <div class="col-2"><img class="rounded-circle" src="images\tickets\Facebook.png"></div>
            <div class="col-3 fw-bold"><span class="nameTickets">Facebook</span></div>
            <div class="col-1"><span class="tickets">FB</span></div>
            <div class=" fs-6 col-3 text-end">
                <span <?php echo $priceStyle; ?> class="priceChange"><?php echo ($regularMarketChange) ?></span>
                <span <?php echo $priceStyle; ?> class="priceChangePercent ">(<?php echo ($regularMarketChangePercent) ?>)</span>
            </div>
            <div class="col-2 fw-bold text-end"><span class="priceTickets"><?php echo ($regularMarketPrice) ?></span></div>

        </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body  accordion-body1 overflow-scroll">
            <?php
            include "tradeView.php";
            ?>

        </div>
        <button type="button" class="btn btn-sm btn-success my-1 mx-5">Купить</button>

    </div>
</div>