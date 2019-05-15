function deleteImage(){
	if(confirm("画像を削除しますか？")==true){
		$("#imagepath").val("");
		$(".imageBoxLeft").html("");
	}
}
function deleteImageDetails(no){
	if(confirm("画像を削除しますか？")==true){
		$("#q" + no + "-imagepath").val("");
		$("#q" + no + "-imagebox").html("");
	}
}

//更新の時の初期表示
function updateInitDisplay(){
	
	qcount = questionDetailsList.length;
	
	$("#qname").val(question["NAME"]);
	$("#qoverview").val(question["OVERVIEW"]);
	$("#qendmes").val(question["END_MES"]);
	
	for(var i = 0; i < questionDetailsList.length; i++){
		
		var quesData = questionDetailsList[i];
		
		//質問ボックス（Q1..）の初期値
		qbox_no_area_html = $(".qbox_no_area").html();
		qbox_no_area_html += '<div class="qbox_no' + (i+1) + ' qbox_no" onClick="selectQuestion(' + (i+1) + ')">Q' + (i+1) + '</div>';
		$(".qbox_no_area").html(qbox_no_area_html);
		
		//質問内容ボックス（選択肢選択）の初期値
		//質問の名前
		qbox_body_html = "";
		qbox_body_html += '<div class="q' + (i+1) + '-qbox">';
		
		qbox_body_html += '<input type="hidden" id="q' + (i+1) + '-no" name="q' + (i+1) + '-no" " value="' + quesData["NO"] + '" />';
		qbox_body_html += '<input type="text" id="q' + (i+1) + '-title" name="q' + (i+1) + '-title" class="qtitle" placeholder="質問の名前を入力して下さい。" value="' + quesData["TITLE"] + '" />';
		
		if(quesData["REQ_FLG"] === "1"){
			qbox_body_html += '<label><input type="checkbox" id="q' + (i+1) + '-req" name="q' + (i+1) + '-req" value="1" checked="checked"/>必須入力</label><br/>';
		}else{
			qbox_body_html += '<label><input type="checkbox" id="q' + (i+1) + '-req" name="q' + (i+1) + '-req" value="1" />必須入力</label><br/>';
		}
		qbox_body_html += '<textarea id="q' + (i+1) + '-body" name="q' + (i+1) + '-body" class="qbody" rows="5" placeholder="質問内容を入力して下さい。">' + quesData["BODY"] + '</textarea>';
		
		//画像登録機能
		qbox_body_html += '<input type="hidden" name="q' + (i+1) + '-imagepath" id="q' + (i+1) + '-imagepath" value="' + quesData["IMAGE_PATH"] + '" />';
		
		if(quesData["IMAGE_PATH"] == ""){
        	qbox_body_html += '<input type="file" name="q' + (i+1) + '-upfile" id="q' + (i+1) + '-upfile" /><br /><br />';
    	}else{
        	qbox_body_html += '<div id="q' + (i+1) + '-imagebox" class="imageBoxLeft"><dl><dt><img src="../savedir/' + quesData["IMAGE_PATH"] + '" /></dt><dd>';
			qbox_body_html += '<button type="button" class="red" onclick=\'deleteImageDetails("' + (i+1) + '");\'>画像削除</button></dd></dl></div>';
        	qbox_body_html += '<div class="imageBoxRight"><input type="file" name="q' + (i+1) + '-upfile" id="q' + (i+1) + '-upfile" /></div>';
            qbox_body_html += '<div class="clear"></div><br />';
        }		
		
		if(quesData["TYPE"] === "0"){
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-1" name="q' + (i+1) + '-type" value="0" checked="checked"/>単一選択（プルダウン）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-4" name="q' + (i+1) + '-type" value="3" />単一選択（選択式）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-2" name="q' + (i+1) + '-type" value="1" />複数選択</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-3" name="q' + (i+1) + '-type" value="2" />自由記入</label>';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-5" name="q' + (i+1) + '-type" value="4" />日付選択</label><br/>';
		}else if(quesData["TYPE"] === "1"){
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-1" name="q' + (i+1) + '-type" value="0" />単一選択（プルダウン）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-4" name="q' + (i+1) + '-type" value="3" />単一選択（選択式）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-2" name="q' + (i+1) + '-type" value="1" checked="checked" />複数選択</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-3" name="q' + (i+1) + '-type" value="2" />自由記入</label>';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-5" name="q' + (i+1) + '-type" value="4" />日付選択</label><br/>';
		}else if(quesData["TYPE"] === "2"){
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-1" name="q' + (i+1) + '-type" value="0" />単一選択（プルダウン）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-4" name="q' + (i+1) + '-type" value="3" />単一選択（選択式）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-2" name="q' + (i+1) + '-type" value="1" />複数選択</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-3" name="q' + (i+1) + '-type" value="2" checked="checked" />自由記入</label>';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-5" name="q' + (i+1) + '-type" value="4" />日付選択</label><br/>';
		}else if(quesData["TYPE"] === "3"){
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-1" name="q' + (i+1) + '-type" value="0" />単一選択（プルダウン）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-4" name="q' + (i+1) + '-type" value="3" checked="checked" />単一選択（選択式）</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-2" name="q' + (i+1) + '-type" value="1" />複数選択</label> ';
			qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-3" name="q' + (i+1) + '-type" value="2" />自由記入</label>';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-5" name="q' + (i+1) + '-type" value="4" />日付選択</label><br/>';
		}else if(quesData["TYPE"] === "4"){
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-1" name="q' + (i+1) + '-type" value="0" />単一選択（プルダウン）</label> ';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-4" name="q' + (i+1) + '-type" value="3" />単一選択（選択式）</label> ';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-2" name="q' + (i+1) + '-type" value="1" />複数選択</label> ';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-3" name="q' + (i+1) + '-type" value="2" />自由記入</label>';
            qbox_body_html += '<label><input type="radio" id="q' + (i+1) + '-type-5" name="q' + (i+1) + '-type" value="4" checked="checked" />日付選択</label><br/>';
        }
		if(quesData["GRADING_SELECTEDCATEGORY"] === "0"){
			qbox_body_html += '<label><select id="q' + (i+1) + '-gradingcategory" name="q' + (i+1) + '-gradingcategory"><option value="0" selected>採点カテゴリー1</option><option value="1">採点カテゴリー2</option><option value="2">採点カテゴリー3</option><option value="3">採点カテゴリー4</option><option value="4">採点カテゴリー5</option></select>';
		} else if(quesData["GRADING_SELECTEDCATEGORY"] === "1"){
			qbox_body_html += '<label><select id="q' + (i+1) + '-gradingcategory" name="q' + (i+1) + '-gradingcategory"><option value="0">採点カテゴリー1</option><option value="1" selected>採点カテゴリー2</option><option value="2">採点カテゴリー3</option><option value="3">採点カテゴリー4</option><option value="4">採点カテゴリー5</option></select>';
		} else if(quesData["GRADING_SELECTEDCATEGORY"] === "2"){
			qbox_body_html += '<label><select id="q' + (i+1) + '-gradingcategory" name="q' + (i+1) + '-gradingcategory"><option value="0">採点カテゴリー1</option><option value="1">採点カテゴリー2</option><option value="2" selected>採点カテゴリー3</option><option value="3">採点カテゴリー4</option><option value="4">採点カテゴリー5</option></select>';
		} else if(quesData["GRADING_SELECTEDCATEGORY"] === "3"){
			qbox_body_html += '<label><select id="q' + (i+1) + '-gradingcategory" name="q' + (i+1) + '-gradingcategory"><option value="0">採点カテゴリー1</option><option value="1">採点カテゴリー2</option><option value="2">採点カテゴリー3</option><option value="3" selected>採点カテゴリー4</option><option value="4">採点カテゴリー5</option></select>';
		} else if(quesData["GRADING_SELECTEDCATEGORY"] === "4"){
			qbox_body_html += '<label><select id="q' + (i+1) + '-gradingcategory" name="q' + (i+1) + '-gradingcategory"><option value="0">採点カテゴリー1</option><option value="1">採点カテゴリー2</option><option value="2">採点カテゴリー3</option><option value="3">採点カテゴリー4</option><option value="4" selected>採点カテゴリー5</option></select>';
		}
		
		var answerList = quesData["SELECT_ANS"].split("<>");
		var gradingList = quesData["GRADING_POINT"].split("<>");
		qselect.push(answerList.length); //選択肢の数
		
		qbox_body_html += '<div class="selectbox q' + (i+1) + '-selectbox">';
		qbox_body_html += '<input type="hidden" name="q' + (i+1) + '-selectans" id="q' + (i+1) + '-selectans" value="" />';
		qbox_body_html += '<input type="hidden" name="q' + (i+1) + '-gradingarray" id="q' + (i+1) + '-gradingarray" value="" />';
	
		for(var j =0;j < 20;j++){
			qbox_body_html += '<input type="text" name="q' + (i+1)  + '-select-'+ (j+1)+ '" id="q' + (i+1) + '-select-'+(j+1)+ '" class="selectans" placeholder="選択肢を入力してください。" />';
			qbox_body_html += '<input type="text" name="q' + (i+1)  + '-grading-'+ (j+1)+ '" id="q' + (i+1) + '-grading-'+(j+1)+ '" class="gradingpoint" placeholder="配点" />';
			qbox_body_html += '<button onClick="deleteSelect(' + (i+1) + ',' + (j+1) + ');" type="button" id="qb' + (i+1) + '-select-'+(j+1)+ '" class="selectans_del red">選択肢削除</button>';
			qbox_body_html += '<div class="clear"></div>';
		}
	
		qbox_body_html += '</div>'; 
			
		qbox_body_html += '<button type="button" onClick="selectAdd(' + (i+1) + ')">+選択肢を増やす</button>                                       ';
		
		if(quesData["ETC_FLG"] === "1"){
			qbox_body_html += '<label><input type="checkbox" id="q' + (i+1) + '-etcflg" name="q' + (i+1) + '-etcflg" value="1" checked="checked" />最後の選択肢に自由記入欄を付ける</label> ';
		}else{
			qbox_body_html += '<label><input type="checkbox" id="q' + (i+1) + '-etcflg" name="q' + (i+1) + '-etcflg" value="1" />最後の選択肢に自由記入欄を付ける</label> ';
		}
		qbox_body_html += '<div class="delq_box"><button type="button" class="red" onClick="deleteQestion(' + (i+1) + ')" >質問の削除</button></div>';
		qbox_body_html += '</div">';
		
		
		$(".qbox_body_area-" + (i+1)).html(qbox_body_html);
		
		
		for(var j =0;j < 20;j++){
			if(answerList.length > j){
				$('#q' + (i+1)  + '-select-'+ (j+1)).css("display", "blcok");
				$('#q' + (i+1)  + '-grading-'+ (j+1)).css("display", "blcok");
				$('#qb' + (i+1)  + '-select-'+ (j+1)).css("display", "blcok");
				$('#q' + (i+1)  + '-select-'+ (j+1)).val(answerList[j]);
				$('#q' + (i+1)  + '-grading-'+ (j+1)).val("0");
			}else{
				$('#q' + (i+1)  + '-select-'+ (j+1)).css("display", "none");
				$('#q' + (i+1)  + '-grading-'+ (j+1)).css("display", "none");
				$('#qb' + (i+1)  + '-select-'+ (j+1)).css("display", "none");
			}
			if(gradingList.length > j){
				$('#q' + (i+1)  + '-grading-'+ (j+1)).val(gradingList[j]);
			}
			
		}
		
	}
	
	
	for(var i =0;i < 100;i++){
		$('.qbox_body_area-' + (i+1)).css("display", "none");
	}
	
	qnow = 1;
	$('.qbox_body_area-1').css("display", "block");
	
	for(var i =0;i <= qcount;i++){
		$('.qbox_no' + (i+1)).removeClass('qbox_no_on');
	}
	
	$('.qbox_no1').addClass('qbox_no_on');
	
	
}

//新規作成の時の初期表示
function insertInitDisplay(){
		
	$("#qname").val("");
	$("#qoverview").val("");
	$("#qendmes").val("");
		
	addQuestion();
	
}


function addQuestion(){
	
	if(qcount >= 100){
		alert("登録できる質問は100問までです。");
		return;
	}
	qcount = qcount + 1;
	qnow = qcount;
	
	for(var i =0;i < 100;i++){
		$('.qbox_body_area-' + (i+1)).css("display", "none");
	}
	$('.qbox_body_area-' + qcount).css("display", "block");
	
	for(var i =0;i <= qcount;i++){
		$('.qbox_no' + (i+1)).removeClass('qbox_no_on');
	}
	
	//質問ボックス（Q1..）の初期値
	qbox_no_area_html = $(".qbox_no_area").html();	;
	qbox_no_area_html += '<div class="qbox_no' + qcount + ' qbox_no qbox_no_on" onClick="selectQuestion(' + qcount + ')">Q' + qcount + '</div>';
	$(".qbox_no_area").html(qbox_no_area_html);
	
	//質問内容ボックス（選択肢選択）の初期値
	//質問の名前
	qbox_body_html = "";
	qbox_body_html += '<div class="q' + qcount + '-qbox">';
	
	qbox_body_html += '<input type="hidden" id="q' + (i+1) + '-no" name="q' + (i+1) + '-no" " value="" />';
	qbox_body_html += '<input type="text" id="q' + qcount + '-title" name="q' + qcount + '-title" class="qtitle" placeholder="質問の名前を入力して下さい。" />';
	qbox_body_html += '<label><input type="checkbox" id="q' + qcount + '-req name="q' + qcount + '-req" class="qreq" value="1" />必須入力</label><br/>';
	qbox_body_html += '<textarea id="q' + qcount + '-body" name="q' + qcount + '-body" class="qbody" rows="5" placeholder="質問内容を入力して下さい。"></textarea>';
	
	//画像登録機能
	qbox_body_html += '<input type="hidden" name="q' + qcount + '-imagepath" id="q' + qcount + '-imagepath" value="" />';
	qbox_body_html += '<input type="file" name="q' + qcount + '-upfile" id="q' + qcount + '-upfile" /><br /><br />';
	
	qbox_body_html += '<label><input type="radio" id="q' + qcount + '-type-1" name="q' + qcount + '-type" value="0" checked="checked" />単一選択（プルダウン）</label> ';
	qbox_body_html += '<label><input type="radio" id="q' + qcount + '-type-4" name="q' + qcount + '-type" value="3" checked="checked" />単一選択（選択式）</label> ';
	qbox_body_html += '<label><input type="radio" id="q' + qcount + '-type-2" name="q' + qcount + '-type" value="1" />複数選択</label> ';
	qbox_body_html += '<label><input type="radio" id="q' + qcount + '-type-3" name="q' + qcount + '-type" value="2" />自由記入</label><br/>';
	
	qbox_body_html += '<label><select id="q' + qcount + '-gradingcategory" name="q' + qcount + '-gradingcategory"><option value="0">採点カテゴリー1</option><option value="1">採点カテゴリー2</option><option value="2">採点カテゴリー3</option><option value="3">採点カテゴリー4</option><option value="4">採点カテゴリー5</option></select>';
	
	qselect.push(5); //選択肢の数
	
	qbox_body_html += '<div class="selectbox q' + qcount + '-selectbox">';
	qbox_body_html += '<input type="hidden" name="q' + qcount + '-selectans" id="q' + qcount + '-selectans" value="" />';
	qbox_body_html += '<input type="hidden" name="q' + qcount + '-gradingarray" id="q' + qcount + '-gradingarray" value="" />';
	
	for(var i =0;i < 20;i++){
		qbox_body_html += '<input type="text" name="q' + qcount + '-select-'+ (i+1)+ '" id="q' + qcount + '-select-'+(i+1)+ '" class="selectans" placeholder="選択肢を入力してください。" />';
		qbox_body_html += '<input type="text" name="q' + qcount  + '-grading-'+ (i+1)+ '" id="q' + qcount + '-grading-'+(i+1)+ '" class="gradingpoint" placeholder="配点" />';
		qbox_body_html += '<button onClick="deleteSelect(' + qcount + ',' + (i+1) + ');" type="button" id="qb' + qcount + '-select-'+(i+1)+ '" class="selectans_del red" >選択肢削除</button>';
		qbox_body_html += '<div class="clear"></div>';
	}
	
	qbox_body_html += '</div>';
	
	qbox_body_html += '<button type="button" class="blue" onClick="selectAdd(' + qcount + ')">+選択肢を増やす</button>                                       ';
	
	qbox_body_html += '<label><input type="checkbox" id="q' + qcount + '-etcflg" name="q' + qcount + '-etcflg" value="1" />最後の選択肢に自由記入欄を付ける</label> ';
	qbox_body_html += '<div class="delq_box"><button type="button" class="red" onClick="deleteQestion(' + qcount + ')" >質問の削除</button></div>';
	
	qbox_body_html += '</div">';
	
	
	$(".qbox_body_area-" + qcount).html(qbox_body_html);
	
	for(var i =0;i < 20;i++){
		if(i > 4){
			$('#q' + qcount + '-select-' + (i+1)).css("display", "none");
			$('#q' + qcount + '-grading-' + (i+1)).css("display", "none");
			$('#qb' + qcount + '-select-' + (i+1)).css("display", "none");
		}
	}
}


function selectQuestion(no){
	
	qnow = no;
	
	for(var i =0;i < 100;i++){
		$('.qbox_body_area-' + (i+1)).css("display", "none");
	}
	$('.qbox_body_area-' + no).css("display", "block");
	
	for(var i =0;i <= qcount;i++){		
		$('.qbox_no' + (i+1)).removeClass('qbox_no_on');
	}
	$('.qbox_no' + no).addClass('qbox_no_on');
	
	
}
	
function selectAdd(no){
	
	if(qselect[no - 1] < 20){
		qselect[no - 1] = qselect[no - 1] + 1;
		
		$('#q' + qnow + '-select-' + qselect[no - 1]).css("display", "block");
		$('#q' + qnow + '-grading-' + qselect[no - 1]).css("display", "block");
		$('#qb' + qnow + '-select-' + qselect[no - 1]).css("display", "block");
	}

	
}

function deleteSelect(no,sno){
	
	//値を入れ直す。
	for(var i =sno;i < 20;i++){
		$('#q' + qnow + '-select-' + i).val($('#q' + qnow + '-select-' + (i+1)).val());
		$('#q' + qnow + '-grading-' + i).val($('#q' + qnow + '-grading-' + (i+1)).val());
	}
	$('#q' + qnow + '-select-20').val('');
	
	$('#q' + qnow + '-select-' + qselect[no - 1]).css("display", "none");
	$('#q' + qnow + '-grading-' + qselect[no - 1]).css("display", "none");
	$('#qb' + qnow + '-select-' + qselect[no - 1]).css("display", "none");
	
	qselect[no - 1] = qselect[no - 1] - 1;
	
}

function deleteQestion(no){
	
  //
  
  if(confirm('回答データがある状態で質問を削除すると回答結果の表示が正しく表示されない可能があります。質問を削除しますか？')){
	  
	  
		
	if($('#q' + no + '-no').val() !== ""){
		if($("#delno").val() !== ""){
			$("#delno").val($("#delno").val() + "<>" + $('#q' + no + '-no').val());
		}else{
			$("#delno").val($('#q' + no + '-no').val());
		}
	}
	
	qcount = qcount - 1;
	
	qbox_no_area_html = "";
	for(var i =0;i < 100;i++){
		$('.qbox_body_area-' + (i+1)).css("display", "none");
		if(qcount > i){
			qbox_no_area_html += '<div class="qbox_no' + (i+1) + ' qbox_no" onClick="selectQuestion(' + (i+1) + ')">Q' + (i+1) + '</div>';
		}
	}
	$(".qbox_no_area").html(qbox_no_area_html);
	
	if(no == (qcount + 1)){
		$('.qbox_body_area-' + (no-1)).css("display", "block");
		$('.qbox_no' + (no-1)).addClass('qbox_no_on');
	}else{
		$('.qbox_body_area-' + no).css("display", "block");
		$('.qbox_no' + no).addClass('qbox_no_on');
	}

	
	
	//　選択された質問から詰める
	for(var i =no;i < 100;i++){
		
		qselect[i - 1] = qselect[i];
		
		for(var k =0;k < 20;k++){
			if(qselect[i - 1] > k){
				$('#q' + i  + '-select-'+ (k+1)).css("display", "block");
				$('#q' + i  + '-grading-'+ (k+1)).css("display", "block");
				$('#qb' + i  + '-select-'+ (k+1)).css("display", "block");
			}else{
				$('#q' + i  + '-select-'+ (k+1)).css("display", "none");
				$('#q' + i  + '-grading-'+ (k+1)).css("display", "none");
				$('#qb' + i  + '-select-'+ (k+1)).css("display", "none");
			}
			
		}
	
		$('#q' + i + '-no').val($('#q' + (i+1) + '-no').val());
		
		$('#q' + i + '-title').val($('#q' + (i+1) + '-title').val());
		
		if($('#q' + (i+1) + '-req').prop('checked')){
			$('#q' + i + '-req').prop('checked',true);
		}else{
			$('#q' + i + '-req').prop('checked',false);
		}
		
		$('#q' + i + '-body').val($('#q' + (i+1) + '-body').val());
		
		//ラジオボタン引き継ぎ
		if($('#q' + (i+1) + '-type-1').prop('checked')){
			$('#q' + i + '-type-1').prop('checked',true);
		}else{
			$('#q' + i + '-type-1').prop('checked',false);
		}
	
		$('#q' + i + '-body').val($('#q' + (i+1) + '-body').val());
		
		if($('#q' + (i+1) + '-type-2').prop('checked')){
			$('#q' + i + '-type-2').prop('checked',true);
		}else{
			$('#q' + i + '-type-2').prop('checked',false);
		}
		$('#q' + i + '-body').val($('#q' + (i+1) + '-body').val());
		
		if($('#q' + (i+1) + '-type-3').prop('checked')){
			$('#q' + i + '-type-3').prop('checked',true);
		}else{
			$('#q' + i + '-type-3').prop('checked',false);
		}
		
		$('#q' + i + '-body').val($('#q' + (i+1) + '-body').val());
		
		if($('#q' + (i+1) + '-type-4').prop('checked')){
			$('#q' + i + '-type-4').prop('checked',true);
		}else{
			$('#q' + i + '-type-4').prop('checked',false);
		}
		//TODO maji 2017/3/3　採点カテゴリー関して質問詰めた時に値が引き継がれない。　cehck.js
		
		$('#q' + i + '-selectans').val($('#q' + (i+1) + '-selectans').val());
		$('#q' + i + '-gradingarray').val($('#q' + (i+1) + '-gradingarray').val());
		
	
		for(var j =1;j <= 20;j++){
			$('#q' + i + '-select-' + j).val($('#q' + (i+1) + '-select-' + j).val());
			$('#q' + i + '-grading-' + j).val($('#q' + (i+1) + '-grading-' + j).val());
		}
		
		
		if($('#q' + (i+1) + '-etcflg').prop('checked')){
			$('#q' + i + '-etcflg').prop('checked',true);
		}else{
			$('#q' + i + '-etcflg').prop('checked',false);
		}
	}
	
	//最後の質問クリアー
	qselect[99] = 5;
	$('#q100-no').val('');
	$('#q100-title').val('');
	$('#q100-req').prop('checked',false);
	$('#q100-body').val('');
	$('#q100-type-1').prop('checked',true);
	$('#q100-type-2').prop('checked',false);
	$('#q100-type-3').prop('checked',false);
	$('#q100-type-4').prop('checked',false);
	$('#q100-selectans').val('');
	$('#q100-gradingarray').val('');
	for(var j =1;j <= 20;j++){
		$('#q' + i + '-select-' + j).val("");
		$('#q' + i + '-grading-' + j).val("");
		if(qselect[19] > j){
			$('#q20-select-'+ (j+1)).css("display", "block");
			$('#q20-grading-'+ (j+1)).css("display", "block");
			$('#qb20-select-'+ (j+1)).css("display", "block");
		}else{
			$('#q20-select-'+ (j+1)).css("display", "none");
			$('#q20-grading-'+ (j+1)).css("display", "none");
			$('#qb20-select-'+ (j+1)).css("display", "none");
		}
	}
	$('#q' + i + '-etcflg').prop('checked',false);
	
  }
}

function jumpQuestion(qurl){
	
    window.open().location.href = qurl;
}
function insertJump(){
	
    location.href = "./index.php?type=insert";
}
function analyticsJump(qno){
	
    location.href = "../analytics/index.php?qno=" + qno;
}



function submitQuestion(type_i){
	
	 var type = document.getElementById("type");	 
	 type.value = type_i;
	 
	 var qcount_i = document.getElementById("qcount");	 
	 qcount_i.value = qcount;


	for(var i =1;i <= qcount;i++){

		var selectans_i = "";

		for(j = 0;j < qselect[i-1]; j++){

			var select_d = document.getElementById("q" + i + "-select-" + (j+1)).value;
			if(select_d !== ""){
				if(selectans_i !== "")selectans_i += "<>";
				selectans_i += select_d;
			}
		}
	 	var selectans = document.getElementById("q" + i + "-selectans");
		selectans.value = selectans_i;


	}

	for(var i =1;i <= qcount;i++){

		var gradingarray_i = "";

		for(j = 0;j < qselect[i-1]; j++){
			var grading_d = document.getElementById("q" + i + "-grading-" + (j+1)).value;
			if(grading_d !== ""){
				if(gradingarray_i !== "")gradingarray_i += "<>";
				gradingarray_i += grading_d;
			}
		}
	 	var gradingarray = document.getElementById("q" + i + "-gradingarray");
		gradingarray.value = gradingarray_i;


	}

  	if (type_i === "delete"){
		
		if(confirm("本当に削除しますか？")==true){
			var form = document.getElementById("myForm");
			form.action = "./index.php?type=" + type_i;
			form.submit();
		}
		
	}else{
	
		var form = document.getElementById("myForm");
		form.action = "./index.php?type=" + type_i;
		form.submit();
	}
	
}
