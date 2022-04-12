<?php

$regex = "/^(\d{1,4}|10000)\n(\d+\s\d+\n?)+$/";

$fileStr = file_get_contents("in.txt");

if (!preg_match($regex, $fileStr)) {
    die("Problema en la estructura del archivo" . PHP_EOL);
}

$content = explode("\n", $fileStr);
$rondas =  intval($content[0]);

if ($rondas + 1 != count($content)) {
    die("$rondas coincide con el numero de rondas." . PHP_EOL);
}

for ($i = 1; $i <= $rondas; $i++) {
    $aux = explode(" ", $content[$i]);
    $x = intval($aux[0]);
    $y = intval($aux[1]);

    $ventaja[] = $x - $y;

    if ($ventaja[$i - 1] > 0) {
        $ganador[] = 1;
    } else {
        $ganador[] = 2;
        $ventaja[$i - 1] = $ventaja[$i - 1] * -1;
    }
}

$max = $ventaja[0];
$win = $ganador[0];

for ($i = 1;$i<$rondas;$i++) {
    if ($max < $ventaja[$i]){
        $max = $ventaja[$i];
        $win = $ganador[$i];
    }
}

$outFile = fopen("out.txt", "w");

fwrite($outFile,"$win $max");

fclose($outFile);
