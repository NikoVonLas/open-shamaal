<?php
    require_once('../include.php');

    echo <<<EOT
        <html>
            <head>
                <title>Shamaal World</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <link rel="stylesheet" type="text/css" href="/assets/css/style.css?rev=122">
            </head>
            <span id=iframetext>
                {$player['text']}
            </span>
        </html>
EOT;
