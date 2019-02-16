$('.search-box').on("keyup input", function(event){
    /* Get input value on change */
    var inputVal = $(this).val();
    var resultDropdown = $("#result");
    if(inputVal.length){
        $.get("/gameliquidators/includes/main_page_search.php", {term: inputVal}).done(function(data){
            // Display the returned data in browser
            resultDropdown.html(data);
        });
    } else{
        resultDropdown.empty();
    }

    if (event.which == 13) {
        event.preventDefault();
        $("#searchform").submit();
    }
});