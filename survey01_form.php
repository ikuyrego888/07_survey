<?php
// エラーを表示させるようにしてください
// ini_set('display_errors', 'On');
// 全てのレベルのエラーを表示してください
// error_reporting(E_ALL);
?>

<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/style01.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<title>SURVEY_01</title>
</head>
<body>

<div id="survey">🍚 朝食アンケート 🍞</div>
<!-- <form action="survey02_confirm.php" method="post"> -->
<div id="form">
	<form action="survey03_write.php" method="post">
		<table>
			<tr>
				<th>No.</th>
				<th>質問<span style="color: red;">　*</span><span style="color: red; font-size: 10px">入力必須</span></th>
				<th>あなたの回答</th>
			</tr>
			<tr>
				<td>01</td>
				<td>あたなの名前を教えてください<span style="color: red;">*</span></td>
				<td><input type="text" name="name" id="name" placeholder="名前を入力（ニックネーム可）"></td>
			</tr>
			<tr>
				<td>02</td>
				<td>あなたの年齢を教えてください<span style="color: red;">*</span></td>
				<td>
					<select name="age" id="age">
						<option value="" hidden>選んでください</option>
						<option value="10歳未満">10歳未満</option>
						<option value="10代">10歳以上〜20歳未満</option>
						<option value="20代">20歳以上〜30歳未満</option>
						<option value="30代">30歳以上〜40歳未満</option>
						<option value="40代">40歳以上〜50歳未満</option>
						<option value="50代">50歳以上〜60歳未満</option>
						<option value="60代">60歳以上〜70歳未満</option>
						<option value="70代">70歳以上〜80歳未満</option>
						<option value="80歳以上">80歳以上</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>03</td>
				<td>あなたのメールアドレスを教えてください</td>
				<td><input type="text" name="mail" placeholder="メールアドレスを入力"></td>
			</tr>
			<tr>
				<td>04</td>
				<td>朝ごはんはどっち派？<span style="color: red;">*</span></td>
				<td>
					<select name="breakfast" id="breakfast">
						<option value="" hidden>選んでください</option>
						<option value="ご飯">ご飯</option>
						<option value="パン">パン</option>
						<option value="食べない">食べない</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>05</td>
				<td>目玉焼きには何をつける？<span style="color: red;">*</span></td>
				<td>
					<select name="egg" id="egg">
						<option value="" hidden>選んでください</option>
						<option value="お塩">お塩</option>
						<option value="お醤油">お醤油</option>
						<option value="何もつけない">何もつけない</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>06</td>
				<td>あなたは日々の朝食に満足していますか？<span style="color: red;">*</span></td>
				<td>
				<div id="starRate">
					<input type="radio" name="rate" id="star5" value="5">
					<label for="star5">☆</label>
					<input type="radio" name="rate" id="star4" value="4">
					<label for="star4">☆</label>
					<input type="radio" name="rate" id="star3" value="3">
					<label for="star3">☆</label>
					<input type="radio" name="rate" id="star2" value="2">
					<label for="star2">☆</label>
					<input type="radio" name="rate" id="star1" value="1">
					<label for="star1">☆</label>
				</div>
				</td>
			</tr>
		</table>
		<input type="submit" value="回答する" id="send">
	</form>
</div>
<p id="caution">※アンケートで回答いただいた個人情報は、本調査の目的以外で使用することはありません。</p>

<script>

	$("#send").prop("disabled", true);
	$("form").on("change", "input, select", function() {
		if ($("#name").val() !== "" &&  $("#age").val() !== "" && $("#breakfast").val() !== "" && $("#egg").val() !== "" && $("#starRate input:checked").val() !== undefined) {
			$("#send").prop("disabled", false);
		}
	})

</script>

</body>
</html>