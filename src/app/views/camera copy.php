<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $translations['camera_page']; ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <?php include 'app/views/layout/head.php'; ?>
    <style>
        /* Styles pour le canvas superposé */
        #canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Permet de cliquer sur le bouton en dessous */
        }
        #video-container {
            position: relative; /* Pour que le canvas soit positionné par rapport à la vidéo */
        }
        #photo-sidebar img {
            width: 100%; /* Adapter l'image à la sidebar */
            height: auto;
        }
        /* Ajustement du style de la carte */
        .card-img-top {
            position: relative;
        }
        #video {
            width: 100%;
        }
        /* Masquer la dernière photo avant la capture */
        #last-photo-card {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'app/views/layout/navbar.php'; ?>

    <div class="container">
        <?php if (isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 0): ?>
            <div class="alert alert-warning" role="alert">
                Veuillez valider votre email pour accéder aux posts des autres utilisateurs de Camagru.
            </div>
        <?php else: ?>
        <div class="row">
            <!-- Section de capture vidéo -->
            <div class="col-md-1">
            </div>
            <div class="col-md-6">
                <div class="card h-100 ml-5">
                    <div id="video-container" class="card-img-top">
                        <video id="video" autoplay playsinline></video>
                        <canvas id="canvas"></canvas>
                    </div>
                    <div class="card-body">
                        <div id="filters" class="mt-4">
                            <!-- <h3>Choisissez un filtre :</h3> -->
                            <select id="filter-select" class="form-select">
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
                        <button id="capture" class="btn btn-primary mt-3">Prendre une photo</button>
                    </div>
                </div>
            </div>

            <!-- Sidebar pour le choix des filtres et la dernière photo capturée -->
            <div class="col-md-3">
                <!-- Afficher la dernière photo dans une carte -->
                <div id="last-photo-card" class="card">
                    <img id="last-photo" class="card-img-top" src="" alt="Dernière photo capturée">
                    <div class="card-body">
                        <button id="save" class="btn btn-success mt-3">Poster la photo</button>
                    </div>
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>

    <?php include 'app/views/layout/footer.php'; ?>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const captureButton = document.getElementById('capture');
        const lastPhotoCard = document.getElementById('last-photo-card');
        const lastPhoto = document.getElementById('last-photo');
        const saveButton = document.getElementById('save');
        const filterSelect = document.getElementById('filter-select');
        let selectedFilter = null;
        let lastCapturedImage = null;

        // Accéder à la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.addEventListener('loadedmetadata', () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                });
            })
            .catch(err => {
                console.error("Erreur d'accès à la caméra: ", err);
            });

        // Capture de la photo avec filtre
        captureButton.addEventListener('click', () => {
            const canvasCapture = document.createElement('canvas');
            const contextCapture = canvasCapture.getContext('2d');
            const desiredWidth = 400;
            const desiredHeight = 300;
            canvasCapture.width = desiredWidth;
            canvasCapture.height = desiredHeight;

            contextCapture.drawImage(video, 0, 0, desiredWidth, desiredHeight);

            if (selectedFilter) {
                const filterImg = new Image();
                filterImg.src = selectedFilter;
                filterImg.onload = () => {
                    contextCapture.drawImage(filterImg, 0, 0, desiredWidth, desiredHeight);
                    displayPhoto(canvasCapture);
                };
            } else {
                displayPhoto(canvasCapture);
            }
        });

        // Afficher la photo capturée dans la sidebar
        function displayPhoto(canvas) {
            const dataURL = canvas.toDataURL('image/png');
            lastPhoto.src = dataURL;
            lastCapturedImage = dataURL;

            // Afficher la carte de la dernière photo après la capture
            lastPhotoCard.style.display = 'block';
        }

        // Filtre sélectionné
        filterSelect.addEventListener('change', (event) => {
            selectedFilter = event.target.value;
        });

        // Sauvegarde de l'image capturée
        saveButton.addEventListener('click', () => {
            if (lastCapturedImage) {
                uploadImage(lastCapturedImage);
            } else {
                alert("Aucune image à sauvegarder !");
            }
        });

        // Envoi de l'image au serveur
        function uploadImage(dataURL) {
            fetch('/upload', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ image: dataURL })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirige vers la page d'accueil après une réussite
                    window.location.href = data.redirect;
                } else {
                    console.error('Erreur:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi de l\'image: ', error);
            });
        }
    </script>
</body>
</html>
