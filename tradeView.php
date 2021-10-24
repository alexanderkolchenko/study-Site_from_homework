<div class="tradingview-widget-container">
    <div id="tradingview_bebeb"></div>
    <div class="tradingview-widget-copyright"><a href="https://ru.tradingview.com/symbols/NASDAQ-<?php echo $ticket ?>/" rel="noopener" target="_blank"><span class="blue-text">График <?php echo $ticket ?></span></a> от TradingView</div>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget({
            "height": 350,
            "symbol": "NASDAQ:<?php echo $ticket ?>",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": "light",
            "style": "1",
            "locale": "ru",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_bebeb"
        });
    </script>
</div>


<!-- TradingView Widget BEGIN -->
<!-- <div class="tradingview-widget-container">
    <div id="tradingview_d141e"></div>
    <div class="tradingview-widget-copyright"><a href="https://ru.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span class="blue-text">График AAPL</span></a> от TradingView</div>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget({
            "width": 980,
            "height": 610,
            "symbol": "NASDAQ:AAPL",
            "interval": "1",
            "timezone": "Etc/UTC",
            "theme": "light",
            "style": "1",
            "locale": "ru",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_61d7a"
        });
    </script>
</div> -->
<!-- TradingView Widget END -->

