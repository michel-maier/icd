import {Modal} from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    /**
     * Modal behaviour and Rating behaviour
     */
    const myModalElement = document.getElementById('myModal');
    const myModal = new Modal(myModalElement);

    // Écoute l'événement d'ouverture du modal
    myModalElement.addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const url = button?.getAttribute('data-url');

        if (url) {
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Erreur de chargement');
                }
                const data = await response.text();
                myModalElement.querySelector('.modal-body').innerHTML = data;
                initializeStarRating(); // Initialise la notation après chargement
            } catch (error) {
                myModalElement.querySelector('.modal-body').innerHTML = '<p>Erreur de chargement du contenu.</p>';
                console.error(error);
            }
        }
    });

    // Vider le champ de recherche lorsque la modale est fermée
    myModalElement.addEventListener('hidden.bs.modal', () => {
        input.value = '';
    });

    function initializeStarRating() {
        const stars = myModalElement.querySelectorAll('.star-rating .star');
        const form = myModalElement.querySelector('.star-rating-form');
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
    }

    function highlightStars(rating) {
        const stars = myModalElement.querySelectorAll('.star-rating .star');
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

    /**
     * Autocomplete behaviour
     */
    const form = document.querySelector('form[data-url]');
    const input = document.getElementById('movieSearchInput');
    const resultsContainer = document.getElementById('autocompleteResults');
    let debounceTimeout;

    input.addEventListener('input', (e) => debounceSearch(e.target.value));

    function debounceSearch(query) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            fetchResults(query);
        }, 300);
    }

    async function fetchResults(query) {
        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            resultsContainer.innerHTML = '';
            return;
        }

        const searchUrl = form.getAttribute('data-url').replace('__QUERY__', encodeURIComponent(query));

        try {
            const response = await fetch(searchUrl);
            if (!response.ok) {
                throw new Error('Erreur de chargement');
            }
            const data = await response.json();
            displayResults(data);
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    function displayResults(results) {
        resultsContainer.innerHTML = '';
        resultsContainer.style.display = 'block';

        if (results.length === 0) {
            resultsContainer.innerHTML = '<li class="list-group-item">Aucun résultat</li>';
            return;
        }

        results.forEach((movie) => {
            const item = document.createElement('li');
            item.className = 'list-group-item cursor-pointer';
            item.textContent = movie.title;
            item.dataset.url = `/movie/${movie.id}`;

            item.addEventListener('click', async () => {
                input.value = movie.title;
                resultsContainer.style.display = 'none';
                await openModalWithMovieDetails(item.dataset.url);
            });

            item.addEventListener('mouseover', () => item.classList.add('bg-light'));
            item.addEventListener('mouseout', () => item.classList.remove('bg-light'));

            resultsContainer.appendChild(item);
        });
    }

    async function openModalWithMovieDetails(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Erreur lors du chargement des détails du film');
            }
            myModalElement.querySelector('.modal-body').innerHTML = await response.text();
            myModal.show();
            initializeStarRating();
        } catch (error) {
            console.error('Erreur lors du chargement des détails du film:', error);
            myModalElement.querySelector('.modal-body').innerHTML = '<p>Erreur de chargement des détails.</p>';
        }
    }

    // Ferme la liste et vide le champ si l'utilisateur clique en dehors
    document.addEventListener('click', (event) => {
        if (!form.contains(event.target) && !resultsContainer.contains(event.target)) {
            resultsContainer.style.display = 'none';
            input.value = '';
        }
    });
});