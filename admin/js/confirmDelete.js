function confirmDelete(redirectUrl,elementId) {
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
                window.location.href = redirectUrl + '?wait=1';
            } else {
                console.error('Erreur lors de la suppression');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression', error);
        });
    }
}
