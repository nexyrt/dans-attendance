import 'preline'
import 'flowbite';

import './attendance-modal';
import './leave-flowbite-components';

document.addEventListener('livewire:init', () => {
    Livewire.on('refresh-preline', () => {
        setTimeout(() => {
            HSStaticMethods.autoInit();
        });
    });
});