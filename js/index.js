//########## navbar scripts #####################
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
});