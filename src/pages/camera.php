<?php
include_once 'lang.php'; // Assurez-vous que le chemin est correct
$translations = loadLanguage();
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarrez la session uniquement si elle n'est pas déjà active
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $translations['camera_page']; ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        /* Styles pour le canvas superposé */
        #canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Permet de cliquer sur le bouton en dessous */
        }
        #video-container {
            position: relative; /* Pour que le canvas soit positionné par rapport au conteneur vidéo */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-8">
                <div id="video-container">
                    <video id="video" autoplay playsinline></video>
                    <canvas id="canvas"></canvas>
                </div>
                <button id="capture" class="btn btn-primary mt-3">Prendre une photo</button>
            </div>
            <div class="col-md-4">
                <h3>Dernière photo :</h3>
                <div id="photo-sidebar"></div>
                <button id="save" class="btn btn-success mt-3">Poster la photo</button>
            </div>
        </div>

        <!-- Zone des filtres avec un select -->
        <div id="filters" class="mt-4">
            <h3>Choisissez un filtre :</h3>
            <select id="filter-select">
                <option value="">Aucun filtre</option>
                <option value="filters/avion_atterissage.png">Avion qui atterit</option>
                <option value="filters/avion_coeur.png">Avion coeur <3</option>
                <option value="filters/avion.png">Avion</option>
                <option value="filters/campagne.png">Campagne</option>
                <option value="filters/ciel.png">Ciel</option>
                <option value="filters/couchee_soleil.png">Couchée de soleil</option>
                <option value="filters/eau.png">Eau</option>
                <option value="filters/eclair.png">Éclair</option>
                <option value="filters/feu.png">Feu</option>
                <option value="filters/gta.png">GTA</option>
                <option value="filters/maths.png">Maths</option>
                <option value="filters/ecran_brisee.png">Écran brisé</option>
                <option value="filters/nuit_etoile.png">Nuit étoilée</option>
                <option value="filters/pluie.png">Pluie</option>
                <option value="filters/oiseau.png">Oiseau</option>
                <option value="filters/route.png">Route</option>
                <option value="filters/sang.png">Sang</option>
                <option value="filters/smiley_dent_or.png">Smiley dent en or</option>
                <option value="filters/smiley_lunette.png">Smiley à lunette</option>
                <option value="filters/smiley_triste.png">Smiley triste</option>
                <option value="filters/television.png">Télévision</option>
                <!-- Ajoutez d'autres filtres ici -->
            </select>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        // Sélectionner les éléments
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const captureButton = document.getElementById('capture');
        const photoSidebar = document.getElementById('photo-sidebar');
        const saveButton = document.getElementById('save');
        const filterSelect = document.getElementById('filter-select');
        let selectedFilter = null; // Stocker le filtre sélectionné
        let lastCapturedImage = null; // Stocker la dernière image capturée

        // Accéder à la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.addEventListener('loadedmetadata', () => {
                    canvas.width = video.videoWidth; // Définir la largeur du canvas
                    canvas.height = video.videoHeight; // Définir la hauteur du canvas
                    draw(); // Commencer à dessiner en continu
                });
            })
            .catch(err => {
                console.error("Erreur d'accès à la caméra: ", err);
            });

  

        // Ajouter un écouteur d'événement pour capturer la photo
        captureButton.addEventListener('click', () => {
            const canvasCapture = document.createElement('canvas');
            const contextCapture = canvasCapture.getContext('2d');

            // Définir la taille de l'image capturée
            const desiredWidth = 400;
            const desiredHeight = 300;
            canvasCapture.width = desiredWidth;
            canvasCapture.height = desiredHeight;

            // Dessiner l'image de la caméra sur le canvas de capture
            contextCapture.drawImage(video, 0, 0, desiredWidth, desiredHeight);

            // Appliquer le filtre sélectionné (si un filtre est choisi)
            if (selectedFilter) {
                const filterImg = new Image();
                filterImg.src = selectedFilter;
                filterImg.onload = () => {
                    contextCapture.drawImage(filterImg, 0, 0, desiredWidth, desiredHeight); // Superposer le filtre
                    displayPhoto(canvasCapture);
                };
            } else {
                displayPhoto(canvasCapture); // Afficher l'image sans filtre
            }
        });

        // Fonction pour afficher la photo capturée dans la sidebar
        function displayPhoto(canvas) {
            const dataURL = canvas.toDataURL('image/png');
            const img = document.createElement('img');
            img.src = dataURL;
            img.style.width = '300px'; // Ajuster la taille de l'image dans la sidebar
            img.style.height = 'auto'; // Conserver le rapport d'aspect
            photoSidebar.innerHTML = ''; // Effacer la dernière image avant d'ajouter la nouvelle
            photoSidebar.appendChild(img);
            lastCapturedImage = dataURL; // Stocker la dernière image capturée
        }

        // Écouter les changements dans le select pour le filtre
        filterSelect.addEventListener('change', (event) => {
            selectedFilter = event.target.value; // Mettre à jour le filtre sélectionné
        });


        // Fonction pour envoyer l'image au serveur
        saveButton.addEventListener('click', () => {
            if (lastCapturedImage) {
                uploadImage(lastCapturedImage);
            } else {
                alert("Aucune image à sauvegarder !");
            }
        });

        function uploadImage(dataURL) {
            fetch('/upload.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ image: dataURL })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Image envoyée avec succès: ', data);
                alert("Image sauvegardée avec succès !");
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi de l\'image: ', error);
            });
        }
    </script>
</body>
</html>
