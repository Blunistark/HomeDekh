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

<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<?php include '../auth/session_check.php'; // Ensure user is logged in and is admin/owner ?>
<?php include '../config/db.php'; // Include db.php for any direct DB needs, though most data comes via AJAX ?>
<?php
$property_id_get = null; // Use a different variable name to avoid conflict with JS
if (isset($_GET['id'])) {
    $property_id_get = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($property_id_get === false || $property_id_get <= 0) {
        $_SESSION['error_message'] = "Invalid Property ID provided.";
        header("Location: properties.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No Property ID specified for editing.";
    header("Location: properties.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property | HomeDhek Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .gallery-image-item img { width: 100%; height: 10rem; object-fit: cover; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex justify-between items-center h-16 px-4">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden"><i class="fas fa-bars text-xl"></i></button>
                <div class="ml-4 lg:ml-0"><span class="text-[#1a4977] font-bold text-xl">HomeDhek Admin</span></div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 focus:outline-none focus:text-gray-700"><i class="fas fa-bell"></i></button>
                <div class="relative">
                    <button class="flex items-center text-gray-700 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)); ?></div>
                        <span class="ml-2 text-sm font-medium hidden md:block"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin User'); ?></span>
                        <i class="fas fa-chevron-down ml-2 text-xs hidden md:block"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <aside id="sidebar" class="fixed inset-y-0 left-0 bg-white shadow-md w-64 pt-16 transform transition-transform duration-300 lg:translate-x-0 z-10 -translate-x-full">
            <div class="overflow-y-auto h-full"><nav class="mt-5 px-2"><!-- Sidebar links --></nav></div>
        </aside>

        <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 lg:ml-64 ml-0">
            <form id="editPropertyForm" enctype="multipart/form-data">
            <input type="hidden" name="property_id" id="property_id_hidden" value="<?php echo htmlspecialchars($property_id_get); ?>">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Session & AJAX Messages -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong> <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <div id="ajax-error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong> <span class="block sm:inline" id="ajax-error-text"></span>
                </div>
                <div id="ajax-success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong> <span class="block sm:inline" id="ajax-success-text"></span>
                </div>

                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="./" class="text-gray-500 hover:text-gray-700">Dashboard</a><i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <a href="properties.php" class="text-gray-500 hover:text-gray-700">Properties</a><i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-medium">Edit Property</span>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <h1 id="page-title" class="text-2xl font-bold text-gray-900">Edit Property</h1>
                     <button type="button" id="preview-property-btn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md flex items-center text-sm">
                        <i class="fas fa-eye mr-2"></i>Preview
                    </button>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <span id="current-status-display" class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 mr-3">Loading...</span>
                        <span id="current-status-text" class="text-sm text-gray-500">Loading status...</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <select id="property-status" name="property-status" class="border rounded-md text-sm px-3 py-1.5">
                            <option value="draft">Draft</option><option value="pending">Pending Review</option>
                            <option value="active">Active (Publish)</option><option value="inactive">Inactive (Unpublish)</option>
                        </select>
                    </div>
                </div>

                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px space-x-8" id="tabs">
                        <button type="button" class="tab-btn active-tab" data-tab="basic-info">Basic Info</button>
                        <button type="button" class="tab-btn" data-tab="images">Images</button>
                        <button type="button" class="tab-btn" data-tab="description">Description</button>
                        <button type="button" class="tab-btn" data-tab="rooms-pricing">Rooms & Pricing</button>
                        <button type="button" class="tab-btn" data-tab="amenities">Amenities</button>
                        <button type="button" class="tab-btn" data-tab="location">Location</button>
                        <button type="button" class="tab-btn" data-tab="contact">Contact</button>
                    </nav>
                </div>

                <!-- Basic Info Tab -->
                <div id="basic-info-tab" class="tab-content active">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label for="property-name" class="block text-sm font-medium text-gray-700 mb-1">Property Name*</label><input type="text" id="property-name" name="property-name" class="w-full border rounded-lg px-3 py-2" required></div>
                            <div><label for="property-type" class="block text-sm font-medium text-gray-700 mb-1">Property Type*</label><select id="property-type" name="property-type" class="w-full border rounded-lg px-3 py-2" required><option value="">Select</option><option value="pg">PG</option><option value="hostel">Hostel</option><option value="apartment">Apartment</option></select></div>
                            <div><label for="property-category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label><select id="property-category" name="property-category" class="w-full border rounded-lg px-3 py-2" required><option value="">Select</option><option value="girls">Girls</option><option value="boys">Boys</option><option value="coed">Co-ed</option></select></div>
                            <div><label for="property-rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label><input type="number" id="property-rating" name="property-rating" class="w-24 border rounded-lg px-3 py-2" min="0" max="5" step="0.1"></div>
                            <div><label for="property-reviewcount" class="block text-sm font-medium text-gray-700 mb-1">Review Count</label><input type="number" id="property-reviewcount" name="property-reviewcount" class="w-full border rounded-lg px-3 py-2"></div>
                            <div><label for="property-price" class="block text-sm font-medium text-gray-700 mb-1">Base Price (₹/month)*</label><input type="number" id="property-price" name="property-price" class="w-full border rounded-lg px-3 py-2" required></div>
                        </div>
                    </div>
                </div>
                <!-- Images Tab -->
                <div id="images-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Property Images</h2>
                    <div class="mb-6"><label class="block text-sm font-medium text-gray-700 mb-1">Main Image*</label><div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <div id="main-image-preview" class="hidden mb-4"><div class="relative inline-block"><img id="main-image-preview-img" src="" class="h-60 w-full object-cover rounded-lg"><button type="button" id="remove-main-image" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1"><i class="fas fa-trash-alt"></i></button></div></div>
                        <div id="main-image-upload-btn"><input type="file" id="main-image-upload" name="main-image-upload" class="hidden" accept="image/*"><label for="main-image-upload" class="cursor-pointer"><div class="flex flex-col items-center"><i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i><p class="text-sm">Click to browse for new main image</p></div></label></div>
                    </div><input type="hidden" name="existing_main_image" id="existing_main_image_path"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Gallery Images</label><div id="gallery-images-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div id="gallery-upload-placeholder" class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center h-40"><input type="file" id="gallery-image-trigger" class="hidden" accept="image/*" multiple><label for="gallery-image-trigger" class="cursor-pointer text-center"><i class="fas fa-plus text-gray-400 text-2xl mb-2"></i><p class="text-sm">Add New Images</p></label></div>
                    </div></div>
                </div></div>
                <!-- Description Tab -->
                <div id="description-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Property Description</h2>
                    <div><label for="short-description" class="block text-sm font-medium text-gray-700 mb-1">Short Description*</label><textarea id="short-description" name="short-description" rows="3" class="w-full border rounded-lg px-3 py-2" required></textarea></div>
                    <div class="mt-4"><label for="long-description" class="block text-sm font-medium text-gray-700 mb-1">Detailed Description*</label><textarea id="long-description" name="long-description" rows="5" class="w-full border rounded-lg px-3 py-2" required></textarea></div>
                    <div class="mt-4"><label for="meta-description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label><textarea id="meta-description" name="meta-description" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea></div>
                </div></div>
                <!-- Rooms & Pricing Tab -->
                <div id="rooms-pricing-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4"><h2 class="text-lg font-semibold">Rooms & Pricing</h2><button type="button" id="add-room-type-btn" class="bg-[#1a4977] text-white px-3 py-1.5 rounded text-sm"><i class="fas fa-plus mr-2"></i>Add Room Type</button></div>
                    <div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Room Type</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Price</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Capacity</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Description</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th></tr></thead><tbody id="room-types-container"></tbody></table></div>
                    <div class="mt-8"><h3 class="text-md font-semibold mb-3"><i class="fas fa-tag text-yellow-500 mr-2"></i>Special Offer</h3><div class="p-4 bg-yellow-50 border rounded-lg"><div class="flex items-center mb-3"><input type="checkbox" id="has-special-offer" name="has-special-offer" class="mr-2"><label for="has-special-offer">Enable Offer</label></div><div id="special-offer-content" class="hidden"><label for="special-offer-text">Offer Text</label><textarea id="special-offer-text" name="special-offer-text" rows="2" class="w-full border rounded-lg"></textarea></div></div></div>
                </div></div>
                <!-- Amenities Tab -->
                <div id="amenities-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Amenities & Services</h2>
                    <div class="mb-6"><label class="block text-sm font-medium mb-3">Main Amenities</label><div id="amenities-checkbox-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php $amenities_list = [['id' => 1, 'name' => 'WiFi', 'icon' => 'fa-wifi'],['id' => 2, 'name' => 'Food', 'icon' => 'fa-utensils'],['id' => 3, 'name' => 'TV', 'icon' => 'fa-tv'],['id' => 4, 'name' => 'Attached Bathroom', 'icon' => 'fa-bath'],['id' => 5, 'name' => 'Refrigerator', 'icon' => 'fa-snowflake'],['id' => 6, 'name' => 'AC', 'icon' => 'fa-wind'],['id' => 7, 'name' => 'Gym', 'icon' => 'fa-dumbbell'],['id' => 8, 'name' => 'Laundry', 'icon' => 'fa-tshirt'],['id' => 9, 'name' => 'Study Room', 'icon' => 'fa-book'],['id' => 10, 'name' => 'Parking', 'icon' => 'fa-parking'],['id' => 11, 'name' => '24/7 Security', 'icon' => 'fa-shield-alt'],['id' => 12, 'name' => 'Power Backup', 'icon' => 'fa-bolt']];
                        foreach ($amenities_list as $amenity): ?>
                        <div class="flex items-center space-x-2"><input type="checkbox" id="amenity-<?php echo $amenity['id']; ?>" name="amenities[]" value="<?php echo $amenity['id']; ?>"><label for="amenity-<?php echo $amenity['id']; ?>" class="flex items-center"><i class="fas <?php echo $amenity['icon']; ?> text-[#1a4977] mr-2"></i><span><?php echo $amenity['name']; ?></span></label></div>
                        <?php endforeach; ?>
                    </div></div>
                    <div><label class="block text-sm font-medium mb-3">Additional Services</label><div id="additional-services-container" class="space-y-3"></div><button type="button" id="add-service-btn" class="mt-4 text-[#1a4977] text-sm"><i class="fas fa-plus mr-1"></i>Add Service</button></div>
                </div></div>
                <!-- Location Tab -->
                <div id="location-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Location Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div><label for="address">Full Address*</label><textarea id="address" name="address" rows="3" class="w-full border rounded-lg" required></textarea></div>
                        <div><label for="landmark">Landmark*</label><input type="text" id="landmark" name="landmark" class="w-full border rounded-lg mb-3" required><label for="distance">Distance from Landmark*</label><div class="flex"><input type="text" id="distance" name="distance" class="w-24 border rounded-l-lg" required><span class="bg-gray-100 border-t border-r border-b rounded-r-lg px-3 py-2">km</span></div></div>
                    </div>
                    <div class="mb-6"><label>Map Location (Coordinates)</label><div class="grid grid-cols-1 md:grid-cols-2 gap-6"><div><label for="map_latitude">Latitude</label><input type="text" id="map_latitude" name="map_latitude" class="w-full border rounded-lg"></div><div><label for="map_longitude">Longitude</label><input type="text" id="map_longitude" name="map_longitude" class="w-full border rounded-lg"></div></div><div class="mt-2 bg-gray-200 h-64 rounded-lg flex items-center justify-center"><p>Map placeholder</p></div></div>
                    <div><h3 class="text-md font-semibold mb-3">Nearby Places</h3><div id="nearby-places-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"></div><button type="button" id="add-nearby-place-btn" class="text-[#1a4977] text-sm"><i class="fas fa-plus mr-1"></i>Add Nearby Place</button></div>
                </div></div>
                <!-- Contact Tab -->
                <div id="contact-tab" class="tab-content"><div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Contact Information</h2>
                    <div class="mb-6"><div class="flex items-center mb-4"><div class="h-16 w-16 rounded-full overflow-hidden mr-4 relative"><img id="contact-image-preview" src="https://via.placeholder.com/150?text=Upload" class="h-full w-full object-cover"><label for="contact-image-upload" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center cursor-pointer opacity-0 hover:opacity-100"><i class="fas fa-camera text-white"></i></label><input type="file" id="contact-image-upload" name="contact-image-upload" class="hidden" accept="image/*"></div> <input type="hidden" name="existing_contact_image" id="existing_contact_image_path"><div><div><input type="text" id="contact-name" name="contact-name" placeholder="Contact Name" class="border-b border-dashed"></div><div><input type="text" id="contact-title" name="contact-title" placeholder="Title/Role" class="border-b border-dashed text-sm"></div></div></div><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label for="contact-phone">Phone*</label><input type="tel" id="contact-phone" name="contact-phone" class="w-full border rounded-lg" required></div><div><label for="contact-whatsapp">WhatsApp</label><input type="tel" id="contact-whatsapp" name="contact-whatsapp" class="w-full border rounded-lg"></div><div><label for="contact-email">Email</label><input type="email" id="contact-email" name="contact-email" class="w-full border rounded-lg"></div></div></div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="tab-btn-prev border px-4 py-2 rounded-md" data-prev="location"><i class="fas fa-arrow-left mr-2"></i>Previous</button>
                        <button type="button" id="update-property-btn" class="bg-[#1a4977] text-white px-4 py-2 rounded-md"><i class="fas fa-check mr-2"></i>Update Property</button>
                    </div>
                </div></div>

                <div class="fixed bottom-6 right-6">
                    <button type="button" id="floating-save-changes-btn" class="bg-[#1a4977] text-white px-4 py-3 rounded-full shadow-lg"><i class="fas fa-save mr-2"></i>Save Changes</button>
                </div>
            </div>
            </form>
        </main>
    </div>

    <!-- Templates (same as add-property.php) -->
    <template id="room-type-template"><tr class="room-type-row"><td class="px-6 py-4"><input type="text" name="room_type_name[]" class="room-type-name-input w-full border-b" placeholder="e.g. Single Room"></td><td class="px-6 py-4"><input type="number" name="room_type_price[]" class="room-type-price-input w-full border-b" placeholder="e.g. 8000"></td><td class="px-6 py-4"><input type="number" name="room_type_capacity[]" class="room-type-capacity-input w-full border-b" placeholder="e.g. 1"></td><td class="px-6 py-4"><input type="text" name="room_type_description[]" class="room-type-description-input w-full border-b" placeholder="Brief room description"></td><td class="px-6 py-4"><button type="button" class="remove-room-type-btn text-red-600"><i class="fas fa-trash-alt"></i></button></td></tr></template>
    <template id="additional-service-template"><div class="additional-service-item flex items-center mb-2"><div class="flex-grow mr-2"><input type="text" name="service_name[]" class="service-name-input w-full border-b" placeholder="e.g. Laundry"></div><div class="flex items-center mr-2"><span class="mr-1">₹</span><input type="number" name="service_price[]" class="service-price-input w-20 border-b" placeholder="e.g. 500"></div><input type="hidden" name="service_description[]"><button type="button" class="remove-service-btn text-red-600"><i class="fas fa-trash-alt"></i></button></div></template>
    <template id="nearby-place-template"><div class="nearby-place-item flex items-center border rounded-lg p-3 mb-2"><div class="flex-grow"><input type="text" name="nearby_place_name[]" class="place-name-input w-full border-b font-medium" placeholder="Place Name"><div class="flex items-center mt-1"><input type="text" name="nearby_place_type[]" class="place-type-input w-full text-sm mr-2 border-b" placeholder="Type (e.g. School)"><input type="text" name="nearby_place_distance_km[]" class="place-distance-input w-16 text-sm border-b" placeholder="Dist."><span class="text-sm ml-1">km</span></div></div><button type="button" class="remove-place-btn text-red-600 ml-2"><i class="fas fa-trash-alt"></i></button></div></template>

    <script>
        // Store gallery files to be uploaded (new ones)
        let newGalleryFiles = [];
        const propertyId = <?php echo json_encode($property_id_get); ?>;
        const API_BASE_URL = ''; // Assuming scripts are in the same admin folder

        document.addEventListener('DOMContentLoaded', function() {
            // Common setup
            const sidebarToggle = document.getElementById('sidebar-toggle');
            if (sidebarToggle) { sidebarToggle.addEventListener('click', () => document.getElementById('sidebar').classList.toggle('-translate-x-full'));}
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            tabButtons.forEach(button => button.addEventListener('click', function() { switchToTab(this.getAttribute('data-tab')); }));
            function switchToTab(tabName) {
                tabContents.forEach(content => content.classList.remove('active'));
                document.getElementById(`${tabName}-tab`)?.classList.add('active');
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-[#1a4977]', 'text-[#1a4977]', 'active-tab');
                    btn.classList.add('border-transparent', 'text-gray-500');
                    if (btn.getAttribute('data-tab') === tabName) {
                        btn.classList.add('border-[#1a4977]', 'text-[#1a4977]', 'active-tab');
                        btn.classList.remove('border-transparent', 'text-gray-500');
                    }
                });
                 // Adjust active-tab class for styling if needed
                document.querySelectorAll('.active-tab').forEach(el => el.style.cssText = 'border-bottom-width: 2px; border-color: #1a4977; color: #1a4977;');
                const newActiveTab = document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
                if(newActiveTab) newActiveTab.style.cssText = 'border-bottom-width: 2px; border-color: #1a4977; color: #1a4977;';
            }
            
            document.getElementById('has-special-offer')?.addEventListener('change', function() {
                document.getElementById('special-offer-content').classList.toggle('hidden', !this.checked);
            });

            const mainImageUpload = document.getElementById('main-image-upload');
            const mainImagePreviewImg = document.getElementById('main-image-preview-img');
            const mainImagePreviewContainer = document.getElementById('main-image-preview');
            const mainImageUploadBtnContainer = document.getElementById('main-image-upload-btn');
            const removeMainImageBtn = document.getElementById('remove-main-image');

            mainImageUpload?.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        mainImagePreviewImg.src = ev.target.result;
                        mainImagePreviewContainer.classList.remove('hidden');
                        mainImageUploadBtnContainer.classList.add('hidden');
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
            removeMainImageBtn?.addEventListener('click', function() {
                mainImagePreviewContainer.classList.add('hidden');
                mainImageUploadBtnContainer.classList.remove('hidden');
                mainImageUpload.value = ''; 
                mainImagePreviewImg.src = '';
                document.getElementById('existing_main_image_path').value = '';
            });

            const galleryImageTrigger = document.getElementById('gallery-image-trigger');
            galleryImageTrigger?.addEventListener('change', function(e) {
                if (e.target.files) {
                    for (let i = 0; i < e.target.files.length; i++) {
                        addGalleryImagePreview(e.target.files[i], true); 
                    }
                    this.value = ''; 
                }
            });

            const contactImageUpload = document.getElementById('contact-image-upload');
            const contactImagePreview = document.getElementById('contact-image-preview');
            contactImageUpload?.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(ev) { contactImagePreview.src = ev.target.result; };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
            
            document.getElementById('add-room-type-btn')?.addEventListener('click', () => addRoomTypeRow());
            document.getElementById('add-service-btn')?.addEventListener('click', () => addServiceRow());
            document.getElementById('add-nearby-place-btn')?.addEventListener('click', () => addNearbyPlaceRow());

            fetchPropertyDetails(propertyId);

            document.getElementById('update-property-btn')?.addEventListener('click', (e) => { e.preventDefault(); submitPropertyForm('Update Property'); });
            document.getElementById('floating-save-changes-btn')?.addEventListener('click', (e) => { e.preventDefault(); submitPropertyForm('Save Changes');});
            
            // Preview button
            const previewBtn = document.getElementById('preview-property-btn');
            if(previewBtn) {
                previewBtn.onclick = () => {
                    window.open(`../view-details.php?id=${propertyId}`, '_blank');
                };
            }
        });

        function addGalleryImagePreview(fileOrUrl, isNewFile = false) {
            const container = document.getElementById('gallery-images-container');
            const placeholder = document.getElementById('gallery-upload-placeholder');
            const imageDiv = document.createElement('div');
            imageDiv.className = 'relative gallery-image-item';
            const img = document.createElement('img');
            img.alt = "Gallery Image";
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700';
            removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';

            if (isNewFile) {
                const reader = new FileReader();
                reader.onload = function(e) { img.src = e.target.result; };
                reader.readAsDataURL(fileOrUrl);
                newGalleryFiles.push(fileOrUrl);
                removeBtn.onclick = () => {
                    newGalleryFiles = newGalleryFiles.filter(f => f !== fileOrUrl);
                    imageDiv.remove();
                };
            } else {
                img.src = `../${fileOrUrl}`;
                imageDiv.dataset.existingUrl = fileOrUrl;
                removeBtn.onclick = () => { 
                    imageDiv.remove(); 
                    // For existing images, removal means it won't be re-submitted if backend expects all images.
                    // Or, add to a 'deleted_images[]' hidden input if backend supports specific deletion.
                    // Current backend (handle_edit_property) deletes all gallery images and re-adds.
                    // So, removing from UI means it won't be part of the "re-add" if it were part of a more complex strategy.
                };
            }
            imageDiv.appendChild(img);
            imageDiv.appendChild(removeBtn);
            container.insertBefore(imageDiv, placeholder);
        }

        function addRoomTypeRow(room = {}) {
            const template = document.getElementById('room-type-template');
            const container = document.getElementById('room-types-container');
            const clone = document.importNode(template.content, true);
            clone.querySelector('input[name="room_type_name[]"]').value = room.name || '';
            clone.querySelector('input[name="room_type_price[]"]').value = room.price_per_night || '';
            clone.querySelector('input[name="room_type_capacity[]"]').value = room.capacity || '';
            clone.querySelector('input[name="room_type_description[]"]').value = room.description || '';
            clone.querySelector('.remove-room-type-btn').onclick = function() { this.closest('.room-type-row').remove(); };
            container.appendChild(clone);
        }

        function addServiceRow(service = {}) {
            const template = document.getElementById('additional-service-template');
            const container = document.getElementById('additional-services-container');
            const clone = document.importNode(template.content, true);
            clone.querySelector('input[name="service_name[]"]').value = service.name || '';
            clone.querySelector('input[name="service_price[]"]').value = service.price || '';
            clone.querySelector('input[name="service_description[]"]').value = service.description || '';
            clone.querySelector('.remove-service-btn').onclick = function() { this.closest('.additional-service-item').remove(); };
            container.appendChild(clone);
        }

        function addNearbyPlaceRow(place = {}) {
            const template = document.getElementById('nearby-place-template');
            const container = document.getElementById('nearby-places-container');
            const clone = document.importNode(template.content, true);
            clone.querySelector('input[name="nearby_place_name[]"]').value = place.name || '';
            clone.querySelector('input[name="nearby_place_type[]"]').value = place.type || '';
            clone.querySelector('input[name="nearby_place_distance_km[]"]').value = place.distance_km || '';
            clone.querySelector('.remove-place-btn').onclick = function() { this.closest('.nearby-place-item').remove(); };
            container.appendChild(clone);
        }

        async function fetchPropertyDetails(propId) {
            if (!propId) { displayAjaxMessage('error', 'No property ID specified.'); return; }
            try {
                const response = await fetch(`${API_BASE_URL}handle_get_property_details.php?property_id=${propId}`);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();
                if (data.error) throw new Error(data.message);
                document.getElementById('page-title').textContent = `Edit Property: ${data.name || 'Property'}`;
                populateForm(data);
            } catch (error) {
                console.error('Error fetching property details:', error);
                displayAjaxMessage('error', 'Failed to load property details: ' + error.message);
            }
        }

        function populateForm(data) {
            document.getElementById('property_id_hidden').value = data.id || propertyId; // Ensure hidden field has ID
            document.getElementById('property-name').value = data.name || '';
            document.getElementById('property-type').value = data.property_type || '';
            document.getElementById('property-category').value = data.property_category || '';
            document.getElementById('property-rating').value = data.property_rating || '';
            document.getElementById('property-reviewcount').value = data.property_reviewcount || '';
            document.getElementById('property-price').value = data.base_price || data.price || '';
            
            const statusSelect = document.getElementById('property-status');
            const statusMap = {'available': 'active', 'unavailable': 'inactive', 'booked': 'inactive'}; // Example mapping
            statusSelect.value = statusMap[data.status] || data.status || 'draft';
            const selectedOptionText = statusSelect.options[statusSelect.selectedIndex]?.text || 'Draft';
            document.getElementById('current-status-display').textContent = selectedOptionText;
            document.getElementById('current-status-text').textContent = selectedOptionText === 'Draft' ? 'Not yet published' : (selectedOptionText === 'Pending Review' ? 'Awaiting approval' : 'Publicly visible');

            if (data.images && data.images.main_image) {
                document.getElementById('main-image-preview-img').src = `../${data.images.main_image}`;
                document.getElementById('main-image-preview').classList.remove('hidden');
                document.getElementById('main-image-upload-btn').classList.add('hidden');
                document.getElementById('existing_main_image_path').value = data.images.main_image;
            }
            document.getElementById('gallery-images-container').querySelectorAll('.gallery-image-item').forEach(item => item.remove()); // Clear old dynamic previews
            if (data.images && data.images.gallery && data.images.gallery.length > 0) {
                data.images.gallery.forEach(url => addGalleryImagePreview(url, false));
            }
            if (data.contact_image_path) {
                document.getElementById('contact-image-preview').src = `../${data.contact_image_path}`;
                document.getElementById('existing_contact_image_path').value = data.contact_image_path;
            }

            document.getElementById('short-description').value = data.short_description || '';
            document.getElementById('long-description').value = data.description || '';
            document.getElementById('meta-description').value = data.meta_description || '';

            document.getElementById('room-types-container').innerHTML = '';
            if (data.room_types && data.room_types.length > 0) data.room_types.forEach(room => addRoomTypeRow(room));
            
            const hasSpecialOfferCheckbox = document.getElementById('has-special-offer');
            if (data.has_special_offer) {
                hasSpecialOfferCheckbox.checked = true;
                document.getElementById('special-offer-text').value = data.special_offer_text || '';
                document.getElementById('special-offer-content').classList.remove('hidden');
            } else {
                 hasSpecialOfferCheckbox.checked = false;
                 document.getElementById('special-offer-text').value = '';
                 document.getElementById('special-offer-content').classList.add('hidden');
            }


            document.querySelectorAll('#amenities-checkbox-container input[type="checkbox"]').forEach(cb => cb.checked = false);
            if (data.selected_amenity_ids) data.selected_amenity_ids.forEach(id => {
                const cb = document.getElementById(`amenity-${id}`);
                if (cb) cb.checked = true;
            });

            document.getElementById('additional-services-container').innerHTML = '';
            if (data.additional_services) data.additional_services.forEach(service => addServiceRow(service));
            
            document.getElementById('address').value = data.address || '';
            document.getElementById('landmark').value = data.landmark || '';
            document.getElementById('distance').value = data.distance || '';
            document.getElementById('map_latitude').value = data.latitude || '';
            document.getElementById('map_longitude').value = data.longitude || '';

            document.getElementById('nearby-places-container').innerHTML = '';
            if (data.nearby_places) data.nearby_places.forEach(place => addNearbyPlaceRow(place));

            document.getElementById('contact-name').value = data.contact_name || '';
            document.getElementById('contact-title').value = data.contact_title || '';
            document.getElementById('contact-phone').value = data.contact_phone || '';
            document.getElementById('contact-whatsapp').value = data.contact_whatsapp || data.contact_phone || '';
            document.getElementById('contact-email').value = data.contact_email || '';
        }
        
        function displayAjaxMessage(type, message) {
            const successDiv = document.getElementById('ajax-success-message');
            const errorDiv = document.getElementById('ajax-error-message');
            const successText = document.getElementById('ajax-success-text');
            const errorText = document.getElementById('ajax-error-text');
            successDiv.classList.add('hidden'); errorDiv.classList.add('hidden');
            if (type === 'success') { successText.textContent = message; successDiv.classList.remove('hidden'); } 
            else if (type === 'error') { errorText.textContent = message; errorDiv.classList.remove('hidden'); }
            window.scrollTo(0, 0);
        }

        function submitPropertyForm(submitType) {
            const form = document.getElementById('editPropertyForm');
            const formData = new FormData(form); 
            // property_id is already in a hidden field, so it's part of FormData

            newGalleryFiles.forEach(file => formData.append('gallery-image-upload[]', file));
            
            displayAjaxMessage('clear'); 
            const submitButton = document.getElementById('update-property-btn');
            const floatingButton = document.getElementById('floating-save-changes-btn');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            submitButton.disabled = true; floatingButton.disabled = true;

            fetch('handle_edit_property.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayAjaxMessage('success', data.message || (submitType + ' successful! Redirecting...'));
                    setTimeout(() => { window.location.href = 'properties.php'; }, 2000);
                } else {
                    displayAjaxMessage('error', data.message || 'An unknown error occurred.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayAjaxMessage('error', 'A network error occurred. Please try again.');
            })
            .finally(() => {
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false; floatingButton.disabled = false;
                newGalleryFiles = []; 
            });
        }
    </script>
</body>
</html>