// Exécution lorsque le bouton "like" est cliqué
$(document).ready(function() {
    // Quand le bouton "like" est cliqué
    $('.like-button').on('click', function() {
        var imageId = $(this).data('image-id'); // Récupérer l'ID de l'image
        var likeButton = $(this); // Référence à l'élément cliqué

        $.ajax({
            url: '/like_image', // URL du serveur pour traiter le like
            method: 'POST',
            data: { image_id: imageId },
            dataType: 'json',
            success: function(response) {
                if (response.message.includes('ajouté')) {
                    likeButton.addClass('liked'); // Ajouter la classe 'liked' au bouton
                } else if (response.message.includes('supprimé')) {
                    likeButton.removeClass('liked'); // Retirer la classe 'liked' du bouton
                }
                
                // Mettre à jour le compteur de likes
                $('#likes-count-' + imageId).text(response.likes_count);

                // Envoi d'un e-mail de notification
                $.ajax({
                    url: '/send-email', // URL pour envoyer l'e-mail
                    method: 'POST',
                    data: {
                        image_id: imageId,
                        // Ajouter d'autres données si nécessaire, par exemple le nom d'utilisateur
                    },
                    dataType: 'json',
                    success: function(emailResponse) {
                        console.log(emailResponse.message); // Message de confirmation de l'e-mail
                    },
                    error: function(emailError) {
                        // console.error("Erreur lors de l'envoi de l'e-mail : " + emailError.responseText);
                    }
                });

                
            },
            error: function(xhr) {
                console.error("Erreur lors du traitement : " + xhr.responseText);
            }
        });
    });
});