

//新規作成の時の初期表示
function initDisplay(){
		
		for(var i =0;i <= qcount;i++){
			$('.abox-' + (i+1)).css("display", "none");
		}
		$('.abox-end').css("display", "none");
}


function start(){
		qnow = 1;
		
		$('.abox-start').css("display", "none");
		
		$('.abox-' + qnow).css("display", "block");
}

function next(){				
		//必須入力チェック
		if($('.req-'+ qnow).val() === "1"){
			if($('.type-'+ qnow).val() === "4"){
				//年月日をそれぞれ取得ひとつでも入力がなければエラー
                date_error = false;

				date_y = "";
                if($('.answer-y-'+ qnow).val() === "0" || $('.answer-y-'+ qnow).val() === undefined){
                    date_error = true;
                }else{
                    date_y = $('.answer-y-'+ qnow).val();
				}

                date_m = "";
                if($('.answer-m-'+ qnow).val() === "0" || $('.answer-m-'+ qnow).val() === undefined){
                    date_error = true;
                }else{
                    date_m = $('.answer-m-'+ qnow).val();
                }

                if(date_error){
                    alert("この質問は必須入力です。"+$('.answer-'+ qnow).val());
                    return;
                }else{

                    $('.answer-'+ qnow).val(date_y + "-" + date_m);
				}

				//全部選択されている時、hiddenに設定する
			}else if($('.answer-'+ qnow).val() === "" || $('.answer-'+ qnow).val() === undefined){
				alert("この質問は必須入力です。"+$('.answer-'+ qnow).val());
				return;
			}
		}
		
		$('.abox-' + qnow).css("display", "none");
		
		if(qnow < qcount){
			qnow = qnow + 1;
			$('.abox-' + qnow).css("display", "block");
		}else{
			$('.abox-end').css("display", "block");
		}
		
}
function prev(){
		//必須入力チェック
		
		$('.abox-' + qnow).css("display", "none");
		
		if(qnow > 1){
			qnow = qnow - 1;
			$('.abox-' + qnow).css("display", "block");
		}else{
			$('.abox-start').css("display", "block");
		}
		
		
}
function prev_end(){
		$('.abox-end').css("display", "none");
		
		$('.abox-' + qnow).css("display", "block");		
}

function ansSubmit(){
		var form = document.getElementById("myForm");
		form.submit();
}

function answerCheck(qno_d){
	//該当の問題の選択肢チェックボックス合体してhiddenにセットする。
	$('.answer-'+ qno_d).val("");
	var answer = "";
	
	$(':checkbox[name="answer-i-' + qno_d + '"]:checked').each(function(index, checkbox) {
  		if(answer !== "") answer += "<>";
  		answer += $(checkbox).val();
	});
	
	$('.answer-'+ qno_d).val(answer);
}
function answerRadio(qno_d){
	//該当の問題の選択肢チェックボックス合体してhiddenにセットする。
	$('.answer-'+ qno_d).val("");
	var answer = $('input[name="answer-i-' + qno_d + '"]:checked').val();
	
	$('.answer-'+ qno_d).val(answer);

	//単一選択式は選ばれたらすぐに次の画面へ
    setTimeout("next()", 500);
}
function answerPulldown(qno_d){
	//プルダウンメニューを取得し、hiddenにセットする。
	$('.answer-'+ qno_d).val("");
	var answer = $('select[name="answer-p-' + qno_d + '"] option:selected').val();
	$('.answer-'+ qno_d).val(answer);
}



