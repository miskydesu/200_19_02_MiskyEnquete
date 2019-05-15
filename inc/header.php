<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= $html_title; ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="../css/style.css">
	<link rel="stylesheet" type="text/css" media="all" href="../css/pagination.css">
	<script src="../js/jquery-1.11.3.min.js" charset="utf-8"></script>
	<script src="../js/jquery.pagination.js" charset="utf-8"></script>
	<script src="../js/jquery.hoverIntent.js" charset="utf-8"></script>
	<script src="../js/common.js" charset="utf-8"></script>
	<script type="text/javascript">
		function pageselectCallback(page_index, jq){
			var new_content = jQuery('#hiddenresult div.result:eq('+page_index+')').clone();
			$('#Searchresult').empty().append(new_content);
			return false;
		  }
		  function initPagination() {
			  var num_entries = jQuery('#hiddenresult div.result').length;
			  $(".Pagination").pagination(num_entries, {
				  callback: pageselectCallback,
				  items_per_page:1,
			  });
		  }
		  $(document).ready(function(){
			  initPagination();
		  });
    </script>
</head>
<body class="<?= $body_class; ?>">