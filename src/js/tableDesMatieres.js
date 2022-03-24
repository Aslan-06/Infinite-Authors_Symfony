// Pour chaque bouton de creation d'une sous section, ajoutons un listener de click
$('.newSousSection').click(function(event){
    event.preventDefault() // cette fonction sert a ne pas rafraichir la page, et donc rester là où on en est

    //Si le message indiquant qu'on a atteint le niveau maximum des sous sections, on l'enleve
    if($('#msgMaxNiveau').length)
        $('#msgMaxNiveau').remove()
    
    //On essaye de trouver une formulaire par son id, si on le trouve, on ne recrée pas une autre
    if(!$('#titreNewSection').length){
        let niveauNewSection = getNiveau($(this).parent().find("h4")) + 1
        let dernierSectionMemeNiveau = $(this).parent()
        
        /* On a le niveau de nouvelle sous section, donc on cherche une section qui a un niveau inférieur, pour placer la nouvelle sous section
        *  avant lui
        */
        do{
            dernierSectionMemeNiveau = dernierSectionMemeNiveau.next()
        }
        while(dernierSectionMemeNiveau.hasClass("section") && getNiveau(dernierSectionMemeNiveau.find("h4")) != 0 &&  getNiveau(dernierSectionMemeNiveau.find("h4")) >= niveauNewSection);

        if(niveauNewSection < 5){
            $(newTitreFormulaire()).insertBefore(dernierSectionMemeNiveau)
            $('#newSectionForm').addClass("niveau" + niveauNewSection)
            $('#newSectionForm').css({"margin-left" : niveauNewSection * 50 + "px"})
            $('#titreNewSection').focus()

            initListenersCreationSection()
        }
        else{
            // niveau de sous section trés élèvé, donc pas de creation, et affichons une alerte
            $('<div id="msgMaxNiveau">Vous etez atteint au niveau maximum des sous sections</div>').insertBefore(dernierSectionMemeNiveau)
            $('#msgMaxNiveau').css({"margin-left" : niveauNewSection * 50 + "px",
                                    "width" : "max-content",
                                    "padding" : "7px",
                                    "font-size" : "13px",
                                    "background-color":"#FFA8AC",
                                    "color":"#842034",
                                    "border" : "1px #FD7071 solid",
                                    "border-radius" : "5px"
                                    })
            $('#msgMaxNiveau').click(function(){
                $(this).remove()
            })
        }
    }
})
// Pour la creation d'une section c'est la formulaire on peut afficher directement
$('#newSection').click(function(event){
    event.preventDefault()
    if(!$('#titreNewSection').length){
        $(newTitreFormulaire()).insertBefore($(this).parent())
        $('#newSectionForm').addClass("niveau" + 0)
        $('#titreNewSection').focus()

        initListenersCreationSection()
    }
})

function initListenersCreationSection(){
    //Pour le bouton annuler, on enleve la formulaire de creation de section
    $('#cancelCreationBtn').click(function(event){
        event.preventDefault()
        $('#newSectionForm').remove()
    })

    //Pour le bouton de validation de creation de section, nous allons anvoyer une requete en ajax
    $('#validateCreationBtn').click(function(event){
        event.preventDefault()

        //Nous allons recuperer l'element précédent de la formaulaire afin de mettre aprés lui, la nouvelle section
        let elementSupANouveau = $('#newSectionForm').prev()
        //Recuperons l'indice de la formulaire dans son parent, en gros nous remplacerons la formulaire par la nouvelle section

        let titreSection = $('#titreNewSection').val();
        let numSequence = $('#newSectionForm').index()
        let niveau = parseInt($('#newSectionForm').attr('class').match(/\d+/)[0]) + 1

        $('#newSectionForm').remove()

        $.ajax({
            method: "POST",
            data: {titreSection: titreSection, numSequence: numSequence, niveau: niveau}
        }).done(function(data){
            location.reload()
        });
    })
}

function newTitreFormulaire(){
    return   '<form id="newSectionForm">'
            +    '<label id="labelNewSectionForm" for="titre">Section : </label>'
            +    '<input id="titreNewSection" type="text" name="titre">'
            +    '<button id="validateCreationBtn" class="btnCreationSection"><img class="iconsCreationSection" src="/InfiniteAuthors/src/img/mark.png" value="" alt="Valider"></button>'
            +    '<button id="cancelCreationBtn" class="btnCreationSection"><img class="iconsCreationSection" src="/InfiniteAuthors/src/img/cancel.png" value="" alt="Annuler"></button>'
            +'</form>'
}

let marginLeftValue = 50
$('.titreSection').each(function(){
    $(this).css({"margin-left" : getNiveau($(this)) * marginLeftValue + "px"}) // chaque section prend son tabluation en fonction de son nb de sous sections
})

/*
let resizeObserver = new ResizeObserver((elements) => {
    elements.forEach(element => {
        let sectionDiv = element.target
        
        let sectionTitre = sectionDiv.children[0];
        let sectionTitreBounds = sectionTitre.getBoundingClientRect()
        let extremiteDroiteTitre = sectionTitreBounds.x + sectionTitreBounds.width

        let sousSectionBtn = sectionDiv.children[1]
        let xPosSousSectionBtn = sousSectionBtn.getBoundingClientRect().x // la position en x de bouton de creation de sous section
        //element.target.parentElement.children[2].style.borderBottom = "";
        if(parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) > 0 && extremiteDroiteTitre + parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) > xPosSousSectionBtn - parseInt(getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0])){
            console.log("bonjour 1")
            sectionTitre.style.marginRight = extremiteDroiteTitre + parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) - (xPosSousSectionBtn - parseInt(getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0])) + "px"
        }
        else if(parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) == 0 && extremiteDroiteTitre + parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) > xPosSousSectionBtn - parseInt(getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0])){
            console.log("bonjour 2")
            sousSectionBtn.style.marginLeft = extremiteDroiteTitre + parseInt(getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0]) - (parseInt(getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0]) - xPosSousSectionBtn) + "px"
        }
        else{
            console.log("bonjour 3")
            sousSectionBtn.style.marginLeft = 50+"px"
        }
        //
        else if(extremDroiteTitre + getComputedStyle(sectionTitre).marginRight.match(/\d+/)[0] > xPosSsousSectionBtn - getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0]){
            if(xPosSSectionBtn - getComputedStyle(sSectionBtn).marginLeft.match(/\d+/)[0] >= extremDroiteTitre)
                sectionTitre.style.marginRight = xPosSousSectionBtn - getComputedStyle(sousSectionBtn).marginLeft.match(/\d+/)[0] + "px"
        }//
    })
    //elements.each(function(){
        console.log(1);
    })
    let elemWidth = element[1].borderBoxSize[0].inlineSize;
    console.log(elemWidth)
    if( elemWidth <= 10)
        hideTirets($(element[0]));//
});


$('.section').each(function(){
    resizeObserver.observe($(this)[0]);
})
*/

function getNiveau(section){
    return parseInt(section.attr('class').split(' ')[1].match(/\d+/)[0])
}

function hideTirets(){
    tirets.css({"display" : "none"})
}
function showTirets(){
    tirets.css({"display" : ""})
}

function marginLeft(element){
    return parseInt(getComputedStyle(element).marginLeft.match(/\d+/)[0])
}
function marginRight(element){
    return parseInt(getComputedStyle(element).marginRight.match(/\d+/)[0])
}