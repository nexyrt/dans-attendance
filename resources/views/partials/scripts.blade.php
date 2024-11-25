<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('success-checkin', () => {
            setTimeout(() => {
                Livewire.dispatch('closeModal');
            }, 1500);
        });
    
        Livewire.on('error-checkin', () => {
            Livewire.dispatch('closeModal');
        });
    });
    </script>