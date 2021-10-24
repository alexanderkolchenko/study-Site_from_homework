<div class="carousel-item active">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row justify-content-md-center">
                <?php
                $symbolIndex = [
                    "S&P 500" => "^GSPC",
                    "Nikkei 225" => "^N225",
                    "Dow Jones" => "^DJI",
                    "NASDAQ" => "^IXIC",
                    "Russell 2000" => "^RUT"
                ];
                $curl = curl_init();

                foreach ($symbolIndex as $k => $v) {
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://query1.finance.yahoo.com/v10/finance/quoteSummary/$v?modules=price",
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
                    <div class="thumb-content col">
                        <h4><a href="#"><?php echo $k ?></a></h4>
                        <span class="item-price"><?php echo $regularMarketPrice ?></span><br>
                        <span <?php echo $priceStyle; ?> class="difference-price"><?php echo $regularMarketChange ?>(<?php echo $regularMarketChangePercent ?>)</span>

                    </div>
                <?php
                }


                ?>


            </div>
        </div>

    </div>
</div>
<div class="carousel-item">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="row justify-content-md-center">
                <?php
                $symbolIndex = [
                    "FTSE 100" => "^FTSE",
                    "CAC 40" => "^FCHI",
                    "STI Index" => "^STI",
                    "HANG SENG" => "^HSI",
                    "S&P/ASX 200" => "^AXJO"
                ];
                $curl = curl_init();

                foreach ($symbolIndex as $k => $v) {
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://query1.finance.yahoo.com/v10/finance/quoteSummary/$v?modules=price",
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
                    <div class="thumb-content col">
                        <h4><a href="#"><?php echo $k ?></a></h4>
                        <span class="item-price"><?php echo $regularMarketPrice ?></span><br>
                        <span <?php echo $priceStyle; ?> class="difference-price"><?php echo $regularMarketChange ?>(<?php echo $regularMarketChangePercent ?>)</span>

                    </div>
                <?php
                }


                ?>
            </div>
        </div>

    </div>
</div>