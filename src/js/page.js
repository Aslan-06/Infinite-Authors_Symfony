$('.sectionRoute').each(function(index) {
    $(this).css({"margin" : "0px 0px 0px " + parseInt($(this).attr('class').split(' ')[1].match(/\d+/)[0]) * 50 + "px"})
    if(index < $('.sectionRoute').length-1)
        $(this).css({"color" : "#666666"})
    else
        $(this).css({"color" : "#333333"})
});

let affichageContenu = $('#affichageContenu')
let modificationContenu = $('#modificationContenu')

let contenuEditor = $('#contenu_page_form_contenu')
contenuEditor.css({"font-size" : affichageContenu.css("font-size")})

/******************************************************* */

$('#modifierContenuBtn').click(function(){
    modificationContenu.css({"display" : "block"})
    
    affichageContenu.css({"display" : "none"})

    $('#modifierContenuBtn').css({"display" : "none"})
})

/*
$('#enregistrerContenuBtn').click(function(event){
    let url = '/InfiniteAuthors/public/index.php/livres/9/8/'
    
    axios.get(url).then(function(response){
        console.log("data :" + response.data)

        paragrapheContenu.css({"display" : ""})
    
        modificationContenu.css({"display" : "none"})

        $('#modifierContenuBtn').css({"display" : ""})
    })

    
    event.preventDefault()
})*/