<!-- views/image_show.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/css/styles.css">
      <link rel="stylesheet" href="/public/css/navbar.css">
      <?php include 'app/views/layout/head.php'; ?>
      <title><?php echo htmlspecialchars($image[0]['username']); ?></title>
    </head>
    <body>
        <?php include 'app/views/layout/navbar.php'; ?>
      <div class="container">

        <div class="row">
          <div class="col-6">
            <div class="card h-100">
              <img class="card-img-top" src="/<?php echo $image[0]['image']; ?>" alt="Card image">
              <div class="card-body">
                <h4 class="card-title">@<?php echo $image[0]['username']; ?></h4>

                <p class="card-text"><?php echo $image[0]['created_at']; ?></p>
                <p>
                <span id="likes-count-<?php echo $image[0]['id']; ?>"><?php echo $image[0]['nb_likes']; ?></span>
                  <i style="cursor:pointer;" class="fa fa-heart like-button <?php echo($image[0]['user_like'] == 1) ? 'liked' : '' ?>" aria-hidden="true" data-image-id="<?php echo $image[0]['id']; ?>"></i>
                  <?php echo $image[0]['nb_comments']; ?> <i class="fa fa-comment" aria-hidden="true"></i>
                </p>
                <?php if ($image[0]['username'] === $_SESSION['username']): ?>
                  <button type="button" class="btn btn-danger" onclick="deletePost(<?php echo $image[0]['id']; ?>)">Supprimer le post</button>

                <?php endif; ?>

              </div>
            </div>
          </div>
          <div class="col-5">
              <h2>Commentaires</h2>
              <ul>
                  <?php foreach ($comments as $comment): ?>
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">@<?php echo $comment['username']; ?></h4>

                            <p class="card-text"><?php echo $comment['created_at']; ?></p>
                            <p>
                            <?php echo htmlspecialchars($comment['comment']); ?>
                            </p>
                        </div>
                    </div>
                    <br>
                    <?php endforeach; ?>
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">Ajouter un commentaire</h4>
                            <p>
                                <textarea class="form-control" name="comment" rows="3" placeholder="Écrivez votre commentaire ici..." required  id="submit-comment"></textarea>
                                <input type="hidden" name="image_id" value="<?php echo $imageId; ?>"> 
                                <button type="submit" id="submit" class="btn btn-primary">Commenter</button>
                            </p>
                        </div>
                    </div>
                </ul>
          </div>
        </div>
        </div>
        
    </body>
      <?php include 'app/views/layout/footer.php'; ?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const commentSubmit = document.getElementById('submit'); // Assurez-vous que l'ID du bouton est correct
    const commentText = document.getElementById('submit-comment'); // Assurez-vous que l'ID du textarea est correct
    const imageId = document.getElementById('image-id'); // Assurez-vous que l'ID du champ caché pour l'ID de l'image est correct

    commentSubmit.addEventListener('click', function(event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        const comment = commentText.value; // Récupérer le texte du commentaire
console.log(comment);
        // Envoyer les données via AJAX
        fetch('/submit-comment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Spécifiez que nous envoyons du JSON
            },
            body: JSON.stringify({ comment: comment, image_id: <?php echo $image[0]['id']; ?> }) // Convertir l'objet en JSON
        });
        location.reload(); 
        
    });
});

function deletePost(postId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce post ?')) {
        fetch('/delete-post', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ postId: postId }),
        })
        .then(response => response.json())
        // .then(data => {
        //     if (data.success) {
        //         // Redirection ou mise à jour de la page
        //         window.location.href = '/posts'; // Redirigez vers la page des posts
        //     } else {
        //         alert('Erreur lors de la suppression du post : ' + data.message);
        //     }
        // })
        .then(data => {
                if (data.success) {
                    // Redirige vers la page d'accueil après une réussite
                    window.location.href = data.redirect;
                } else {
                    console.error('Erreur:', data.message);
                }
            })
        .catch(error => {
            console.error('Erreur lors de la suppression du post :', error);
            alert('Une erreur est survenue lors de la suppression du post.');
        });
    }
}
</script>
<script src="/public/js/home.js"></script>


</html>
