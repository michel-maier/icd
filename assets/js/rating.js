export function initializeRating(modalElement) {
    const stars = modalElement.querySelectorAll('.star-rating .star');
    const form = modalElement.querySelector('.star-rating-form');
    if (!form) return;

    const inputRating = form.querySelector('input[name="rating"]');
    const currentRating = parseInt(inputRating.getAttribute('data-current-rating'), 10) || 0;
    let selectedRating = 0;

    // Affiche le score actuel au chargement
    highlightStars(currentRating);

    stars.forEach((star) => {
        const rating = parseInt(star.getAttribute('data-value'), 10);

        // Survol pour colorer les étoiles
        star.addEventListener('mouseover', () => highlightStars(rating));

        // Sortie du survol : restaure la sélection ou le score actuel
        star.addEventListener('mouseout', () => highlightStars(selectedRating || currentRating));

        // Clic pour sélectionner la note
        star.addEventListener('click', () => {
            selectedRating = rating;
            inputRating.value = rating;
            submitRating(form);
        });
    });

    function highlightStars(rating) {
        stars.forEach((star) => {
            const starValue = parseInt(star.getAttribute('data-value'), 10);
            if (starValue <= rating) {
                star.classList.add('text-primary');
                star.classList.remove('text-muted');
            } else {
                star.classList.remove('text-primary');
                star.classList.add('text-muted');
            }
        });
    }

    async function submitRating(form) {
        const formData = new FormData(form);
        const actionUrl = form.getAttribute('action');

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData,
            });
            if (!response.ok) {
                throw new Error('Erreur de soumission');
            }
            await response.text();
            alert('Votre vote a bien été pris en compte !');
        } catch (error) {
            alert('Une erreur est survenue. Veuillez réessayer.');
            console.error(error);
        }
    }
}