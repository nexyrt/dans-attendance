<div class="flex h-full">
    {{-- Left Sidebar --}}
    <div class="w-80 bg-white p-4 border-r border-gray-200 overflow-y-auto">
        <div class="space-y-4">
            {{-- Header --}}
            <h2 class="text-lg font-semibold">Geospatial Analysis</h2>

            {{-- Search Box --}}
            <div class="relative">
                <input type="text" wire:model="search"
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Office">
                <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
            </div>

            {{-- Location List --}}
            <div class="space-y-3">
                <h3 class="text-sm font-medium text-gray-700">Office Locations</h3>

                {{-- Location Items --}}
                <div class="space-y-2">
                    @foreach($filteredLocations as $location)
                    <div wire:click="selectLocation({{ $location->id }})"
                        class="p-3 border rounded-lg hover:bg-gray-50 cursor-pointer {{ $selectedLocation && $selectedLocation->id === $location->id ? 'bg-blue-50 border-blue-200' : '' }}">
                        <h4 class="font-medium">{{ $location->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $location->address }}</p>
                        <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                            <i class='bx bx-map'></i>
                            <span>{{ $location->latitude }}, {{ $location->longitude }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Map Section --}}
    <div class="flex-1">
        {{-- Required Leaflet CSS --}}
        <style>
            #map {
                height: calc(100vh - 200px);
                width: 100%;
                z-index: 1;
            }
        </style>

        {{-- Leaflet CSS CDN --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        {{-- Map Container --}}
        <div id="map"></div>

        {{-- Leaflet JS CDN --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        {{-- Map Initialization Script --}}
        <script>
            // Define global variables
            let map = null;
            let marker = null;
            let radiusCircle = null;
    
            function initializeMap() {
                // Get initial coordinates and radius
                const initialLat = @this.latitude || -6.2088;
                const initialLng = @this.longitude || 106.8456;
                const radius = @this.radius || 100; 

                console.log(@this.radius)
    
                if (!map) {
                    map = L.map('map').setView([initialLat, initialLng], 13);
    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                }
    
                if (marker) {
                    map.removeLayer(marker);
                }
                if (radiusCircle) {
                    map.removeLayer(radiusCircle);
                }
    
                // Create new marker
                marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);
    
                // Create radius circle
                radiusCircle = L.circle([initialLat, initialLng], {
                    color: '#2563eb',      // Blue color
                    fillColor: '#3b82f6',  // Lighter blue
                    fillOpacity: 0.1,      // Mostly transparent
                    radius: radius         // Radius in meters
                }).addTo(map);

                marker.on('drag', function(e) {
                    const latLng = marker.getLatLng();
                    radiusCircle.setLatLng(latLng);
                });
    
                marker.on('dragend', function(e) {
                    const latLng = marker.getLatLng();
                    radiusCircle.setLatLng(latLng);
                    @this.$wire.updatedLatitude(latLng.lat);
                    @this.$wire.updatedLongitude(latLng.lng);
                });
            }
    
            document.addEventListener('livewire:initialized', () => {
                initializeMap();
            });
    
            // Listen for Livewire events to update marker and circle
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('updateMarker', data => {
                    if (map && marker && radiusCircle) {
                        const newLatLng = [data.latitude, data.longitude];
                        const radius = data.radius || 100;  // Use provided radius or default
    
                        marker.setLatLng(newLatLng);
                        radiusCircle.setLatLng(newLatLng);
                        radiusCircle.setRadius(radius);
                        map.setView(newLatLng);
                    }
                });
            });
        </script>
    </div>
</div>