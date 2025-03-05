<div class="">
    {{-- Left Sidebar --}}
    <div class="md:col-span-1 w-full bg-white rounded-2xl shadow-lg flex flex-col">
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
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-700">
                        {{ $isEditing ? 'Edit Location' : 'Location Details' }}
                    </h3>
                    @if ($isEditing)
                        <button wire:click="cancelEdit" class="text-gray-500 hover:text-gray-700">
                            <i class="bx bx-x text-xl"></i>
                        </button>
                    @endif
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea wire:model="address" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"></textarea>
                        @error('address')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
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
                        @error('radius')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-xl space-y-3">
                    <button wire:click="saveLocation"
                        class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2">
                        <i class="bx {{ $isEditing ? 'bx-check' : 'bx-save' }} text-xl"></i>
                        <span>{{ $isEditing ? 'Update Location' : 'Save Location' }}</span>
                    </button>

                    @if ($selectedLocation && !$isEditing)
                        <div class="flex gap-2">
                            <button wire:click="editLocation"
                                class="flex-1 bg-amber-500 text-white px-4 py-2.5 rounded-lg hover:bg-amber-600 focus:ring-4 focus:ring-amber-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2">
                                <i class="bx bx-edit text-xl"></i>
                                <span>Edit</span>
                            </button>
                            <button wire:click="deleteLocation"
                                onclick="return confirm('Are you sure you want to delete this location?')"
                                class="flex-1 bg-red-500 text-white px-4 py-2.5 rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2">
                                <i class="bx bx-trash text-xl"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    @endif
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
                    @foreach ($filteredLocations as $location)
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
    <div class="md:col-span-2 h-[calc(100vh-8rem)] sticky top-24">
        <style>
            #map {
                height: 100%;
                width: 100%;
                border-radius: 16px;
            }

            .overflow-y-auto {
                max-height: calc(100vh - 12rem);
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

        <div class="h-full relative rounded-2xl overflow-hidden shadow-lg">
            <div id="map" wire:ignore></div>
        </div>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                    draggable: false
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

                // Handle dragend event
                activeMarker.on('dragend', function(event) {
                    const position = activeMarker.getLatLng();
                    @this.set('latitude', position.lat);
                    @this.set('longitude', position.lng);
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

                // Handle click on map (only when not editing)
                map.on('click', function(event) {
                    if (!@this.isEditing) { // Only allow new markers when not in edit mode
                        const position = event.latlng;
                        activeMarker.setLatLng(position);
                        @this.set('latitude', position.lat);
                        @this.set('longitude', position.lng);
                        activeCircle.setLatLng(position);
                    }
                });

                // Listen for edit mode changes
                Livewire.on('editModeChanged', isEditing => {
                    activeMarker.dragging.enable(); // Enable dragging in edit mode
                    if (isEditing) {
                        activeMarker.getElement().style.cursor = 'move';
                    } else {
                        activeMarker.getElement().style.cursor = '';
                    }
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
                            draggable: false
                        });

                        marker.bindPopup(createPopupContent(office));
                        marker.addTo(map);
                        officeMarkers[office.id] = marker;
                    });

                    // Fit bounds to show all markers
                    if (locations[0].length > 0) {
                        const bounds = new L.LatLngBounds(locations[0].map(office => [office.latitude, office
                            .longitude
                        ]));
                        map.fitBounds(bounds, {
                            padding: [50, 50]
                        });
                    }
                });

                // Listen for location selection
                Livewire.on('locationSelected', location => {
                    const newLat = parseFloat(location[0][0].latitude);
                    const newLng = parseFloat(location[0][0].longitude);
                    const newRadius = parseInt(location[0][0].radius) || initialRadius;

                    // Update active marker and circle
                    activeMarker.setLatLng([newLat, newLng]);
                    activeCircle.setLatLng([newLat, newLng]);
                    activeCircle.setRadius(newRadius);

                    // Enable or disable dragging based on edit mode
                    activeMarker.dragging[location[0] ? 'enable' : 'disable']();

                    // Animate to the selected location
                    map.flyTo([newLat, newLng], 18, {
                        duration: 1.5,
                        easeLinearity: 0.25,
                    });

                    // Close any open popups
                    map.closePopup();
                });

                // Listen for radius updates
                Livewire.on('radiusUpdated', radius => {
                    activeCircle.setRadius(radius);
                });
            });
        </script>
    </div>
</div>
