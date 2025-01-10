<div class="flex h-screen gap-5">
    {{-- Left Sidebar --}}
    <div class="w-96 bg-white rounded-2xl shadow-lg flex flex-col h-full">
        {{-- Header Section --}}
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                    <i class="bx bx-map-alt text-2xl text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Geospatial Analysis</h2>
            </div>
        </div>

        {{-- Scrollable Content --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Location Details</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea wire:model="address" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"></textarea>
                        @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                            <input type="text" id="latitude" wire:model="latitude" readonly
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                            <input type="text" id="longitude" wire:model="longitude" readonly
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Radius (meters)</label>
                        <input type="number" id="radius" wire:model="radius" min="10"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        @error('radius') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-xl">
                    <button wire:click="saveLocation"
                        class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <i class="bx bx-save text-xl group-hover:animate-bounce"></i>
                        <span>Save Location</span>
                    </button>
                </div>
            </div>

            @if (session()->has('message'))
            <div
                class="bg-green-50 text-green-700 p-4 rounded-lg border border-green-200 flex items-center space-x-2 animate-fade-in">
                <i class="bx bx-check-circle text-xl"></i>
                <span>{{ session('message') }}</span>
            </div>
            @endif


            {{-- Search and Location List Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <div class="relative">
                        <input type="text" wire:model.live="search"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Search office locations...">
                    </div>
                </div>

                <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    @foreach($filteredLocations as $location)
                    <div wire:click="selectLocation({{ $location->id }})"
                        class="p-4 hover:bg-blue-50 cursor-pointer transition-all duration-200 
                        {{ $selectedLocation && $selectedLocation->id === $location->id ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}">
                        <div class="flex items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $location->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $location->address }}</p>
                                <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                    <i class="bx bx-map text-blue-500"></i>
                                    <span>{{ $location->latitude }}, {{ $location->longitude }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Map Section --}}
    <div class="flex-1 h-screen">
        <style>
            #map {
                height: 100%;
                width: 100%;
                border-radius: 16px;
            }

            /* Custom Scrollbar */
            .overflow-y-auto::-webkit-scrollbar {
                width: 6px;
            }

            .overflow-y-auto::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .overflow-y-auto::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .overflow-y-auto::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }

            .selected-marker {
                filter: hue-rotate(120deg);
                transform: scale(1.2);
                transition: all 0.3s ease;
            }
        </style>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <div id="map" wire:ignore></div> <!-- Add wire:ignore -->

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                    const initialLat = -0.49475;
                    const initialLng = 117.14883;
                    const initialRadius = 20;
                
                    // Initialize the map
                    const map = L.map('map').setView([initialLat, initialLng], 20);
                    const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    });
                    tileLayer.addTo(map);
                
                    // Draggable marker for selected location
                    let activeMarker = L.marker([initialLat, initialLng], {
                        draggable: true
                    }).addTo(map);
                
                    let activeCircle = L.circle([initialLat, initialLng], {
                        color: 'blue',
                        fillColor: '#30f',
                        fillOpacity: 0.2,
                        radius: initialRadius
                    }).addTo(map);
                
                    // Object to store all office markers
                    let officeMarkers = {};
                
                    // Handle active marker drag
                    activeMarker.on('drag', function(event) {
                        const position = activeMarker.getLatLng();
                        @this.set('latitude', position.lat);
                        @this.set('longitude', position.lng);
                        activeCircle.setLatLng(position);
                    });
                
                    // Create popup content
                    function createPopupContent(office) {
                        return `
                            <div class="p-3">
                                <h3 class="font-semibold text-lg mb-2">${office.name}</h3>
                                <p class="text-gray-600 text-sm mb-2">${office.address}</p>
                                <div class="text-sm text-gray-500">
                                    <p>Coordinates: ${office.latitude}, ${office.longitude}</p>
                                </div>
                                <button onclick="Livewire.dispatch('selectLocation', { id: ${office.id} })" 
                                    class="mt-3 px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition-colors w-full">
                                    Select Office
                                </button>
                            </div>
                        `;
                    }
                
                    // Handle click on map
                    map.on('click', function(event) {
                        const position = event.latlng;
                        activeMarker.setLatLng(position);
                        @this.set('latitude', position.lat);
                        @this.set('longitude', position.lng);
                        activeCircle.setLatLng(position);
                    });
                
                    // Listen for office locations load
                    Livewire.on('loadOfficeLocations', locations => {
                        // Remove existing markers
                        for (let key in officeMarkers) {
                            map.removeLayer(officeMarkers[key]);
                        }
                        officeMarkers = {};
                
                        // Add markers for all locations
                        locations[0].forEach(office => {
                            const marker = L.marker([office.latitude, office.longitude], {
                                draggable: false // Only active marker is draggable
                            });
                
                            marker.bindPopup(createPopupContent(office));
                            marker.addTo(map);
                            officeMarkers[office.id] = marker;
                        });
                
                        // Fit bounds to show all markers
                        if (locations[0].length > 0) {
                            const bounds = new L.LatLngBounds(locations[0].map(office => [office.latitude, office.longitude]));
                            map.fitBounds(bounds, { padding: [50, 50] });
                        }
                    });
                
                    // Listen for location selection
                    Livewire.on('locationSelected', location => {
                        const newLat = parseFloat(location[0].latitude);
                        const newLng = parseFloat(location[0].longitude);
                        const newRadius = parseInt(location[0].radius) || initialRadius;
                
                        // Update active marker and circle
                        activeMarker.setLatLng([newLat, newLng]);
                        activeCircle.setLatLng([newLat, newLng]);
                        activeCircle.setRadius(newRadius);
                
                        // Animate to the selected location
                        map.flyTo([newLat, newLng], 18, {
                            duration: 1.5,
                            easeLinearity: 0.25,
                        });
                
                        // Close any open popups
                        map.closePopup();
                    });
                });
        </script>
    </div>
</div>