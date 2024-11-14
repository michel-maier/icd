import { openModalWithMovieDetails } from './modal.js';

export function initializeAutocomplete() {
    const form = document.querySelector('form[data-url]');
    const input = document.getElementById('movieSearchInput');
    const resultsContainer = document.getElementById('autocompleteResults');
    let debounceTimeout;

    if (!form || !input || !resultsContainer) return;

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

    // Ferme la liste et vide le champ si l'utilisateur clique en dehors
    document.addEventListener('click', (event) => {
        if (!form.contains(event.target) && !resultsContainer.contains(event.target)) {
            resultsContainer.style.display = 'none';
            input.value = '';
        }
    });
}