<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management | HomeDhek Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Dropdown toggle */
        .dropdown-toggle:focus + .dropdown-menu {
            display: block;
        }
        
        /* Price range slider */
        .price-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            outline: none;
            border-radius: 4px;
        }
        
        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #1a4977;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .price-slider::-moz-range-thumb {
            width: 16px;
            height: 16px;
            background: #1a4977;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex justify-between items-center h-16 px-4">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="ml-4 lg:ml-0">
                    <span class="text-[#1a4977] font-bold text-xl">HomeDhek Admin</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-gray-500 focus:outline-none focus:text-gray-700 relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">4</span>
                    </button>
                </div>
                <div class="relative">
                    <div class="flex items-center text-gray-700 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white">
                            A
                        </div>
                        <span class="ml-2 text-sm font-medium hidden md:block">Admin User</span>
                        <i class="fas fa-chevron-down ml-2 text-xs hidden md:block"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 bg-white shadow-md w-64 pt-16 transform transition-transform duration-300 lg:translate-x-0 z-10 -translate-x-full">
            <div class="overflow-y-auto h-full">
                <nav class="mt-5 px-2">
                    <div class="space-y-1">
                        <a href="./" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-home mr-3 text-gray-500"></i>
                            Dashboard
                        </a>
                        <a href="properties.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-[#1a4977] text-white">
                            <i class="fas fa-building mr-3"></i>
                            Properties
                        </a>
                        <a href="users.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-users mr-3 text-gray-500"></i>
                            Users
                        </a>
                        <a href="inquiries.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-comment-dots mr-3 text-gray-500"></i>
                            Inquiries
                        </a>
                        <a href="settings.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>
                    </div>
                    
                    <div class="mt-10">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shortcuts</h3>
                        <div class="mt-2 space-y-1">
                            <a href="add-property.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-[#1a4977] hover:bg-blue-50">
                                <i class="fas fa-plus-circle mr-3 text-[#1a4977]"></i>
                                Add New Property
                            </a>
                            <a href="pending-approvals.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-clock mr-3 text-gray-500"></i>
                                Pending Approvals
                                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full">3</span>
                            </a>
                            <a href="export-data.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-download mr-3 text-gray-500"></i>
                                Export Data
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 lg:ml-64 ml-0">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Session Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div id="session-success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div id="session-error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <!-- AJAX Message Placeholders -->
                <div id="ajax-success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline" id="ajax-success-text"></span>
                </div>
                <div id="ajax-error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline" id="ajax-error-text"></span>
                </div>

                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Properties</h1>
                    <div class="mt-4 sm:mt-0">
                        <a href="add-property.php" class="bg-[#1a4977] text-white px-4 py-2 rounded-md flex items-center text-sm">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add New Property
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-semibold text-gray-900">Filters</h2>
                        <button id="toggle-advanced-filters" class="text-sm text-[#1a4977] flex items-center">
                            <span id="advanced-filters-text">Show Advanced Filters</span>
                            <i class="fas fa-chevron-down ml-1 text-xs" id="advanced-filters-icon"></i>
                        </button>
                    </div>
                    
                    <!-- Basic Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" id="search" class="w-full border rounded-lg px-3 py-2 pl-9" placeholder="Search by name or location">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label for="property-type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                            <select id="property-type" class="w-full border rounded-lg px-3 py-2">
                                <option value="">All Types</option>
                                <option value="pg">PG</option>
                                <option value="hostel">Hostel</option>
                                <option value="apartment">Apartment</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" class="w-full border rounded-lg px-3 py-2">
                                <option value="">All Status</option>
                                <option value="active">Active</option> <!-- Mapped to 'available' in backend -->
                                <option value="pending">Pending</option> <!-- Might need specific backend handling if not 'unavailable' -->
                                <option value="inactive">Inactive</option> <!-- Mapped to 'unavailable' in backend -->
                            </select>
                        </div>
                    </div>
                    
                    <!-- Advanced Filters (Hidden by default) -->
                    <div id="advanced-filters" class="hidden border-t pt-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="price-range" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                                <div class="px-2">
                                    <input type="range" id="price-range" min="0" max="50000" value="50000" step="1000" class="price-slider mb-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500">₹0</span>
                                        <span class="text-xs text-gray-500" id="price-display">₹50,000+</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="category" class="w-full border rounded-lg px-3 py-2">
                                    <option value="">All Categories</option>
                                    <option value="girls">Girls Only</option>
                                    <option value="boys">Boys Only</option>
                                    <option value="coed">Co-ed</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="sort-by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                <select id="sort-by" class="w-full border rounded-lg px-3 py-2">
                                    <option value="latest">Latest Added</option>
                                    <option value="name-asc">Name (A-Z)</option>
                                    <option value="name-desc">Name (Z-A)</option>
                                    <option value="price-asc">Price (Low to High)</option>
                                    <option value="price-desc">Price (High to Low)</option>
                                    <option value="rating-desc">Rating (High to Low)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amenities</label>
                            <div id="amenities-filter-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                <!-- Amenity IDs are from database.sql pre-population -->
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-wifi" name="amenities[]" value="1" class="mr-2">
                                    <label for="amenity-wifi" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-wifi text-gray-400 mr-1"></i> WiFi
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-food" name="amenities[]" value="2" class="mr-2">
                                    <label for="amenity-food" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-utensils text-gray-400 mr-1"></i> Food
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-tv" name="amenities[]" value="3" class="mr-2">
                                    <label for="amenity-tv" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-tv text-gray-400 mr-1"></i> TV
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-bathroom" name="amenities[]" value="4" class="mr-2">
                                    <label for="amenity-bathroom" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-bath text-gray-400 mr-1"></i> Attached Bathroom
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-refrigerator" name="amenities[]" value="5" class="mr-2">
                                    <label for="amenity-refrigerator" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-snowflake text-gray-400 mr-1"></i> Refrigerator
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-ac" name="amenities[]" value="6" class="mr-2">
                                    <label for="amenity-ac" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-wind text-gray-400 mr-1"></i> AC
                                    </label>
                                </div>
                                 <div class="flex items-center">
                                    <input type="checkbox" id="amenity-gym" name="amenities[]" value="7" class="mr-2">
                                    <label for="amenity-gym" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-dumbbell text-gray-400 mr-1"></i> Gym
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-laundry" name="amenities[]" value="8" class="mr-2">
                                    <label for="amenity-laundry" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-tshirt text-gray-400 mr-1"></i> Laundry
                                    </label>
                                </div>
                                 <div class="flex items-center">
                                    <input type="checkbox" id="amenity-study" name="amenities[]" value="9" class="mr-2">
                                    <label for="amenity-study" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-book text-gray-400 mr-1"></i> Study Room
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-parking" name="amenities[]" value="10" class="mr-2">
                                    <label for="amenity-parking" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-parking text-gray-400 mr-1"></i> Parking
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-security" name="amenities[]" value="11" class="mr-2">
                                    <label for="amenity-security" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-shield-alt text-gray-400 mr-1"></i> 24/7 Security
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="amenity-power" name="amenities[]" value="12" class="mr-2">
                                    <label for="amenity-power" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-bolt text-gray-400 mr-1"></i> Power Backup
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button id="reset-filters" class="border border-gray-300 bg-white text-gray-700 px-4 py-2 rounded-md text-sm mr-2">
                                Reset Filters
                            </button>
                            <button id="apply-filters" class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <input type="checkbox" id="select-all" class="mr-2"> <!-- Removed filter-input class -->
                            <label for="select-all" class="text-sm font-medium text-gray-700">Select All</label>
                            <span class="ml-2 text-sm text-gray-500" id="selected-count-display">(0 selected)</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <button id="bulk-activate" class="border border-green-500 bg-green-50 text-green-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-check-circle mr-1"></i>
                                Activate
                            </button>
                            <button id="bulk-deactivate" class="border border-yellow-500 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-pause-circle mr-1"></i>
                                Deactivate
                            </button>
                            <button id="bulk-delete" class="border border-red-500 bg-red-50 text-red-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-trash-alt mr-1"></i>
                                Delete
                            </button>
                            <button id="bulk-export" class="border border-blue-500 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-download mr-1"></i>
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Properties Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                        <span class="sr-only">Select</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Added
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="propertiesTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Property rows will be injected here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div id="paginationControls" class="flex items-center justify-between">
                    <!-- Pagination will be injected here by JavaScript -->
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 sm:w-96 mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Deletion</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete this property? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-delete" class="bg-white text-gray-700 px-4 py-2 rounded-md border text-sm">
                    Cancel
                </button>
                <button id="confirm-delete" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div id="bulk-delete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 sm:w-96 mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Bulk Deletion</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete <span id="bulk-delete-count">0</span> properties? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-bulk-delete" class="bg-white text-gray-700 px-4 py-2 rounded-md border text-sm">
                    Cancel
                </button>
                <button id="confirm-bulk-delete" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Advanced filters toggle
            document.getElementById('toggle-advanced-filters').addEventListener('click', function() {
                const advancedFilters = document.getElementById('advanced-filters');
                const icon = document.getElementById('advanced-filters-icon');
                const text = document.getElementById('advanced-filters-text');
                
                if (advancedFilters.classList.contains('hidden')) {
                    advancedFilters.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                    text.textContent = 'Hide Advanced Filters';
                } else {
                    advancedFilters.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                    text.textContent = 'Show Advanced Filters';
                }
            });
            
            // Price range slider (initial display update, event listener for change is set later)
            const priceRange = document.getElementById('price-range');
            const priceDisplay = document.getElementById('price-display');
             if(priceRange && priceDisplay){ // Ensure elements exist
                const initialPrice = parseInt(priceRange.value);
                if (initialPrice === parseInt(priceRange.max)) {
                    priceDisplay.textContent = '₹' + initialPrice.toLocaleString() + '+';
                } else {
                    priceDisplay.textContent = '₹' + initialPrice.toLocaleString();
                }
            }
            
            const propertiesTableBody = document.getElementById('propertiesTableBody');
            const paginationControls = document.getElementById('paginationControls');
            const selectedCountDisplay = document.getElementById('selected-count-display');
            const selectAllCheckbox = document.getElementById('select-all');
            
            const bulkActivateBtn = document.getElementById('bulk-activate');
            const bulkDeactivateBtn = document.getElementById('bulk-deactivate');
            const bulkDeleteBtn = document.getElementById('bulk-delete');
            const bulkExportBtn = document.getElementById('bulk-export');

            const deleteModal = document.getElementById('delete-modal');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            const bulkDeleteModal = document.getElementById('bulk-delete-modal');
            const cancelBulkDeleteBtn = document.getElementById('cancel-bulk-delete');
            const confirmBulkDeleteBtn = document.getElementById('confirm-bulk-delete');
            let propertyIdToDelete = null;

            let currentPage = 1; 
            let currentFilters = {}; 

            function displayAjaxMessage(type, message) {
                const successDiv = document.getElementById('ajax-success-message');
                const errorDiv = document.getElementById('ajax-error-message');
                const successText = document.getElementById('ajax-success-text');
                const errorText = document.getElementById('ajax-error-text');

                successDiv.classList.add('hidden');
                errorDiv.classList.add('hidden');

                if (type === 'success') {
                    successText.textContent = message;
                    successDiv.classList.remove('hidden');
                } else if (type === 'error') {
                    errorText.textContent = message;
                    errorDiv.classList.remove('hidden');
                }
                 setTimeout(() => { 
                    successDiv.classList.add('hidden');
                    errorDiv.classList.add('hidden');
                }, 5000);
            }
            
            // This is the core function to fetch and render data.
            // It will be wrapped later to include URL updates.
            async function _originalFetchProperties(page = 1, filters = {}) {
                const params = new URLSearchParams({ page });
                
                for (const key in filters) {
                    if (filters[key] !== undefined && filters[key] !== '') {
                        if (key === 'amenities' && Array.isArray(filters[key])) {
                            filters[key].forEach(value => params.append('amenities[]', value));
                        } else {
                             params.set(key, filters[key]);
                        }
                    }
                }
                
                try {
                    const response = await fetch(`handle_get_properties.php?${params.toString()}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    console.log('Fetched properties data:', data); 

                    renderTable(data.properties);
                    renderPagination(data.pagination);
                    updateSelectedCount(); 
                } catch (error) {
                    console.error('Error fetching properties:', error);
                    propertiesTableBody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-red-500">Failed to load properties: ${error.message}</td></tr>`;
                    displayAjaxMessage('error', 'Failed to load properties: ' + error.message);
                }
            }

            function renderTable(properties) {
                propertiesTableBody.innerHTML = ''; 
                if (!properties || properties.length === 0) {
                    propertiesTableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4">No properties found.</td></tr>';
                    return;
                }

                properties.forEach(property => {
                    const row = document.createElement('tr');
                    const imageUrl = property.main_image_path ? `../${property.main_image_path}` : 'https://via.placeholder.com/80x80?text=No+Image';
                    
                    let statusBadge;
                    let uiStatus = property.status; 
                    
                    // Mapping backend status to UI display terms if needed
                    if (property.status === 'available') uiStatus = 'Active';
                    else if (property.status === 'unavailable') uiStatus = 'Inactive';
                    // Add more mappings if your backend uses other terms for 'Pending', etc.
                    // Or if 'status' from backend already matches UI terms like 'Active', 'Pending', 'Inactive'.

                    switch (uiStatus) { 
                        case 'Active':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>';
                            break;
                        case 'Inactive':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>';
                            break;
                         case 'Pending': 
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>';
                            break;
                        default: 
                            statusBadge = `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">${uiStatus || 'N/A'}</span>`;
                    }

                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="property-select" data-id="${property.id}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                    <img src="${imageUrl}" alt="${property.name}" class="h-full w-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${property.name}</div>
                                    ${property.property_rating ? `<div class="flex items-center"><i class="fas fa-star text-yellow-400 text-xs mr-1"></i><span class="text-xs text-gray-500">${property.property_rating}</span></div>` : ''}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${property.property_type || 'N/A'}</div>
                            <div class="text-xs text-blue-600">${property.property_category || 'N/A'}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 truncate" style="max-width: 150px;" title="${property.address || ''}">${property.address || 'N/A'}</div>
                            <div class="text-xs text-gray-500">${property.landmark || ''}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">₹${Number(property.base_price || 0).toLocaleString()}/month</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${statusBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${new Date(property.created_at).toLocaleDateString()}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="edit-property.php?id=${property.id}" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="../view-details.php?id=${property.id}" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-red-600 hover:text-red-900 delete-property-btn" data-id="${property.id}" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    propertiesTableBody.appendChild(row);
                });
                attachRowEventListeners();
            }

            function renderPagination(pagination) {
                paginationControls.innerHTML = ''; 
                if (!pagination || pagination.total_pages <= 0) { 
                     paginationControls.innerHTML = `<p class="text-sm text-gray-700">Showing <span class="font-medium">${pagination.total_records || 0}</span> results</p>`;
                    return;
                }
                 if (pagination.total_pages === 1 && pagination.total_records > 0) { 
                    paginationControls.innerHTML = `<p class="text-sm text-gray-700">Showing <span class="font-medium">${pagination.total_records}</span> results</p>`;
                    return;
                }

                let html = `<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">${(pagination.current_page - 1) * pagination.limit + 1}</span> 
                                        to <span class="font-medium">${Math.min(pagination.current_page * pagination.limit, pagination.total_records)}</span> 
                                        of <span class="font-medium">${pagination.total_records}</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">`;
                
                html += `<button onclick="fetchPropertiesWrapper(${pagination.current_page - 1})" 
                                 class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 ${pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                                 ${pagination.current_page === 1 ? 'disabled' : ''}>
                            <span class="sr-only">Previous</span><i class="fas fa-chevron-left"></i>
                         </button>`;

                for (let i = 1; i <= pagination.total_pages; i++) {
                    if (i === pagination.current_page) {
                        html += `<button aria-current="page" class="z-10 bg-[#1a4977] border-[#1a4977] text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">${i}</button>`;
                    } else {
                        html += `<button onclick="fetchPropertiesWrapper(${i})" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">${i}</button>`;
                    }
                }

                html += `<button onclick="fetchPropertiesWrapper(${pagination.current_page + 1})"
                                 class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 ${pagination.current_page === pagination.total_pages ? 'opacity-50 cursor-not-allowed' : ''}"
                                 ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}>
                            <span class="sr-only">Next</span><i class="fas fa-chevron-right"></i>
                         </button>`;
                html += `</nav></div></div>`;
                paginationControls.innerHTML = html;
            }
            
            // --- Enhanced Filter Logic START ---
            function collectFilters() {
                const filters = {};
                const searchVal = document.getElementById('search').value.trim();
                if (searchVal) filters.search = searchVal;

                const typeVal = document.getElementById('property-type').value;
                if (typeVal) filters.type = typeVal;

                const statusVal = document.getElementById('status').value;
                if (statusVal) filters.status = statusVal;
                
                const priceRangeInput = document.getElementById('price-range');
                if (priceRangeInput && priceRangeInput.value !== priceRangeInput.max) { 
                    filters.price_max = priceRangeInput.value;
                }

                const categoryVal = document.getElementById('category').value;
                if (categoryVal) filters.category = categoryVal;
                
                const sortByValue = document.getElementById('sort-by').value;
                if (sortByValue) {
                    const parts = sortByValue.split('-'); 
                    let sort_by_col_ui = parts[0];
                    
                    if (sort_by_col_ui === 'latest') filters.sort_by = 'p.created_at';
                    else if (sort_by_col_ui === 'name') filters.sort_by = 'p.name';
                    else if (sort_by_col_ui === 'price') filters.sort_by = 'p.base_price';
                    else if (sort_by_col_ui === 'rating') filters.sort_by = 'p.property_rating'; 
                    else filters.sort_by = 'p.created_at'; 
                    
                    filters.sort_order = (parts[1] && ['ASC', 'DESC'].includes(parts[1].toUpperCase())) ? parts[1].toUpperCase() : 'DESC';
                     if (sort_by_col_ui === 'latest') filters.sort_order = 'DESC'; 
                } else { 
                    filters.sort_by = 'p.created_at'; 
                    filters.sort_order = 'DESC';
                }

                const selectedAmenities = [];
                document.querySelectorAll('#amenities-filter-container input[name="amenities[]"]:checked').forEach(cb => {
                    selectedAmenities.push(cb.value); 
                });
                if (selectedAmenities.length > 0) {
                    filters.amenities = selectedAmenities; 
                }
                return filters;
            }

            function setFilterStatesFromUrl() {
                const params = new URLSearchParams(window.location.search);
                currentPage = parseInt(params.get('page')) || 1;

                document.getElementById('search').value = params.get('search') || '';
                document.getElementById('property-type').value = params.get('type') || '';
                document.getElementById('status').value = params.get('status') || '';
                
                const priceRangeInput = document.getElementById('price-range');
                const priceDisplay = document.getElementById('price-display');
                const priceMaxFromUrl = params.get('price_max');

                if (priceRangeInput && priceDisplay) { // Ensure elements exist
                    if (priceMaxFromUrl) {
                        priceRangeInput.value = priceMaxFromUrl;
                        priceDisplay.textContent = '₹' + parseInt(priceMaxFromUrl).toLocaleString() + (parseInt(priceMaxFromUrl) === parseInt(priceRangeInput.max) ? '+' : '');
                    } else { 
                        priceRangeInput.value = priceRangeInput.max; 
                        priceDisplay.textContent = '₹' + parseInt(priceRangeInput.max).toLocaleString() + '+';
                    }
                }

                document.getElementById('category').value = params.get('category') || '';

                const sortByFromUrl = params.get('sort_by');
                const sortOrderFromUrl = params.get('sort_order');
                let finalSortByValue = 'latest'; 
                if (sortByFromUrl && sortOrderFromUrl) {
                    let sort_by_col_ui = '';
                    if (sortByFromUrl === 'p.created_at') sort_by_col_ui = 'latest';
                    else if (sortByFromUrl === 'p.name') sort_by_col_ui = 'name';
                    else if (sortByFromUrl === 'p.base_price') sort_by_col_ui = 'price';
                    else if (sortByFromUrl === 'p.property_rating') sort_by_col_ui = 'rating';
                    
                    if(sort_by_col_ui) {
                        finalSortByValue = (sort_by_col_ui === 'latest') ? 'latest' : `${sort_by_col_ui}-${sortOrderFromUrl.toLowerCase()}`;
                    }
                }
                document.getElementById('sort-by').value = finalSortByValue;

                const amenitiesFromUrl = params.getAll('amenities[]'); 
                document.querySelectorAll('#amenities-filter-container input[name="amenities[]"]').forEach(checkbox => {
                    checkbox.checked = amenitiesFromUrl.includes(checkbox.value);
                });
            }
            
            function updateUrlWithFilters(page, filters) {
                const params = new URLSearchParams();
                if (page > 1) { 
                    params.set('page', page);
                }

                for (const key in filters) {
                    if (filters[key] !== undefined && filters[key] !== '' && !(Array.isArray(filters[key]) && filters[key].length === 0) ) {
                        if (key === 'amenities' && Array.isArray(filters[key])) {
                            filters[key].forEach(value => params.append('amenities[]', value));
                        } else {
                            params.set(key, filters[key]);
                        }
                    }
                }
                const newQueryString = params.toString();
                const newUrl = `${window.location.pathname}${newQueryString ? '?' : ''}${newQueryString}`;
                
                const currentFullUrl = window.location.pathname + window.location.search;
                if (newUrl !== currentFullUrl) { 
                     history.pushState({path: newUrl}, '', newUrl);
                }
            }
            
            // Global fetchProperties variable that will wrap the original one
            let fetchProperties = _originalFetchProperties; // Initialize with the original

            // Wrap the original fetchProperties to include URL updating
            fetchProperties = async function(page = 1, filters = {}) { 
                let effectiveFilters = filters;
                // If filters is empty (e.g. from pagination click), use currentFilters
                if (Object.keys(filters).length === 0 && Object.keys(currentFilters).length > 0) {
                    effectiveFilters = currentFilters;
                } else {
                    currentFilters = filters; // Update global currentFilters if new filters are passed
                }
                
                await _originalFetchProperties(page, effectiveFilters); 
                updateUrlWithFilters(page, effectiveFilters); 
            }
            
            // Make the wrapped fetchProperties available for pagination clicks
            window.fetchPropertiesWrapper = async function(page) {
                await fetchProperties(page, currentFilters); // Uses the global currentFilters
            };
            // Update renderPagination to use fetchPropertiesWrapper
            // This change is applied directly in renderPagination's onclick attributes.


            // Event Listeners for filter inputs
            const filterTriggerElements = [
                document.getElementById('search'),
                document.getElementById('property-type'),
                document.getElementById('status'),
                document.getElementById('category'),
                document.getElementById('sort-by')
            ];
            document.querySelectorAll('#amenities-filter-container input[type="checkbox"]').forEach(el => filterTriggerElements.push(el));
            
            filterTriggerElements.forEach(input => {
                if(input) {
                    input.addEventListener('change', () => {
                         fetchProperties(1, collectFilters()); 
                    });
                }
            });
            
            const priceRangeInputElem = document.getElementById('price-range');
            if (priceRangeInputElem) {
                priceRangeInputElem.addEventListener('input', function() { 
                     const display = document.getElementById('price-display');
                     if (display) { 
                        if (parseInt(this.value) === parseInt(this.max)) {
                            display.textContent = '₹' + parseInt(this.value).toLocaleString() + '+';
                        } else {
                            display.textContent = '₹' + parseInt(this.value).toLocaleString();
                        }
                     }
                });
                priceRangeInputElem.addEventListener('change', () => { 
                    fetchProperties(1, collectFilters());
                });
            }

            // Apply Filters Button
            document.getElementById('apply-filters')?.addEventListener('click', () => {
                fetchProperties(1, collectFilters());
            }); 

            // Reset Filters Button
            document.getElementById('reset-filters').addEventListener('click', function() {
                document.getElementById('search').value = '';
                document.getElementById('property-type').value = '';
                document.getElementById('status').value = '';
                const priceRangeInputElem = document.getElementById('price-range');
                const priceDisplayElem = document.getElementById('price-display');
                if(priceRangeInputElem && priceDisplayElem) {
                    priceRangeInputElem.value = priceRangeInputElem.max; 
                    priceDisplayElem.textContent = '₹' + parseInt(priceRangeInputElem.max).toLocaleString() + '+';
                }
                document.getElementById('category').value = '';
                document.getElementById('sort-by').value = 'latest';
                document.querySelectorAll('#amenities-filter-container input[type="checkbox"]').forEach(cb => cb.checked = false);
                
                currentFilters = {}; 
                fetchProperties(1, {}); 
            });
            
            // --- End of Enhanced Filter Logic ---
            
            // Checkbox handling and bulk actions (initial setup)
            function updateSelectedCount() {
                const selectedCheckboxes = document.querySelectorAll('.property-select:checked');
                const count = selectedCheckboxes.length;
                if(selectedCountDisplay) selectedCountDisplay.textContent = `(${count} selected)`;

                const enableBulk = count > 0;
                [bulkActivateBtn, bulkDeactivateBtn, bulkDeleteBtn, bulkExportBtn].forEach(btn => {
                    if(btn) {
                        btn.disabled = !enableBulk;
                        if (enableBulk) btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        else btn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
                 if (document.getElementById('bulk-delete-count')) {
                    document.getElementById('bulk-delete-count').textContent = count;
                }
            }
            
            if(selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    document.querySelectorAll('.property-select').forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCount();
                });
            }


            function attachRowEventListeners() {
                document.querySelectorAll('.property-select').forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        if(selectAllCheckbox) {
                            const allCheckboxes = document.querySelectorAll('.property-select');
                            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                            const anyChecked = Array.from(allCheckboxes).some(cb => cb.checked);
                            selectAllCheckbox.checked = allChecked;
                            selectAllCheckbox.indeterminate = anyChecked && !allChecked;
                        }
                        updateSelectedCount();
                    });
                });

                document.querySelectorAll('.delete-property-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        propertyIdToDelete = this.dataset.id;
                        if(deleteModal) deleteModal.classList.remove('hidden');
                    });
                });
            }
            
            // Single Delete Action
            if(confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', async function() {
                    if (!propertyIdToDelete) return;
                    try {
                        const formData = new FormData();
                        formData.append('property_id', propertyIdToDelete);
                        const response = await fetch('handle_delete_property.php', { method: 'POST', body: formData });
                        const data = await response.json();
                        if (data.success) {
                            displayAjaxMessage('success', data.message || 'Property deleted successfully.');
                            fetchProperties(currentPage, currentFilters); 
                        } else {
                            displayAjaxMessage('error', data.message || 'Failed to delete property.');
                        }
                    } catch (error) {
                        displayAjaxMessage('error', 'Error deleting property: ' + error.message);
                    } finally {
                        if(deleteModal) deleteModal.classList.add('hidden');
                        propertyIdToDelete = null;
                    }
                });
            }
            if(cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => { if(deleteModal) deleteModal.classList.add('hidden'); });

            // Bulk Actions
            async function handleBulkAction(action) {
                const selectedIds = Array.from(document.querySelectorAll('.property-select:checked')).map(cb => cb.dataset.id);
                if (selectedIds.length === 0) {
                    displayAjaxMessage('error', 'No properties selected.');
                    return;
                }

                const formData = new FormData();
                formData.append('action', action);
                selectedIds.forEach(id => formData.append('property_ids[]', id));

                try {
                    const response = await fetch('handle_bulk_actions.php', { method: 'POST', body: formData });
                    const data = await response.json();
                    if (data.success) {
                        displayAjaxMessage('success', data.message || `Bulk ${action} successful.`);
                        fetchProperties(currentPage, currentFilters); 
                    } else {
                        displayAjaxMessage('error', data.message || `Failed to perform bulk ${action}.`);
                    }
                } catch (error) {
                    displayAjaxMessage('error', `Error performing bulk ${action}: ` + error.message);
                } finally {
                    if (action === 'delete' && bulkDeleteModal) bulkDeleteModal.classList.add('hidden');
                    if(selectAllCheckbox) selectAllCheckbox.checked = false; 
                    updateSelectedCount();
                }
            }

            if(bulkActivateBtn) bulkActivateBtn.addEventListener('click', () => handleBulkAction('activate'));
            if(bulkDeactivateBtn) bulkDeactivateBtn.addEventListener('click', () => handleBulkAction('deactivate'));
            if(bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    if (Array.from(document.querySelectorAll('.property-select:checked')).length > 0) {
                       if(bulkDeleteModal) bulkDeleteModal.classList.remove('hidden');
                    } else {
                        displayAjaxMessage('error', 'No properties selected for deletion.');
                    }
                });
            }
            if(confirmBulkDeleteBtn) confirmBulkDeleteBtn.addEventListener('click', () => handleBulkAction('delete'));
            if(cancelBulkDeleteBtn) cancelBulkDeleteBtn.addEventListener('click', () => {if(bulkDeleteModal) bulkDeleteModal.classList.add('hidden');});
            
            // Initial fetch logic:
            setFilterStatesFromUrl(); 
            currentFilters = collectFilters(); 
            fetchProperties(currentPage, currentFilters); 

        });
    </script>
</body>
</html>