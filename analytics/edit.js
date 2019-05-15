function shopCodeEdit(){ 
	  
	document.getElementById("shopcode").disabled = false ;
	 return true;
}

function jump(){
  if (confirm("一覧に戻りますか？")==true)
    location.href = "./index.php";
}
