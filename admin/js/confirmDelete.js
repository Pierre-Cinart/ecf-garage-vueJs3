function confirmDelete(redirectUrl, elementId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
        const formData = new FormData();
        formData.append('elementId', elementId);
        formData.append('action', 'delete');
        
        fetch(redirectUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // element supprimé avec succès,
                window.location.href = redirectUrl +'?wait=1'; // Recharge la page avec les commentaires mis à jour
            } else {
                // Gestion des erreurs
            }
        })
        .catch(error => {
            // Gestion des erreurs
        });
    }
}
