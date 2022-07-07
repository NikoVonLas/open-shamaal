<?php
    require_once('../include.php');

    echo <<<EOT
    <html>
        <head>
            <title>Shamaal World</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
                <script type="text/javascript" src="/assets/js/jquery.noty.packaged.min.js"></script>
                <link rel="stylesheet" type="text/css" href="/assets/css/style.css?rev=122">
        </head>
        <table cellpadding="3" cellspacing="0" width="100%" height="100%">
            <tr>
                <td class="mainb" id="tbox" valign="top"></td>
            </tr>
        </table>
        <script>
            if (parent.makechat) parent.makechat();
        </script>
    </html>
EOT;
