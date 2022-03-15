class Composant{

    static compteur = 0;
    id;
    posX;
    posY;
    largeur;
    hauteur;
    
    constructor(){
        this.id = ++Composant.compteur;
        this.largeur = 300;
        this.hauteur = 50;
    }
}
