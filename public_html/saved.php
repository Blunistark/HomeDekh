<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Accommodations | HomeDhek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-white font-[Inter]">
    <!-- App Container -->
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="./" class="text-[#1a4977] font-bold text-xl">HomeDhek</a>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="index.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Home</a>
                          <a href="pgs.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">View All PGS</a>
                          
                        <a href="saved.php" class="text-[#1a4977] border-b-2 border-[#1a4977] px-3 py-2 text-sm font-medium">Saved</a>
                        
                      <button class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium" onclick="window.location.href='sign-up.php'">Sign In</button>
                    </div>
                    <div class="md:hidden">
                        <button class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Page Header -->
            <div class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Saved Accommodations</h1>
                            <p class="text-sm text-gray-500 mt-1">Your favorite places in one location</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="bg-white border rounded-lg p-2 px-4 text-sm flex items-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                            <div class="relative">
                                <select class="appearance-none border rounded-lg px-4 py-2 pr-8 text-sm bg-white shadow-sm">
                                    <option>Sort by: Date Saved</option>
                                    <option>Sort by: Price</option>
                                    <option>Sort by: Distance</option>
                                    <option>Sort by: Rating</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Saved Count -->
                <div class="mb-6">
                    <h2 class="font-bold text-lg text-gray-900">3 Saved Accommodations</h2>
                </div>

                <!-- Accommodation Grid - Always 2 columns on mobile and more on larger screens -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Accommodation Card 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" stroke="currentColor" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <div class="absolute top-2 left-2 bg-[#1a4977] text-white text-xs px-2 py-1 rounded-full">
                                Saved 2 days ago
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow flex flex-col">
                            <div class="flex items-center gap-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">Stanford University</span>
                            </div>
                            <h3 class="font-medium text-sm sm:text-base mb-1">Sunshine PG for Girls</h3>
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-xs ml-1">4.8</span>
                                </div>
                                <span class="text-xs text-gray-500">0.5 km</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">WiFi</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">AC</span>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹12,000<span class="text-xs text-gray-500">/month</span></p>
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Card 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" stroke="currentColor" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <div class="absolute top-2 left-2 bg-[#1a4977] text-white text-xs px-2 py-1 rounded-full">
                                Saved 1 week ago
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Co-ed</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow flex flex-col">
                            <div class="flex items-center gap-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">MIT</span>
                            </div>
                            <h3 class="font-medium text-sm sm:text-base mb-1">Campus View Residency</h3>
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-xs ml-1">4.6</span>
                                </div>
                                <span class="text-xs text-gray-500">0.8 km</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Food</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Gym</span>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹15,000<span class="text-xs text-gray-500">/month</span></p>
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Card 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" stroke="currentColor" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <div class="absolute top-2 left-2 bg-[#1a4977] text-white text-xs px-2 py-1 rounded-full">
                                Saved 3 weeks ago
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Boys Only</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow flex flex-col">
                            <div class="flex items-center gap-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">Harvard University</span>
                            </div>
                            <h3 class="font-medium text-sm sm:text-base mb-1">Green Valley Boys Hostel</h3>
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-xs ml-1">4.5</span>
                                </div>
                                <span class="text-xs text-gray-500">1.2 km</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Laundry</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Study Room</span>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹9,000<span class="text-xs text-gray-500">/month</span></p>
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State (Hidden by default) -->
                <div class="hidden bg-white rounded-xl p-8 text-center border border-gray-100 mt-6">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No saved accommodations yet</h3>
                    <p class="text-gray-500 mb-6">When you find a place you like, click the heart icon to save it here for easy access.</p>
                    <a href="pgs.php" class="inline-flex items-center bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Accommodations
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
   <?php include "footer.php"; ?>
    </div>

    <script>
        // Add heart toggle functionality for favorites (remove from saved)
        document.addEventListener('DOMContentLoaded', function() {
            const heartButtons = document.querySelectorAll('button');
            
            heartButtons.forEach(button => {
                if (button.querySelector('svg path[d*="M4.318 6.318"]')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const card = this.closest('.bg-white.rounded-xl');
                        
                        // Animate removal
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        
                        setTimeout(() => {
                            card.remove();
                            
                            // Check if there are any cards left
                            const remainingCards = document.querySelectorAll('.grid > .bg-white.rounded-xl');
                            if (remainingCards.length === 0) {
                                // Show empty state
                                document.querySelector('.hidden.bg-white.rounded-xl').classList.remove('hidden');
                                document.querySelector('.grid').classList.add('hidden');
                                document.querySelector('h2.font-bold.text-lg').textContent = '0 Saved Accommodations';
                            } else {
                                // Update count
                                document.querySelector('h2.font-bold.text-lg').textContent = 
                                    `${remainingCards.length} Saved Accommodation${remainingCards.length === 1 ? '' : 's'}`;
                            }
                        }, 300);
                    });
                }
            });
            
            // View details button functionality
            const viewDetailsButtons = document.querySelectorAll('button.w-full');
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const accommodationName = this.closest('.p-3').querySelector('h3').textContent;
                    alert(`Viewing details for ${accommodationName}`);
                });
            });
        });
    </script>
</body>
</html>
