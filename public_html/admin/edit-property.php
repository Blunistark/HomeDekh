<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details Management | HomeDhek Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
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
                <button class="text-gray-500 focus:outline-none focus:text-gray-700">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="relative">
                    <button class="flex items-center text-gray-700 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white">
                            A
                        </div>
                        <span class="ml-2 text-sm font-medium hidden md:block">Admin User</span>
                        <i class="fas fa-chevron-down ml-2 text-xs hidden md:block"></i>
                    </button>
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
                        <a href="admin-properties.html" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-[#1a4977] text-white">
                            <i class="fas fa-building mr-3"></i>
                            Properties
                        </a>
                        <a href="admin-users.html" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-users mr-3 text-gray-500"></i>
                            Users
                        </a>
                        <a href="admin-settings.html" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 lg:ml-64 ml-0">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="./" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <a href="admin-properties.html" class="text-gray-500 hover:text-gray-700">Properties</a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-medium">Edit Property</span>
                </div>

                <!-- Page Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Property: Sunshine PG for Girls</h1>
                    <div class="flex space-x-3">
                        <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md flex items-center text-sm" onclick="window.open('view-details.php?id=1', '_blank')">
                            <i class="fas fa-eye mr-2"></i>
                            Preview
                        </button>
                        <button id="save-property-btn" class="bg-[#1a4977] text-white px-4 py-2 rounded-md flex items-center text-sm">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </div>

                <!-- Property Status -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mr-3">
                            Active
                        </span>
                        <span class="text-sm text-gray-500">Last updated: May 15, 2025</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <select class="border rounded-md text-sm px-3 py-1.5">
                            <option value="active" selected>Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">
                            <i class="fas fa-trash-alt mr-1"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px space-x-8" id="tabs">
                        <button class="tab-btn border-b-2 border-[#1a4977] py-4 px-1 text-sm font-medium text-[#1a4977]" data-tab="basic-info">
                            Basic Info
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="images">
                            Images
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="description">
                            Description
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="rooms-pricing">
                            Rooms & Pricing
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="amenities">
                            Amenities
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="location">
                            Location
                        </button>
                        <button class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="contact">
                            Contact
                        </button>
                    </nav>
                </div>

                <!-- Basic Info Tab -->
                <div id="basic-info-tab" class="tab-content active">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="property-name" class="block text-sm font-medium text-gray-700 mb-1">Property Name*</label>
                                <input type="text" id="property-name" class="w-full border rounded-lg px-3 py-2" value="Sunshine PG for Girls">
                            </div>
                            
                            <div>
                                <label for="property-type" class="block text-sm font-medium text-gray-700 mb-1">Property Type*</label>
                                <select id="property-type" class="w-full border rounded-lg px-3 py-2">
                                    <option value="pg" selected>PG</option>
                                    <option value="hostel">Hostel</option>
                                    <option value="apartment">Apartment</option>
                                </select>
                            </div>

                            <div>
                                <label for="property-category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                                <select id="property-category" class="w-full border rounded-lg px-3 py-2">
                                    <option value="girls" selected>Girls Only</option>
                                    <option value="boys">Boys Only</option>
                                    <option value="coed">Co-ed</option>
                                </select>
                            </div>

                            <div>
                                <label for="property-rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                <div class="flex items-center">
                                    <input type="number" id="property-rating" class="w-24 border rounded-lg px-3 py-2" value="4.8" min="0" max="5" step="0.1">
                                    <div class="flex ml-3">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="property-reviewcount" class="block text-sm font-medium text-gray-700 mb-1">Review Count</label>
                                <input type="number" id="property-reviewcount" class="w-full border rounded-lg px-3 py-2" value="124">
                            </div>

                            <div>
                                <label for="property-price" class="block text-sm font-medium text-gray-700 mb-1">Base Price (₹/month)*</label>
                                <input type="number" id="property-price" class="w-full border rounded-lg px-3 py-2" value="12000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Tab -->
                <div id="images-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Property Images</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Main Image*</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                <div class="relative inline-block">
                                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Main image" class="h-60 w-full object-cover rounded-lg">
                                    <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="mt-4">
                                    <input type="file" id="main-image-upload" class="hidden" accept="image/*">
                                    <label for="main-image-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-upload mr-2"></i>
                                        Change Main Image
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gallery Images</label>
                            <p class="text-xs text-gray-500 mb-3">Add up to 8 additional images. First 4 images will be shown in the main gallery.</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <!-- Gallery Image 1 -->
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Gallery image" class="h-40 w-full object-cover rounded-lg">
                                    <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Gallery Image 2 -->
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Gallery image" class="h-40 w-full object-cover rounded-lg">
                                    <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Gallery Image 3 -->
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1560185127-6ed189bf02f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Gallery image" class="h-40 w-full object-cover rounded-lg">
                                    <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Gallery Image 4 -->
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Gallery image" class="h-40 w-full object-cover rounded-lg">
                                    <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Add Image Placeholder -->
                                <div class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center h-40">
                                    <input type="file" id="gallery-image-upload" class="hidden" accept="image/*">
                                    <label for="gallery-image-upload" class="cursor-pointer text-center">
                                        <i class="fas fa-plus text-gray-400 text-2xl mb-2"></i>
                                        <p class="text-sm text-gray-500">Add Image</p>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <input type="file" id="multiple-images-upload" class="hidden" multiple accept="image/*">
                                <label for="multiple-images-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Multiple Images
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Tab -->
                <div id="description-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Property Description</h2>
                        
                        <div class="mb-6">
                            <label for="short-description" class="block text-sm font-medium text-gray-700 mb-1">Short Description (Paragraph 1)</label>
                            <textarea id="short-description" rows="3" class="w-full border rounded-lg px-3 py-2">Sunshine PG for Girls is a premium paying guest accommodation located just 500 meters from Stanford University. We offer comfortable, safe, and affordable living spaces for female students with all modern amenities and a homely atmosphere.</textarea>
                        </div>
                        
                        <div class="mb-6">
                            <label for="long-description" class="block text-sm font-medium text-gray-700 mb-1">Detailed Description (Paragraph 2)</label>
                            <textarea id="long-description" rows="5" class="w-full border rounded-lg px-3 py-2">Our PG accommodation features spacious rooms with comfortable beds, study tables, and ample storage space. We provide high-speed WiFi, regular housekeeping, and 24/7 security to ensure a comfortable and safe living environment. The common areas include a fully equipped kitchen, dining area, and a cozy lounge for relaxation and socializing. We also offer laundry facilities and a dedicated study room for our residents.</textarea>
                        </div>
                        
                        <div>
                            <label for="meta-description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description (for SEO)</label>
                            <textarea id="meta-description" rows="2" class="w-full border rounded-lg px-3 py-2">Premium PG accommodation for female students near Stanford University with WiFi, security, meals, and all essential amenities at competitive rates.</textarea>
                            <p class="text-xs text-gray-500 mt-1">This description will be used for SEO purposes. Keep it under 160 characters.</p>
                        </div>
                    </div>
                </div>

                <!-- Rooms & Pricing Tab -->
                <div id="rooms-pricing-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Rooms & Pricing</h2>
                            <button class="bg-[#1a4977] text-white px-3 py-1.5 rounded text-sm flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Add Room Type
                            </button>
                        </div>
                        
                        <!-- Room Types Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (per month)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Beds</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Single Sharing Row -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                                <input type="text" value="Single Sharing" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-32">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-1">₹</span>
                                                <input type="number" value="8000" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-20">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" value="3" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-16 text-green-600">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Double Sharing Row -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-users text-gray-400 mr-2"></i>
                                                <input type="text" value="Double Sharing" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-32">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-1">₹</span>
                                                <input type="number" value="6000" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-20">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" value="5" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-16 text-green-600">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Triple Sharing Row -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-users text-gray-400 mr-2"></i>
                                                <input type="text" value="Triple Sharing" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-32">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-1">₹</span>
                                                <input type="number" value="4500" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-20">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" value="2" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-16 text-green-600">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Special Offer Section -->
                        <div class="mt-8">
                            <h3 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                Special Offer
                            </h3>
                            
                            <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-lg">
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" id="has-special-offer" class="mr-2" checked>
                                    <label for="has-special-offer" class="text-sm font-medium">Enable Special Offer</label>
                                </div>
                                
                                <div>
                                    <label for="special-offer-text" class="block text-sm font-medium text-gray-700 mb-1">Offer Text</label>
                                    <textarea id="special-offer-text" rows="2" class="w-full border rounded-lg px-3 py-2">Book now and get 10% off on your first month's rent</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amenities Tab -->
                <div id="amenities-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Amenities & Services</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Main Amenities</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                <!-- WiFi -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="wifi" checked>
                                    <label for="wifi" class="flex items-center">
                                        <i class="fas fa-wifi text-[#1a4977] mr-2"></i>
                                        <span>WiFi</span>
                                    </label>
                                </div>
                                
                                <!-- Food -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="food" checked>
                                    <label for="food" class="flex items-center">
                                        <i class="fas fa-utensils text-[#1a4977] mr-2"></i>
                                        <span>Food</span>
                                    </label>
                                </div>
                                
                                <!-- TV -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="tv" checked>
                                    <label for="tv" class="flex items-center">
                                        <i class="fas fa-tv text-[#1a4977] mr-2"></i>
                                        <span>TV</span>
                                    </label>
                                </div>
                                
                                <!-- Attached Bathroom -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="bathroom" checked>
                                    <label for="bathroom" class="flex items-center">
                                        <i class="fas fa-bath text-[#1a4977] mr-2"></i>
                                        <span>Attached Bathroom</span>
                                    </label>
                                </div>
                                
                                <!-- Refrigerator -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="refrigerator" checked>
                                    <label for="refrigerator" class="flex items-center">
                                        <i class="fas fa-snowflake text-[#1a4977] mr-2"></i>
                                        <span>Refrigerator</span>
                                    </label>
                                </div>
                                
                                <!-- AC -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="ac">
                                    <label for="ac" class="flex items-center">
                                        <i class="fas fa-wind text-[#1a4977] mr-2"></i>
                                        <span>AC</span>
                                    </label>
                                </div>
                                
                                <!-- Gym -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="gym">
                                    <label for="gym" class="flex items-center">
                                        <i class="fas fa-dumbbell text-[#1a4977] mr-2"></i>
                                        <span>Gym</span>
                                    </label>
                                </div>
                                
                                <!-- Laundry -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="laundry">
                                    <label for="laundry" class="flex items-center">
                                        <i class="fas fa-tshirt text-[#1a4977] mr-2"></i>
                                        <span>Laundry</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Additional Services</label>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="housekeeping" class="mr-2" checked>
                                    <div class="flex-grow">
                                        <div class="flex items-center">
                                            <input type="text" value="Daily housekeeping" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full">
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="security" class="mr-2" checked>
                                    <div class="flex-grow">
                                        <div class="flex items-center">
                                            <input type="text" value="24/7 security" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full">
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="laundry-service" class="mr-2" checked>
                                    <div class="flex-grow">
                                        <div class="flex items-center">
                                            <input type="text" value="Laundry services (additional charges may apply)" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full">
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="study-area" class="mr-2" checked>
                                    <div class="flex-grow">
                                        <div class="flex items-center">
                                            <input type="text" value="Common study area" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full">
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button class="mt-4 text-[#1a4977] text-sm flex items-center">
                                <i class="fas fa-plus mr-1"></i>
                                Add Service
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Location Tab -->
                <div id="location-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Location Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address*</label>
                                <textarea id="address" rows="3" class="w-full border rounded-lg px-3 py-2">122 College Avenue, Stanford, CA 94305</textarea>
                            </div>
                            
                            <div>
                                <label for="landmark" class="block text-sm font-medium text-gray-700 mb-1">Landmark/Nearby*</label>
                                <input type="text" id="landmark" class="w-full border rounded-lg px-3 py-2 mb-3" value="Stanford University">
                                
                                <label for="distance" class="block text-sm font-medium text-gray-700 mb-1">Distance from Landmark*</label>
                                <div class="flex">
                                    <input type="text" id="distance" class="w-24 border rounded-l-lg px-3 py-2" value="0.5">
                                    <span class="bg-gray-100 border-t border-r border-b rounded-r-lg px-3 py-2 text-gray-500">km</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Map Location</label>
                            <div class="bg-gray-200 h-64 rounded-lg relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <p class="text-gray-500">Map placeholder - Integration with Google Maps API</p>
                                </div>
                                <div class="absolute bottom-4 right-4 space-y-2">
                                    <button class="bg-white text-gray-700 px-3 py-1.5 rounded shadow-sm text-sm">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                        Set Location
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-md font-semibold text-gray-900 mb-3">Nearby Places</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Nearby Place 1 -->
                                <div class="flex items-center border rounded-lg p-3">
                                    <div class="flex-grow">
                                        <input type="text" placeholder="Place Name" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full text-gray-900 font-medium" value="Stanford University">
                                        <div class="flex items-center mt-1">
                                            <input type="text" placeholder="Distance" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-12 text-sm text-gray-600" value="0.5">
                                            <span class="text-sm text-gray-600 mx-1">km</span>
                                            <span class="text-sm text-gray-500">(</span>
                                            <input type="text" placeholder="Minutes" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-6 text-sm text-gray-600" value="7">
                                            <span class="text-sm text-gray-600 ml-1">min walk)</span>
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Nearby Place 2 -->
                                <div class="flex items-center border rounded-lg p-3">
                                    <div class="flex-grow">
                                        <input type="text" placeholder="Place Name" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full text-gray-900 font-medium" value="University Library">
                                        <div class="flex items-center mt-1">
                                            <input type="text" placeholder="Distance" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-12 text-sm text-gray-600" value="0.8">
                                            <span class="text-sm text-gray-600 mx-1">km</span>
                                            <span class="text-sm text-gray-500">(</span>
                                            <input type="text" placeholder="Minutes" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-6 text-sm text-gray-600" value="10">
                                            <span class="text-sm text-gray-600 ml-1">min walk)</span>
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Nearby Place 3 -->
                                <div class="flex items-center border rounded-lg p-3">
                                    <div class="flex-grow">
                                        <input type="text" placeholder="Place Name" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full text-gray-900 font-medium" value="Shopping Center">
                                        <div class="flex items-center mt-1">
                                            <input type="text" placeholder="Distance" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-12 text-sm text-gray-600" value="1.2">
                                            <span class="text-sm text-gray-600 mx-1">km</span>
                                            <span class="text-sm text-gray-500">(</span>
                                            <input type="text" placeholder="Minutes" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-6 text-sm text-gray-600" value="15">
                                            <span class="text-sm text-gray-600 ml-1">min walk)</span>
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Nearby Place 4 -->
                                <div class="flex items-center border rounded-lg p-3">
                                    <div class="flex-grow">
                                        <input type="text" placeholder="Place Name" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-full text-gray-900 font-medium" value="Bus Station">
                                        <div class="flex items-center mt-1">
                                            <input type="text" placeholder="Distance" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-12 text-sm text-gray-600" value="0.3">
                                            <span class="text-sm text-gray-600 mx-1">km</span>
                                            <span class="text-sm text-gray-500">(</span>
                                            <input type="text" placeholder="Minutes" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 w-6 text-sm text-gray-600" value="5">
                                            <span class="text-sm text-gray-600 ml-1">min walk)</span>
                                        </div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-900 ml-2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button class="text-[#1a4977] text-sm flex items-center">
                                <i class="fas fa-plus mr-1"></i>
                                Add Nearby Place
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Contact Tab -->
                <div id="contact-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                        
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="h-16 w-16 rounded-full overflow-hidden mr-4 relative">
                                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Contact person" class="h-full w-full object-cover">
                                    <label for="contact-image-upload" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center cursor-pointer opacity-0 hover:opacity-100 transition-opacity">
                                        <i class="fas fa-camera text-white"></i>
                                    </label>
                                    <input type="file" id="contact-image-upload" class="hidden" accept="image/*">
                                </div>
                                
                                <div>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Contact Name" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 text-gray-900 font-medium" value="Mrs. Jennifer Smith">
                                    </div>
                                    <div>
                                        <input type="text" placeholder="Title/Role" class="border-b border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-gray-500 px-0 py-1 text-sm text-gray-600" value="Property Owner">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                                    <input type="tel" id="contact-phone" class="w-full border rounded-lg px-3 py-2" value="+91 9876543210">
                                </div>
                                
                                <div>
                                    <label for="contact-whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                                    <input type="tel" id="contact-whatsapp" class="w-full border rounded-lg px-3 py-2" value="+91 9876543210">
                                    <div class="flex items-center mt-1">
                                        <input type="checkbox" id="same-as-phone" class="mr-2" checked>
                                        <label for="same-as-phone" class="text-xs text-gray-500">Same as phone number</label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="contact-email" class="w-full border rounded-lg px-3 py-2" value="jennifer.smith@example.com">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-md font-semibold text-gray-900 mb-3">WhatsApp Integration</h3>
                            
                            <div class="p-4 bg-green-50 border border-green-100 rounded-lg">
                                <label for="whatsapp-message" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Template Message</label>
                                <textarea id="whatsapp-message" rows="3" class="w-full border rounded-lg px-3 py-2 mb-3">Hi, I'm interested in Sunshine PG for Girls at 122 College Avenue, Stanford, CA 94305. Please provide more information.</textarea>
                                
                                <p class="text-xs text-gray-600 mb-3">You can use the following placeholders in your message:</p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">{property_name}</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">{property_address}</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">{property_price}</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">{property_type}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="include-mention" class="mr-2" checked>
                                    <label for="include-mention" class="text-sm text-gray-700">Include "Mention that you found this on HomeDhek" text</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Changes Button (Floating) -->
                <div class="fixed bottom-6 right-6">
                    <button class="bg-[#1a4977] text-white px-4 py-3 rounded-full shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Tab navigation
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    // Show selected tab content
                    document.getElementById(`${tabName}-tab`).classList.add('active');
                    
                    // Update active tab button
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-[#1a4977]', 'text-[#1a4977]');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.classList.add('border-[#1a4977]', 'text-[#1a4977]');
                });
            });
            
            // Same as phone checkbox for WhatsApp number
            document.getElementById('same-as-phone').addEventListener('change', function() {
                const phoneNumber = document.getElementById('contact-phone').value;
                const whatsappInput = document.getElementById('contact-whatsapp');
                
                if (this.checked) {
                    whatsappInput.value = phoneNumber;
                    whatsappInput.disabled = true;
                } else {
                    whatsappInput.disabled = false;
                }
            });
            
            // Phone number change syncs with WhatsApp if checkbox checked
            document.getElementById('contact-phone').addEventListener('input', function() {
                const sameAsPhone = document.getElementById('same-as-phone');
                const whatsappInput = document.getElementById('contact-whatsapp');
                
                if (sameAsPhone.checked) {
                    whatsappInput.value = this.value;
                }
            });
            
            // Save property changes
            document.getElementById('save-property-btn').addEventListener('click', function() {
                alert('Property changes saved successfully!');
            });
            
            // File uploads
            document.getElementById('main-image-upload').addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const mainImage = document.querySelector('.tab-content.active img');
                        mainImage.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
            
            document.getElementById('gallery-image-upload').addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    // Implementation would add new image to gallery
                    alert('Gallery image uploaded!');
                }
            });
            
            document.getElementById('multiple-images-upload').addEventListener('change', function(e) {
                if (e.target.files && e.target.files.length > 0) {
                    // Implementation would add multiple images to gallery
                    alert(`${e.target.files.length} images uploaded!`);
                }
            });
            
            document.getElementById('contact-image-upload').addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const contactImage = document.querySelector('.h-16.w-16.rounded-full img');
                        contactImage.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>
</body>
</html>