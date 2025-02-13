import 'preline'
import 'flowbite';

import './attendance-modal';
import './leave-flowbite-components';

document.addEventListener('livewire:init', () => {
    Livewire.on('tab-changed', () => {
        setTimeout(() => {
            HSStaticMethods.autoInit();
        });
    });
});