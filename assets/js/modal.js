import { Modal } from 'bootstrap';

export function initializeModal() {
    const myModalElement = document.getElementById('myModal');
    const myModal = new Modal(myModalElement);

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

                const { initializeRating } = await import('./rating.js');
                initializeRating(myModalElement);
            } catch (error) {
                myModalElement.querySelector('.modal-body').innerHTML = '<p>Erreur de chargement du contenu.</p>';
                console.error(error);
            }
        }
    });

    // Vider le champ de recherche lorsque la modale est fermée
    myModalElement.addEventListener('hidden.bs.modal', () => {
        const input = document.getElementById('movieSearchInput');
        if (input) input.value = '';
    });
}

export async function openModalWithMovieDetails(url) {
    const myModalElement = document.getElementById('myModal');
    const myModal = new Modal(myModalElement);

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Erreur lors du chargement des détails du film');
        }
        myModalElement.querySelector('.modal-body').innerHTML = await response.text();
        myModal.show();

        const { initializeRating } = await import('./rating.js');
        initializeRating(myModalElement);
    } catch (error) {
        console.error('Erreur lors du chargement des détails du film:', error);
        myModalElement.querySelector('.modal-body').innerHTML = '<p>Erreur de chargement des détails.</p>';
    }
}