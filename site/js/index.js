// 1. On déclare notre fonction avec un nom clair
function afficherErreurConnexion() {
    // On analyse l'URL
    const urlParams = new URLSearchParams(window.location.search);
    
    
    // Si on trouve "?error=1"
    if (urlParams.has('error')) {

        const codeErreur = urlParams.get('error');

        let messageErreur;

        if(codeErreur === '1'){
            messageErreur = "Mot de passe ou identifiant incorrect.";
        }else if(codeErreur === '2'){
            messageErreur = "Cette email est deja utiliser.";
        } else if(codeErreur === '3'){
            messageErreur = "Le format de l'adresse email est invalide.";
        } else if(codeErreur === '4'){
            messageErreur = "Ce fournisseur d'email n'existe pas.";
        }

        const spanErreur = document.createElement("span");
        spanErreur.className = "message-erreur";
        spanErreur.textContent = messageErreur;

        const parentDiv = document.querySelector('.container-col');

        parentDiv.appendChild(spanErreur);

        if(spanErreur){
            spanErreur.style.color = "#ff4d4d";
            spanErreur.style.fontSize = "1.2rem";
        }
        
    }
}


function loadVerificationFunctions(){
    afficherErreurConnexion();
}

// 2. On dit au navigateur : "Quand la page est chargée, lance cette fonction"
document.addEventListener("DOMContentLoaded", loadVerificationFunctions);