function confirmDelete(redirectUrl, commentId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce commentaire ?")) {
        const formData = new FormData();
        formData.append('commentId', commentId);
        formData.append('action', 'delete');

        fetch(redirectUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // element supprimé avec succès,
                window.location.href = 'adminComments.php?wait=1'; // Recharge la page avec les commentaires mis à jour
            } else {
                // Gestion des erreurs
            }
        })
        .catch(error => {
            // Gestion des erreurs
        });
    }
}
