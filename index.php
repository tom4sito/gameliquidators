<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>main page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<style type="text/css">
		/* Formatting search box */
		.search-box{
		    width: 300px;
		    position: relative;
		    display: inline-block;
		    font-size: 14px;
		    margin-right: 2px !important;
		}
		.search-box input[type="text"]{
		    height: 32px;
		    padding: 5px 10px;
		    border: 1px solid #CCCCCC;
		    font-size: 14px;
		}
		.result{
		    position: absolute;        
		    z-index: 1;
		    /*top: 100%;*/
		    /*left: 0;*/
		    background-color: #fff;
		}
		.search-box input[type="text"], .result{
		    width: 100%;
		    box-sizing: border-box;
		}
		/* Formatting result items */
		.result p{
		    margin: 0;
		    padding: 7px 10px;
		    border: 1px solid #CCCCCC;
		    border-top: none;
		    cursor: pointer;
		    width: 300px;
		    height: 80px;
		}
		.result p:hover{
		    background: #f2f2f2;
		}
		.img-float{
			float: left;
		}
		.no-wrap{
			display: block;
		}
	</style>
</head>
<body>
<div>
	<?php include 'includes/navbar.php'; ?>
<!-- 	<div class="result" id="result"></div> -->
	<?php include 'includes/carousel.php'; ?>
	<?php echo $_SERVER['DOCUMENT_ROOT']; ?>	
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript">
	// $('.search-box').on("keyup input", function(event){
	//     /* Get input value on change */
	//     var inputVal = $(this).val();
	//     var resultDropdown = $("#result");
	//     if(inputVal.length){
	//         $.get("includes/main_page_search.php", {term: inputVal}).done(function(data){
	//             // Display the returned data in browser
	//             resultDropdown.html(data);
	//         });
	//     } else{
	//         resultDropdown.empty();
	//     }

	//     if (event.which == 13) {
	//         event.preventDefault();
	//         $("#searchform").submit();
	//     }
	// });
</script>
</body>
</html>