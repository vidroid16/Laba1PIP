<?php
session_start();
function isInArrange($x, $y, $r){
    if(($x<=-$r && $y<=(-$r/2) && $x<=0 && $y<=0)
        || (((pow($x,2)+pow($y,2))<=pow($r/2,2)) && $x<=0 && $y>=0)
        || (($r>=$x-$y) && $x>=0 && $y<=0)){

        return "Точка входит в диапазон";

    }else{
        return "Точка не входит в диапазон";
    }
}
function roundDown($num){
    if (!strpos($num, ".")){
        return $num;
    }
    $int = intval(strstr($num, ".", true));
    $float = floatval("0." . substr(strstr($num, ".", false), 1, 13));
    if ($int < 0 || $num{0} == "-") {
        $retval = $int - $float;
    } else {
        $retval = $int + $float;
    }
    return $retval;
}

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

global $results;
$results = [];
$begin = microtime(true);
$x = $_GET["x"];
$y = $_GET["y"];
$r = $_GET["r"];

if ($x == null || $y == null || $r == null){
    $not_null = false;
}else{
    $not_null = true;
}
$correct = false;
const X_VALUES = [-2.5, -2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2, 2.5];
const R_VALUES = [1, 2, 3, 4, 5];
$is_numeric = is_numeric($x) && is_numeric($y) && is_numeric($r);
if ($is_numeric){
    $x = roundDown($x);
    $y = roundDown($y);
    $r = roundDown($r);
}
$is_correct = in_array($x, X_VALUES)
    && ($y > -5 && $y < 3)
    && in_array($r, R_VALUES);

if ($is_numeric && $is_correct && $not_null) {

    $result = isInArrange($x, $y, $r);
    $time = date('D, d M Y H:i:s e');
    $script_time = round((microtime(true) - $begin) * 1000, 8) . " ms";

    $res = isset($_SESSION['results']) && is_array($_SESSION['results']) ? $_SESSION['results'] : [];
        array_unshift($res, [
            'x' => $x,
            'y' => $y,
            'r' => $r,
            'result' => $result,
            'time' => $time,
            'script_time' => $script_time
        ]);
        $_SESSION['results'] = $res;
}else{
    $result="Были некорректно введены данные";
    $time = date('D, d M Y H:i:s e');
    $script_time = round((microtime(true) - $begin) * 1000, 8) . " ms";
}
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script type="text/javascript" src="jquery-3.4.1.js"></script>
</head>
<body onload="docLoad()">
    <div id="main_hat" class="hat">
        <table>
            <tr>
                <td>Студент: </td><td>Шаля Андрей</td>
            </tr>
            <tr>
                <td>Группа: </td><td>P3211</td>
            </tr>
            <tr>
                <td>Вариант: </td><td>211022</td>
            </tr>
        </table>
    </div>
    <h1 id="lab_name" class="title">Лабораторная работа №1 по ВЕБ-Программированию</h1>
    <div id="logic">
        <div id="graph-container">
            <img src="pip_task.jpg"/>
        </div>
        <div id="table-grid-container">
            <div id="table_container">
                    <div>
                        <div id="buttons">
                            <div id="X" class="vars x-coord">
                                X
                                <label><input type="radio" value="-2.5" name="x">-2.5</label>
                                <label><input type="radio" value="-2" name="x">-2</label>
                                <label><input type="radio" value="-1.5" name="x">-1.5</label>
                                <label><input type="radio" value="-1" name="x">-1</label>
                                <label><input type="radio" value="-0.5" name="x">-0.5</label>
                                <label><input type="radio" value="0" name="x">0</label>
                                <label><input type="radio" value="0.5" name="x">0.5</label>
                                <label><input type="radio" value="1" name="x">1</label>
                                <label><input type="radio" value="1.5" name="x">1.5</label>
                                <label><input type="radio" value="2" name="x">2</label>
                                <label><input type="radio" value="2.5" name="x">2.5</label>
                            </div>
                            <div class="vars">
                                <div id="yField" colspan="7"><input type="text" name="y" id="Y" >
                                    <span>Y</span>
                                </div>
                            </div>
                            <div class="vars" id="R">
                                R
                                <div class="radio_div"><input type="radio" value="1" name="r">1</div>
                                <div class="radio_div"><input type="radio" value="2" name="r">2</div>
                                <div class="radio_div"><input type="radio" value="3" name="r">3</div>
                                <div class="radio_div"><input type="radio" value="4" name="r">4</div>
                                <div class="radio_div"><input type="radio" value="5" name="r">5</div>
                            </div>
                        </div>
                        <input type="button" id="go" name="start" value="Ну что народ, погнали!!!" onclick="submitForm()">
                    </div>
        
                </div>
        </div>
        <div id="rez-container">
            <div id="result-box">
                <div id="invalid_data" class="result_h">
                    <div>Результат:<?php echo $result?></div>
                    <div>Время выполнения: <?php echo $script_time?> </div>
                    <div>Дата: <?php echo $time?></div>
                </div>
                <div>
                    <?php
                    $res = isset($_SESSION['results']) && is_array($_SESSION['results']) ? $_SESSION['results'] : [];
                    //echo count($res);
                    foreach ($res as $val):
                    ?>
                        <div class="result_h">
                            X=<?= $val['x']?>, Y=<?= $val['y']?>, R=<?= $val['r']?>
                            <div>Результат - <?= $val['result']?>, Дата - X=<?= $val['time']?>, Время исполнения=<?= $val['script_time']?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>