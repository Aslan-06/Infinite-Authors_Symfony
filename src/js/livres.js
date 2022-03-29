$('#creerLivreBtn').click(function () {
    $(this).parent().css({"border-bottom" : "2px lightslategray solid"})
    $('#livreCreationFormDiv').css({"display" : "block"})
})
$('#closeNewLivreForm').click(function () {
    $('#creationLivre').css({"border-bottom" : "5px lightslategray double"})
    $(this).parent().css({"display" : "none"})
})

let defaultImagePath = "/InfiniteAuthors/src/img/image.png"
let imageLivre = $('#imageNewLivre')
imageLivre.on('error', function(){
    $('#imageNewLivre').attr("src", defaultImagePath)
})
$('#lienImageNewLivre').on('input', function(){
    $('#imageNewLivre').attr("src", $(this).val())
})

$('#validerLivreBtn').click(function(event){
    if(!isImageValid() || !isLoginValid())
        event.preventDefault()
})


function isImageValid(){
    return $('#imageNewLivre').attr("src") !== defaultImagePath
}
function isLoginValid(){
    return $('#titreNewLivre').val().length > 0
}