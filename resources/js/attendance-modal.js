window.addEventListener('alpine:init', () => {
    Alpine.store('app', {
        isSidebarOpen: window.innerWidth >= 1024,
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        }
    });
});

document.addEventListener('livewire:initialized', () => {
    Livewire.on('success-checkin', () => {
        setTimeout(() => {
            Livewire.dispatch('closeModal');
        }, 1500);
    });

    Livewire.on('success-checkout', () => {
        setTimeout(() => {
            Livewire.dispatch('closeModal');
        }, 1500);
    });
});