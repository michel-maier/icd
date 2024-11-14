/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap';

import './js/modal.js';
import './js/autocomplete.js';

// Initialisation des modules
import { initializeModal } from './js/modal.js';
import { initializeAutocomplete } from './js/autocomplete.js';

document.addEventListener('DOMContentLoaded', () => {
    initializeModal();
    initializeAutocomplete();
});


