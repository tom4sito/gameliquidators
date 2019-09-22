<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>main page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/fontawesome59/css/all.min.css">
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
<div class="super-container">
	<?php include 'includes/navbar2.php'; ?>
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

	$(".submenu-item").on("click", function(event){
		event.stopPropagation();
		if(!$(this).hasClass("active-drop")){
			$(this).addClass("active-drop");
			drop_div_id = "#" + $(this).attr("target-drop-id");
			$(drop_div_id).removeClass("display-off");
		}else{
			$(this).removeClass("active-drop");
			drop_div_id = "#" + $(this).attr("target-drop-id");
			$(drop_div_id).addClass("display-off");
		}
	});
	$('#nav-icon4').click(function(){
		$(this).toggleClass('open');
		// if(!$(this).hasClass("active-mobile")){
		// 	$(this).toggleClass('open');
		// 	$(this).addClass("active-mobile");
		// 	$(".hide-mobile").addClass("show-mobile").removeClass("hide-mobile");
		// }
		// else{
		// 	$(this).toggleClass('open');
		// 	$(this).removeClass("active-mobile")
		// 	$(".show-mobile").addClass("hide-mobile").removeClass("show-mobile");
		// 	$("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
		// 	$(".active-drop").removeClass("active-drop");
		// 	$(".submenu-item-drop").addClass("display-off");

		// }
	});
</script>
</body>
</html>