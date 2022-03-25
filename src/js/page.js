$('.sectionRoute').each(function(index) {
    $(this).css({"margin" : "0px 0px 0px " + parseInt($(this).attr('class').split(' ')[1].match(/\d+/)[0]) * 50 + "px"})
    if(index < $('.sectionRoute').length-1)
        $(this).css({"color" : "#666666"})
    else
        $(this).css({"color" : "black"})
});