//########## START DYNAMIC SEARCHBAR #####################
$('.search-box').on("keyup input", function(event){
    /* Get input value on change */
    var inputVal = $(this).val();
    var resultDropdown = $("#result");
    if(inputVal.length){
        $.getJSON("/gameliquidators/includes/main_page_search.php", {term: inputVal}).done(function(data){
            // Display the returned data in browser
            // resultDropdown.html(data);
            // console.log(data);
            renderLiveResult(data);
        });
    } else{
        resultDropdown.empty();
    }

    if (event.which == 13) {
        event.preventDefault();
        $("#searchform").submit();
    }
});

function renderLiveResult(jsonObj){
    liveHTML = "";
    rootURL = window.location.host;
    if(jsonObj.result){
        jsonObj.products.forEach(function(ele){
            // productURL = rootURL + "/gameliquidators/products/" + ele.platform + "/" + ele.product_type + "/show/?id=" + ele.id;
            // productURL = productURL.replace(/\s+/g,'').toLowerCase();

            liveHTML += `<div productid='${ele.id}' platform='${ele.platform}' product_name='${ele.product_name}'>`;
            liveHTML +=     `<a href='${ele.product_url}' class='live-product'>`;
            liveHTML +=         `<span class='no-wrap'>${ele.platform}: ${ele.product_name}</span></a>`;
            liveHTML +=     "</a>"
            liveHTML += "</div>";
        });
    }
    else{
        console.log("busqueda no arrojo resultados");
    }

    console.log(liveHTML);
    // liveHTML = "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>";
                // echo "<a href='http://www.n4g.com' class='live-product'>";
                // echo "<img src='$url{$row_img['image_name']}' width='57' height='71' class='img-float'>";
                // echo "<span class='no-wrap'>{$row['platform']}: {$row['title']}</span></a></p>"; 
}

// remove result box when search-box out of focus
var liveProductClicked = false;
$(document).on("mousedown", "a, .basic-search-btn", function() {
    console.log($(this).attr("class"));
    if($(this).hasClass("live-product")){
        liveProductClicked = true;
    }
});
$(".search-box").on("blur", function(event){
    console.log("liveProductClicked: ", liveProductClicked);
    if(!liveProductClicked) // cancel the blur event
    {
        $(this).val("");
        $("#result").empty();
        liveProductClicked = false;
    }
});

//########## END DYNAMIC SEARCHBAR #####################

//########## START NAVBAR EVENTS #####################
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
//########## END NAVBAR EVENTS #####################