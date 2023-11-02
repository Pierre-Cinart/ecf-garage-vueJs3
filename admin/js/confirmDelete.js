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
                // Commentaire supprimé avec succès, vous pouvez actualiser la page ou effectuer d'autres actions
                location.reload(); // Rechargez la page pour refléter les commentaires mis à jour
            } else {
                // Gestion des erreurs
            }
        })
        .catch(error => {
            // Gestion des erreurs
        });
    }
}
