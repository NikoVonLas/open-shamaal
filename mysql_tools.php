<?php
    function Get_IP()
    {
        global $_SERVER;
        $iphost1 = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $iphost2 = $_SERVER['REMOTE_ADDR'];
        $iphost = "{$iphost2};{$iphost1};";
        return $iphost;
    }

    function removeSleepAndBenchmark($sql)
    {
        $output = preg_replace_callback('/(benchmark|sleep)\(([^)]*)\)/i', function ($matches) use ($sql) {
            $file = fopen("sql_expoits.log", "ab");
            $ip = Get_IP();
            fwrite($file, "$ip $sql\r\n");
            fclose($file);

            return str_ireplace('e', 'е', $matches[1]).'('.$matches[2].')';
        }, $sql);

        return $output;
    }
