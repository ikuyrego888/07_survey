<?php
include("funcs.php");

$file = fopen("data/data2.txt","r"); // ファイル読み込み

while ($string = fgets($file)) {
    $data = explode(",",$string);
    // var_dump($data);
    $dataArray[] = $data; //配列>配列でデータ取り出している
    $dataArray2[] = $string; //配列>文字列でデータを取り出している
}

// 以下の"$dataArray"はkeyが無い配列（後段の"$dataArray4ではkeyをセット"）
// var_dump($dataArray);
// echo "<br>";
// var_dump($dataArray2);

// cmp関数で比較
function cmp($a, $b) {
    // 年齢を比較
    return $a[0] - $b[0];
}
// 年齢でデータをソート
usort($dataArray, "cmp");

// for文の練習
$dataArray3 = [];
for($i = 0; $i < count($dataArray); $i++) {
    // var_dump($dataArray[$i]);
    $dataArray3[] = $dataArray[$i];
}
// var_dump($dataArray3);

fclose($file);

// fopenは2回書かないといけないのか？💡
$file = fopen("data/data2.txt","r"); // ファイル読み込み

// データ配列の整理
$dataArray4 = [];
while ($string = fgets($file)) {
    $data = explode(",",$string);
    // PHPの配列はarray()の中に書く。":"が使えないので"=>"で書く
    $dataArray4[] = array(
        "age" => $data[0],
        "breakfast" => $data[1],
        "egg" => $data[2],
        "rate" => $data[3],
        "name" => $data[4],
        "email" => $data[5],
        "time" => $data[6]
    );
}
// var_dump($dataArray4);

fclose($file);

// PHPのJSONの書き方（json_encodeと書く）
$jsonData = json_encode($dataArray4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style04.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <title>SURVEY_04</title>
</head>
<body>
    <div id="result">アンケート結果</div>
    <div id="tableContainer">
        <table id="dataTable">
            <tr>
                <th>年齢</th>
                <th>朝食</th>
                <th>目玉焼き</th>
                <th>満足度</th>
                <th>ネーム</th>
                <th>アドレス</th>
                <th>時間</th>
            </tr>
            <?php
            // 表形式方法①：phpのforeach配列構文
                foreach ($dataArray as $element) {
                    echo "<tr>";
                    echo "<td>".$element[0]."</td>";
                    echo "<td>".$element[1]."</td>";
                    echo "<td>".$element[2]."</td>";
                    echo "<td>".starRate($element[3])."</td>";
                    echo "<td>".h($element[4])."</td>";
                    echo "<td>".h($element[5])."</td>";
                    echo "<td>".$element[6]."</td>";
                    echo "</tr>";
                }

                // 満足度を星で表示させる
                function starRate($rate) {
                    if ($rate == 1) {
                        return "<span id=starFill>★</span><span id=satrNull>☆☆☆☆</span>";
                    } else if ($rate == 2) {
                        return "<span id=starFill>★★</span><span id=satrNull>☆☆☆</span>";
                    } else if ($rate == 3) {
                        return "<span id=starFill>★★★</span><span id=satrNull>☆☆</span>";
                    } else if ($rate == 4) {
                        return "<span id=starFill>★★★★</span><span id=satrNull>☆</span>";
                    }  else if ($rate == 5) {
                        return "<span id=starFill>★★★★★</span>";
                    } 
                }

            // 表形式方法②：phpのforeach配列構文
                // foreach ($dataArray2 as $line) {
                //     $data = explode(",", $line);
                //     echo "<tr>";
                //     echo "<td>".$data[0]."</td>";
                //     echo "<td>".$data[1]."</td>";
                //     echo "<td>".$data[2]."</td>";
                //     echo "<td>".$data[3]."</td>";
                //     echo "<td>".h($data[4])."</td>";
                //     echo "<td>".h($data[5])."</td>";
                //     echo "<td>".$data[6]."</td>";
                //     echo "</tr>";
                // }

            // 表形式方法③
                // $file = fopen("data/data2.txt","r");
                // while ($string = fgets($file)) {
                //     $data = explode(",",$string);
                //     echo "<tr>";
                //     echo "<td>".$data[0]."</td>";
                //     echo "<td>".$data[1]."</td>";
                //     echo "<td>".$data[2]."</td>";
                //     echo "<td>".$data[3]."</td>";
                //     echo "<td>".h($data[4])."</td>";
                //     echo "<td>".h($data[5])."</td>";
                //     echo "<td>".$data[6]."</td>";
                //     echo "</tr>";
                // }
                // fclose($file);
            ?>
        </table>
        <div id="graph">
            <canvas id="ageGraph"></canvas>
            <canvas id="breakfastGraph"></canvas>
            <canvas id="eggGraph"></canvas>
        </div>
    </div>

    <script>

        // 配列の整理その１（PHPから参照）※重要💡（すべての元データ）
        let tableData = <?php echo $jsonData; ?>;
        console.log("元データJSON形式①", tableData);
        // アンケート回答の総人数をカウントする（比率を出す用）
        let dataTotal = tableData.length;
        console.log("回答者数:", dataTotal);

        // 配列の整理その２（tableデータから作成）
        let tableData2 = [];
        $("#dataTable tr").each(function(index, tr){
            tableData2[index]={
                "age" : $(tr).find("td:eq(0)").text(),
                "breakfast" : $(tr).find("td:eq(1)").text(),
                "egg" : $(tr).find("td:eq(2)").text(),
                "name" : $(tr).find("td:eq(3)").text(),
                "email" : $(tr).find("td:eq(4)").text(),
                "time" : $(tr).find("td:eq(5)").text()
            }
        })
        // 配列の先頭の空欄行をshift()で削除
        tableData2.shift();
        console.log("元データJSON形式②", tableData2);

        // 年齢構成データ整備
        // "[]"ではなく"{}"とすることでオブジェクトとして整理する！
        let ageGroup = {};
        tableData.forEach(function(e) {
            let age = e.age;
            // console.log(age);
            // "|| 0" が無いと初めて出てきた年代の時にエラーになってしまう
            ageGroup[age] = (ageGroup[age] || 0) + 1;
        })
        console.log(ageGroup);

        let ageLabel = Object.keys(ageGroup); //年齢構成のラベル
        console.log("年齢ラベル:", ageLabel);
        let ageValue = Object.values(ageGroup); //年齢構成の値
        console.log("年齢バリュー:", ageValue);
        let ageValueRatio = []; //年齢構成の割合
        for (i = 0; i < ageValue.length; i++) {
            ageValueRatio.push(((ageValue[i] / dataTotal) * 100).toFixed(1) + "%");
        }
        console.log("年齢割合:", ageValueRatio);

        // 年齢をソートして並び替える ※配列でのmap()の使い方
        // map()は繰り返し処理のため、returnを使う
        let sortAge = ageLabel.map(function(label, value) {
            return {label: label, value: ageValue[value]};
        }).sort(function(a,b) {
            // console.log("a確認:"+parseInt(a.label), "b確認:"+parseInt(b.label),);
            return parseInt(a.label) - parseInt(b.label);
        })
        console.log("並替え結果:",sortAge);

        let sortAgeLabel = sortAge.map(function(e) {
            return e.label;
        })
        console.log("並替え後の年齢ラベル", sortAgeLabel);

        let sortAgeValue = sortAge.map(function(e) {
            return e.value
        })
        console.log("並替え後の年齢人数", sortAgeValue);

        
        // .mapを使うと、for文を使わずに配列を簡単に変更できる
        // let ageValueRatio2 = ageValue.map(function(e) {
        //     return ((e / dataTotal) * 100).toFixed(1) + "%";
        // });
        // console.log("年齢割合2:", ageValueRatio2);

        // グラフのカラー設定
        let color01 = ["#7abeee", "#2d99e7", "#2589d0", "#2073ae", "#1a5c8b", "#104b76"];
        let color02 = ["#f68d8d", "#e86767", "#e83e3e"];
        
        // 年齢構成のグラフ
        new Chart($("#ageGraph"), {
            type: "doughnut",
            data: {
                labels: sortAgeLabel,
                // labels: ageLabel,
                datasets: [{
                    label: "年齢構成",
                    data: sortAgeValue,
                    // data: ageValue,
                    // backgroundColor: "rgb(37, 137, 208, 0.6)",
                    backgroundColor: color01,
                    // borderColor: "rgb(37, 137, 208)",
                    borderColor: "#d4d8da",
                    borderWidth: 1
                }]
            },
            // 以下１行でデータ数だけなら表示できる
            // plugins: [ChartDataLabels],

            // options: chartOption
            // options: {
            //     plugins: {
            //         datalabels: {
            //             // formatterが反応していないのか、円グラフ上に表示されない
            //             formatter: function(value, context) {
            //                 return context.chart.data.labels[context.dataIndex]+ '\n' + ageValueRatio[context.dataIndex];
            //             }
            //         }
            //     }
            // }
        })

        // 朝食摂取データ整備
        let breakfastGroup = {};
        tableData.forEach(function(e) {
            let breakfast = e.breakfast
            // console.log(breakfast);
            breakfastGroup[breakfast] = (breakfastGroup[breakfast] || 0) + 1;
        })
        console.log(breakfastGroup);

        let breakfastLabel = Object.keys(breakfastGroup); //朝食摂取のラベル
        console.log("朝食摂取ラベル:", breakfastLabel);
        let breakfastValue = Object.values(breakfastGroup); //朝食摂取の値
        console.log("朝食摂取バリュー:", breakfastValue);
        let breakfastValueRatio = []; //朝食摂取の割合
        for (i = 0; i < breakfastValue.length; i++) {
            breakfastValueRatio.push(((breakfastValue[i] / dataTotal) * 100).toFixed(1) + "%");
        }
        console.log("朝食割合:", breakfastValueRatio);

        // 朝食摂取のグラフ
        new Chart($("#breakfastGraph"), {
            type: "pie",
            data: {
                labels: breakfastLabel,
                datasets: [{
                    label: "朝食摂取パターン",
                    data: breakfastValue,
                    backgroundColor: color02,
                    borderColor: "#d4d8da",
                    borderWidth: 1
                }]
            },
        })

        // 目玉焼きデータ整備
        let eggGroup = {};
        tableData.forEach(function(e) {
            let egg = e.egg
            // console.log(egg);
            eggGroup[egg] = (eggGroup[egg] || 0) + 1;
        })
        console.log(eggGroup);

        let eggLabel = Object.keys(eggGroup); //目玉焼きのラベル
        console.log("目玉焼きラベル:", eggLabel);
        let eggValue = Object.values(eggGroup); //目玉焼きの値
        console.log("目玉焼きバリュー:", eggValue);
        let eggValueRatio = []; //目玉焼きの割合
        for (i = 0; i < eggValue.length; i++) {
            eggValueRatio.push(((eggValue[i] / dataTotal) * 100).toFixed(1) + "%");
        }
        console.log("目玉焼き割合:", eggValueRatio);

        // 目玉焼きのグラフ
        new Chart($("#eggGraph"), {
            type: "pie",
            data: {
                labels: eggLabel,
                datasets: [{
                    label: "目玉焼きの食べ方",
                    data: eggValue,
                    backgroundColor: color02,
                    borderColor: "#d4d8da",
                    borderWidth: 1
                }]
            },
        })

    </script>

</body>
</html>