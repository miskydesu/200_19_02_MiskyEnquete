<?php
require_once('../dao/T_QUESTION_dao.php');
require_once('../dao/T_QUESTION_DETAILS_dao.php');

//print_r($_POST);

$type = 'init';

//処理タイプの判定
if($_GET['type']){
	$type = $_GET['type'];
}else{
	$err.= $msg["ERR0001"];
}

if($type === "insert"){
	
		$nexttype = "insert_run"; 
		$button_name = "登録";
		$question = array(
			"QESTION_NO" => "",
			"NAME" => "",
			"OVERVIEW" => "",
			"END_MES" => "",
			"DATE" => "",
			"CLIENTINFO_FLG" => "",
			"IMAGE_PATH" => "",
			"GRADING_FLG" => "",
			"GRADING_CATEGORY1" => "",
			"GRADING_CATEGORY2" => "",
			"GRADING_CATEGORY3" => "",
			"GRADING_CATEGORY4" => "",
			"GRADING_CATEGORY5" => "",
		);
		
	
} else if($type === "delete"){
	
	if($_POST['qno']){
		$qno = $_POST['qno'];
	}
	
	deleteTquestion($qno);
	
} else if($type === "insert_run") {
	
	//変数の取り込み
	
		$nexttype = "insert_run"; 
		$button_name = "登録";
		$question = array(
			"QESTION_NO" => "",
			"NAME" => $_POST['qname'],
			"OVERVIEW" => $_POST['qoverview'],
			"END_MES" => $_POST['qendmes'],
			"DATE" => "",
			"CLIENTINFO_FLG" => $_POST['qclientflg'],
			"IMAGE_PATH" => "",
			"GRADING_FLG" => $_POST['qgdadingflg'],
			"GRADING_CATEGORY1" => $_POST['qgdadingcategory1'],
			"GRADING_CATEGORY2" => $_POST['qgdadingcategory2'],
			"GRADING_CATEGORY3" => $_POST['qgdadingcategory3'],
			"GRADING_CATEGORY4" => $_POST['qgdadingcategory4'],
			"GRADING_CATEGORY5" => $_POST['qgdadingcategory5'],
		);
		
		//画像の存在確認
		if(($_FILES['upfile'])){
			//ファイルの拡張子を確認する
			$fileName = $_FILES['upfile']['name'];
			if($fileName){
				if(preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$|\.bmp$/i', $fileName)){
					
					//正しい拡張子の時、拡張子を取得				
					$tmp_ary = explode('.', $fileName);
					$extension = $tmp_ary[count($tmp_ary)-1];
					
					do {
						$savefile = md5(microtime()).".".$extension; // 保存するファイル名を生成（拡張子を付ける）
					} while (file_exists('../savedir/' . $savefile)); // もし存在したらやり直し
						move_uploaded_file($_FILES['upfile']['tmp_name'], '../savedir/' . $savefile);
						
					//画像格納出来た場合はimagepathを書き換えて更新へ
					$question["IMAGE_PATH"] = $savefile;
					
				} else {
					//アップロードされたファイルの拡張子が画像ではない。
					$err.= $msg["ERR1016"];
				}
			}
		}
		
		$qcount = $_POST['qcount'];
		
		$questionDetailsList = array();
		
		for($i = 1; $i <= $qcount ;$i++){
				
			$question_detail = array(
				"NO" => "",
				"QUESTION_NO" => "",
				"TITLE" => $_POST['q' . $i . '-title'],
				"BODY" => $_POST['q' . $i . '-body'],
				"REQ_FLG" => $_POST['q' . $i . '-req'],
				"TYPE" => $_POST['q' . $i . '-type'],
				"SELECT_ANS" => $_POST['q' . $i . '-selectans'],
				"ETC_FLG" => $_POST['q' . $i . '-etcflg'],
				"IMAGE_PATH" => $_POST['q' . $i . '-imagepath'],
				"GRADING_POINT" => $_POST['q' . $i . '-gradingarray'],
				"GRADING_SELECTEDCATEGORY" => $_POST['q' . $i . '-gradingcategory'],
			);
			if(!$question_detail["ETC_FLG"] || $question_detail["ETC_FLG"]===""){
				$question_detail["ETC_FLG"] = 0;
			}
			if(!$question_detail["REQ_FLG"] || $question_detail["REQ_FLG"]===""){
				$question_detail["REQ_FLG"] = 0;
			}
			if(!$question_detail["TYPE"] || $question_detail["TYPE"]===""){
				$question_detail["TYPE"] = 0;
			}
			if(!$question_detail["GRADING_SELECTEDCATEGORY"] || $question_detail["GRADING_SELECTEDCATEGORY"]===""){
				$question_detail["GRADING_SELECTEDCATEGORY"] = 0;
			}
			if(!$question_detail["GRADING_POINT"] || $question_detail["GRADING_POINT"]===""){
				$question_detail["GRADING_POINT"] = "";
			}
			//画像の存在確認
			if(($_FILES['q' . $i . '-upfile'])){
				//ファイルの拡張子を確認する
				$fileName = $_FILES['q' . $i . '-upfile']['name'];
				if($fileName){
					if(preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$|\.bmp$/i', $fileName)){
						
						//正しい拡張子の時、拡張子を取得				
						$tmp_ary = explode('.', $fileName);
						$extension = $tmp_ary[count($tmp_ary)-1];
						
						do {
							$savefile = md5(microtime()).".".$extension; // 保存するファイル名を生成（拡張子を付ける）
						} while (file_exists('../savedir/' . $savefile)); // もし存在したらやり直し
							move_uploaded_file($_FILES['q' . $i . '-upfile']['tmp_name'], '../savedir/' . $savefile);
							
						//画像格納出来た場合はimagepathを書き換えて更新へ
						$question_detail["IMAGE_PATH"] = $savefile;
						
					} else {
						//アップロードされたファイルの拡張子が画像ではない。
						$err.= $msg["ERR1016"];
					}
				}
			}
			
	  		array_push($questionDetailsList, $question_detail);
		}

		$qno = insertTquestion($question["NAME"],$question["OVERVIEW"],$question["END_MES"],$question["CLIENTINFO_FLG"],$question["IMAGE_PATH"],$question["GRADING_FLG"],$question["GRADING_CATEGORY1"],$question["GRADING_CATEGORY2"],$question["GRADING_CATEGORY3"],$question["GRADING_CATEGORY4"],$question["GRADING_CATEGORY5"],$questionDetailsList);
		
		$err.= "<span class='mes_msg'>登録できました。</div>";
		$display_mes = $err;

		//成功したらupdate処理
		$type = "update";
		$nexttype = "update_run"; 
		
		$qurl = "../question/index.php?qno=".$qno;
		
		//編集時の初期値
		$question = getTquestionByQno($qno);
	
		$questionDetailsList = getTquestionDetailsListByQno($qno);
	
} else if($type === "update") {
	
	$button_name = "変更";
	$nexttype = "update_run"; 
	
	$qno = 0;
	
	//処理タイプの判定
	if($_GET['qno']){
		$qno = $_GET['qno'];
	}else{
		$err.= $msg["ERR0001"];
	}

	$qurl = "../question/index.php?qno=".$qno;
	
	//編集時の初期値
	$question = getTquestionByQno($qno);
	
	$questionDetailsList = getTquestionDetailsListByQno($qno);
	
} else if($type === "update_run") {
	
	//変数の取り込み
	
		$nexttype = "update_run"; 
		$button_name = "編集";
		$question = array(
			"DELETE_NO" => $_POST['delno'],
			"QESTION_NO" => $_POST['qno'],
			"NAME" => $_POST['qname'],
			"OVERVIEW" => $_POST['qoverview'],
			"END_MES" => $_POST['qendmes'],
			"DATE" => "",
			"CLIENTINFO_FLG" => $_POST['qclientflg'],
			"IMAGE_PATH" => $_POST['imagepath'],
			"GRADING_FLG" => $_POST['qgdadingflg'],
			"GRADING_CATEGORY1" => $_POST['qgdadingcategory1'],
			"GRADING_CATEGORY2" => $_POST['qgdadingcategory2'],
			"GRADING_CATEGORY3" => $_POST['qgdadingcategory3'],
			"GRADING_CATEGORY4" => $_POST['qgdadingcategory4'],
			"GRADING_CATEGORY5" => $_POST['qgdadingcategory5'],
		);
		
		//画像の存在確認
		if(($_FILES['upfile'])){
			//ファイルの拡張子を確認する
			$fileName = $_FILES['upfile']['name'];
			if($fileName){
				if(preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$|\.bmp$/i', $fileName)){
					
					//正しい拡張子の時、拡張子を取得				
					$tmp_ary = explode('.', $fileName);
					$extension = $tmp_ary[count($tmp_ary)-1];
					
					do {
						$savefile = md5(microtime()).".".$extension; // 保存するファイル名を生成（拡張子を付ける）
					} while (file_exists('../savedir/' . $savefile)); // もし存在したらやり直し
						move_uploaded_file($_FILES['upfile']['tmp_name'], '../savedir/' . $savefile);
						
					//画像格納出来た場合はimagepathを書き換えて更新へ
					$question["IMAGE_PATH"] = $savefile;
					
				} else {
					//アップロードされたファイルの拡張子が画像ではない。
					$err.= $msg["ERR1016"];
				}
			}
		}else{
			//POSTデータから取得する（更新の際に消えないように保持）
			$iamgepath = ($_POST['iamgepath']);
			$question["IMAGE_PATH"] = $iamgepath;	
		}
		
		$qcount = $_POST['qcount'];
		
		$questionDetailsList = array();
		
		for($i = 1; $i <= $qcount ;$i++){
				
			$question_detail = array(
				"NO" => $_POST['q' . $i . '-no'],
				"QUESTION_NO" => $_POST['qno'],
				"TITLE" => $_POST['q' . $i . '-title'],
				"BODY" => $_POST['q' . $i . '-body'],
				"REQ_FLG" => $_POST['q' . $i . '-req'],
				"TYPE" => $_POST['q' . $i . '-type'],
				"SELECT_ANS" => $_POST['q' . $i . '-selectans'],
				"ETC_FLG" => $_POST['q' . $i . '-etcflg'],
				"IMAGE_PATH" => $_POST['q' . $i . '-imagepath'],
				"GRADING_POINT" => $_POST['q' . $i . '-gradingarray'],
				"GRADING_SELECTEDCATEGORY" => $_POST['q' . $i . '-gradingcategory'],
			);
			if(!$question_detail["ETC_FLG"] || $question_detail["ETC_FLG"]===""){
				$question_detail["ETC_FLG"] = 0;
			}
			if(!$question_detail["REQ_FLG"] || $question_detail["REQ_FLG"]===""){
				$question_detail["REQ_FLG"] = 0;
			}
			if(!$question_detail["TYPE"] || $question_detail["TYPE"]===""){
				$question_detail["TYPE"] = 0;
			}
			if(!$question_detail["GRADING_SELECTEDCATEGORY"] || $question_detail["GRADING_SELECTEDCATEGORY"]===""){
				$question_detail["GRADING_SELECTEDCATEGORY"] = 0;
			}
			if(!$question_detail["GRADING_POINT"] || $question_detail["GRADING_POINT"]===""){
				$question_detail["GRADING_POINT"] = "";
			}

			//画像の存在確認
			if(($_FILES['q' . $i . '-upfile'])){
				//ファイルの拡張子を確認する
				$fileName = $_FILES['q' . $i . '-upfile']['name'];
				if($fileName){
					if(preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$|\.bmp$/i', $fileName)){
						
						//正しい拡張子の時、拡張子を取得				
						$tmp_ary = explode('.', $fileName);
						$extension = $tmp_ary[count($tmp_ary)-1];
						
						do {
							$savefile = md5(microtime()).".".$extension; // 保存するファイル名を生成（拡張子を付ける）
						} while (file_exists('../savedir/' . $savefile)); // もし存在したらやり直し
							move_uploaded_file($_FILES['q' . $i . '-upfile']['tmp_name'], '../savedir/' . $savefile);
							
						//画像格納出来た場合はimagepathを書き換えて更新へ
						$question_detail["IMAGE_PATH"] = $savefile;
						
					} else {
						//アップロードされたファイルの拡張子が画像ではない。
						$err.= $msg["ERR1016"];
					}
				}
			}
			
	  		array_push($questionDetailsList, $question_detail) ;
		}

		updateTquestion($question["QESTION_NO"],$question["NAME"],$question["OVERVIEW"],$question["END_MES"],$question["DELETE_NO"],$question["CLIENTINFO_FLG"],$question["IMAGE_PATH"],$question["GRADING_FLG"],$question["GRADING_CATEGORY1"],$question["GRADING_CATEGORY2"],$question["GRADING_CATEGORY3"],$question["GRADING_CATEGORY4"],$question["GRADING_CATEGORY5"],$questionDetailsList);
		
		$err.= "<span class='mes_msg'>更新できました。</div>";
		$display_mes = $err;
		
		//編集時の初期値	
		$type = "update";
		$qno = $question["QESTION_NO"];
		
		$qurl = "../question/index.php?qno=".$qno;
		
		$question = getTquestionByQno($qno);
	
		$questionDetailsList = getTquestionDetailsListByQno($qno);
		
}

$questionList = getTquestionList();

?>
<script>
	var question = <?php echo  json_encode($question, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var questionDetailsList = <?php echo  json_encode($questionDetailsList, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>

