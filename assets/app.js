import './styles/app.scss';
import 'bootstrap';

import './js/modal.js';
import './js/autocomplete.js';

import { initializeModal } from './js/modal.js';
import { initializeAutocomplete } from './js/autocomplete.js';

document.addEventListener('DOMContentLoaded', () => {
    initializeModal();
    initializeAutocomplete();
});


