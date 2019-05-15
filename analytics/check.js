
function insertJump(){
	
    location.href = "../mng_question/index.php?type=insert";
}


function downloadJump(qno){
	
    location.href = "./index.php?type=update&qno=" + qno + "&type=download";
}


function questionJump(qno){
	
    location.href = "../mng_question/index.php?type=update&qno=" + qno;
}



