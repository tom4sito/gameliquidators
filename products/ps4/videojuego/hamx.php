<!DOCTYPE html>
<html>
<head>
<title></title>
<style type="text/css">
	#nav-icon4 {
		width: 40px;
		height: 45px;
		position: relative;
		margin: 50px auto;
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
		-webkit-transition: .5s ease-in-out;
		-moz-transition: .5s ease-in-out;
		-o-transition: .5s ease-in-out;
		transition: .5s ease-in-out;
		cursor: pointer;
	}

	#nav-icon4 span {
		display: block;
		position: absolute;
		height: 3px;
		width: 100%;
		background: #d3531a;
		border-radius: 9px;
		opacity: 1;
		left: 0;
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
		-webkit-transition: .25s ease-in-out;
		-moz-transition: .25s ease-in-out;
		-o-transition: .25s ease-in-out;
		transition: .25s ease-in-out;
	}
	#nav-icon4 {
	}

	#nav-icon4 span:nth-child(1) {
		top: 0px;
		-webkit-transform-origin: left center;
		-moz-transform-origin: left center;
		-o-transform-origin: left center;
		transform-origin: left center;
	}

	#nav-icon4 span:nth-child(2) {
		top: 10px;
		-webkit-transform-origin: left center;
		-moz-transform-origin: left center;
		-o-transform-origin: left center;
		transform-origin: left center;
	}

	#nav-icon4 span:nth-child(3) {
		top: 20px;
		-webkit-transform-origin: left center;
		-moz-transform-origin: left center;
		-o-transform-origin: left center;
		transform-origin: left center;
	}

	#nav-icon4.open span:nth-child(1) {
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		transform: rotate(45deg);
		top: -3px;
		left: 8px;
	}

	#nav-icon4.open span:nth-child(2) {
		width: 0%;
		opacity: 0;
	}

	#nav-icon4.open span:nth-child(3) {
		-webkit-transform: rotate(-45deg);
		-moz-transform: rotate(-45deg);
		-o-transform: rotate(-45deg);
		transform: rotate(-45deg);
		top: 26px;
		left: 8px;
	}
</style>
</head>
<body>
  <div id="nav-icon4">
	<span></span>
	<span></span>
	<span></span>
  </div>
  <script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function(){
  			$(this).toggleClass('open');
  		});
  	});
  </script>
</body>
</html>