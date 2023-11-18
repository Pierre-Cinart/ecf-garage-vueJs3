function confirmDelete(thisUrl ,redirectUrl, elementId) {
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
                // Element supprimé avec succès, redirige vers la page avec les éléments mis à jour
                window.location.href = redirectUrl + '?wait=1';
            } else {
                // Gestion des erreurs
                console.error('Erreur lors de la suppression');
            }
        })
        .catch(error => {
            // Gestion des erreurs
            console.error('Erreur lors de la suppression', error);
        });
    } else {
        // Annulation de la suppression, redirige simplement vers la page actuelle
        window.location.href = thisUrl;
    }
}
