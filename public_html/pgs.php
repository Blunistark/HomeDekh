<?php
require_once 'config/db.php'; // Corrected path for Database Connection

// Step 2: Fetch Properties from Database
$properties = [];
$query_error = null;
$total_properties = 0;
$total_pages = 0;

// Ensure session is started (db.php should ideally handle this)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user's saved properties if logged in
$user_saved_property_ids = [];
if (isset($_SESSION['user_id'])) {
    $user_id_for_saved = $_SESSION['user_id'];
    $saved_sql = "SELECT property_id FROM saved_properties WHERE user_id = ?";
    $stmt_saved = $conn->prepare($saved_sql);
    if ($stmt_saved) {
        $stmt_saved->bind_param("i", $user_id_for_saved);
        if ($stmt_saved->execute()) {
            $saved_result = $stmt_saved->get_result();
            while ($saved_row = $saved_result->fetch_assoc()) {
                $user_saved_property_ids[] = $saved_row['property_id'];
            }
        } else {
             // Optional: Log error or set a notice if saved properties couldn't be fetched
            $query_error .= " Error fetching saved properties: " . $stmt_saved->error;
        }
        $stmt_saved->close();
    } else {
        $query_error .= " Error preparing saved properties query: " . $conn->error;
    }
}


// Pagination Variables
$results_per_page = 12; 
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
}
$offset = ($current_page - 1) * $results_per_page;

// Retrieve Search Query
$search_query_raw = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';

// Retrieve Filter Parameters
$price_max = isset($_GET['price_max']) ? filter_var($_GET['price_max'], FILTER_VALIDATE_INT) : null;
$accommodation_type = isset($_GET['type']) ? trim(htmlspecialchars($_GET['type'])) : null;
$selected_amenities_raw = isset($_GET['amenities']) && is_array($_GET['amenities']) ? $_GET['amenities'] : [];
$selected_amenities = [];
foreach($selected_amenities_raw as $amenity_val) {
    $selected_amenities[] = trim(htmlspecialchars($amenity_val));
}

// Fetch all amenities for filter sidebar
$all_amenities = [];
$amenities_sql = "SELECT name FROM amenities ORDER BY name ASC";
$amenities_result = $conn->query($amenities_sql);
if ($amenities_result) {
    while ($row = $amenities_result->fetch_assoc()) {
        $all_amenities[] = $row['name'];
    }
}

// Get user location from URL if provided
$user_lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$user_lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;

// Base SQL parts
if ($user_lat !== null && $user_lng !== null) {
    $sql_select_main = "SELECT p.id, p.name, p.property_category, p.landmark, p.address, p.base_price, p.property_rating, p.status, pi.image_path AS main_image_path, p.latitude, p.longitude, (6371 * acos(cos(radians(?)) * cos(radians(p.latitude)) * cos(radians(p.longitude) - radians(?)) + sin(radians(?)) * sin(radians(p.latitude)))) AS distance";
    $sql_select_count = "SELECT COUNT(DISTINCT p.id) as total";
    $sql_from_joins = "FROM properties p LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_thumbnail = TRUE";
} else {
    $sql_select_main = "SELECT p.id, p.name, p.property_category, p.landmark, p.address, p.base_price, p.property_rating, p.status, pi.image_path AS main_image_path, p.latitude, p.longitude";
    $sql_select_count = "SELECT COUNT(DISTINCT p.id) as total";
    $sql_from_joins = "FROM properties p LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_thumbnail = TRUE";
}

// WHERE clauses and parameters will be the same for both main query and count query
$where_clauses = ["p.status = 'active'"];
$query_params = []; // Renamed from $params to avoid confusion with URL params later
$query_types = "";  // Renamed from $types

// Search Query Filter
if (!empty($search_query_raw)) {
    $where_clauses[] = "(p.name LIKE ? OR p.address LIKE ? OR p.landmark LIKE ? OR p.property_category LIKE ? OR p.description LIKE ?)";
    $search_param = "%" . $search_query_raw . "%";
    array_push($query_params, $search_param, $search_param, $search_param, $search_param, $search_param);
    $query_types .= "sssss";
}

// Price Range Filter
if ($price_max !== null && $price_max !== false && $price_max > 0) {
    $where_clauses[] = "p.base_price <= ?";
    $query_params[] = $price_max;
    $query_types .= "i";
}

// Accommodation Type Filter
if (!empty($accommodation_type) && $accommodation_type !== 'All Types' && $accommodation_type !== "") {
    $where_clauses[] = "p.property_type = ?";
    $query_params[] = $accommodation_type;
    $query_types .= "s";
}

// Amenity Filter (Subquery construction)
$amenity_subquery_sql_part = "";
if (!empty($selected_amenities)) {
    $amenity_placeholders = implode(',', array_fill(0, count($selected_amenities), '?'));
    // The subquery itself should not be part of $sql_from_joins if it's complex for COUNT
    // Instead, it's a condition in WHERE clause.
    $amenity_subquery_sql_part = "p.id IN (
        SELECT pa.property_id
        FROM property_amenities pa
        JOIN amenities a ON pa.amenity_id = a.id
        WHERE a.name IN ($amenity_placeholders)
        GROUP BY pa.property_id
        HAVING COUNT(DISTINCT a.id) = ?
    )";
    $where_clauses[] = $amenity_subquery_sql_part;
    // Parameters for this subquery part
    foreach ($selected_amenities as $amenity_name) {
        $query_params[] = $amenity_name;
        $query_types .= 's';
    }
    $query_params[] = count($selected_amenities);
    $query_types .= 'i';
}

$sql_where_clause = "";
if (!empty($where_clauses)) {
    $sql_where_clause = " WHERE " . implode(" AND ", $where_clauses);
}

// --- Count Total Properties ---
$sql_count_query = $sql_select_count . " " . $sql_from_joins . $sql_where_clause;
$stmt_count = $conn->prepare($sql_count_query);
if ($stmt_count) {
    if (!empty($query_params)) { // Bind the same parameters used for filtering
        // Need to adjust params if amenity subquery is different for count, but here it's part of WHERE
        $stmt_count->bind_param($query_types, ...$query_params);
    }
    if ($stmt_count->execute()) {
        $count_result = $stmt_count->get_result();
        $total_properties_row = $count_result->fetch_assoc();
        $total_properties = $total_properties_row ? (int)$total_properties_row['total'] : 0;
    } else {
        $query_error .= " Count query execution failed: " . $stmt_count->error;
        $total_properties = 0; // Fallback
    }
    $stmt_count->close();
} else {
    $query_error .= " Count query preparation failed: " . $conn->error;
    $total_properties = 0; // Fallback
}
$total_pages = $total_properties > 0 ? ceil($total_properties / $results_per_page) : 0;
if ($current_page > $total_pages && $total_pages > 0) { // If current page is out of bounds
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $results_per_page; // Recalculate offset
} elseif ($total_pages == 0 && $current_page > 1) { // No results, but page > 1 requested
    $current_page = 1;
    $offset = 0;
}


// --- Fetch Paginated Properties ---
$sql_main_query = "";
if ($user_lat !== null && $user_lng !== null) {
    $sql_main_query = $sql_select_main . " " . $sql_from_joins . $sql_where_clause . " ORDER BY distance ASC LIMIT ? OFFSET ?";
} else {
    $sql_main_query = $sql_select_main . " " . $sql_from_joins . $sql_where_clause . " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
}

// Add pagination params to a new array to avoid modifying $query_params used by count
$main_query_params = $query_params; // Copy filter/search params
$main_query_types = $query_types;   // Copy filter/search types

$main_query_params[] = $results_per_page;
$main_query_types .= 'i';
$main_query_params[] = $offset;
$main_query_types .= 'i';

// Bind lat/lng if present
if ($user_lat !== null && $user_lng !== null) {
    array_unshift($main_query_params, $user_lat, $user_lng, $user_lat);
    $main_query_types = str_repeat('d', 3) . $main_query_types;
}

$stmt_main = $conn->prepare($sql_main_query);
if ($stmt_main) {
    if (!empty($main_query_params)) {
        $stmt_main->bind_param($main_query_types, ...$main_query_params);
    }
    if ($stmt_main->execute()) {
        $result = $stmt_main->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $properties[] = $row;
            }
        } else {
            $query_error .= " Main query result fetching failed: " . $stmt_main->error;
        }
    } else {
        $query_error .= " Main query execution failed: " . $stmt_main->error . " (SQL: " . $sql_main_query . ")";
    }
    $stmt_main->close();
} else {
    $query_error .= " Main query preparation failed: " . $conn->error . " (SQL: " . $sql_main_query . ")";
}

// $search_query_display & $page_subtitle are set using $search_query_raw
$search_query_display = htmlspecialchars($search_query_raw);
$page_subtitle = $search_query_display ? "Results for \"{$search_query_display}\"" : "Explore Accommodations Near You";

// Update results count text to use $total_properties
$results_count_text = $total_properties . ($total_properties == 1 ? " Result Found" : " Results Found");

// For each property, fetch top 3 amenities
function get_property_amenities($conn, $property_id, $limit = 3) {
    $sql = "SELECT a.name FROM property_amenities pa JOIN amenities a ON pa.amenity_id = a.id WHERE pa.property_id = ? LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $property_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $amenities = [];
    while ($row = $result->fetch_assoc()) {
        $amenities[] = $row['name'];
    }
    $stmt->close();
    return $amenities;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Accommodation Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Leaflet CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-white font-[Inter]">
    <!-- App Container -->
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-[#1a4977] font-bold text-xl"><a href="./" class="text-[#1a4977] font-bold text-xl">HomeDhek</a></span>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="index.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="pgs.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">View All PGS</a>
                        <a href="saved.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Saved</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php
                            $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
                            if (!$user_name) {
                                $uid = $_SESSION['user_id'];
                                $stmt = $conn->prepare("SELECT name FROM users WHERE id = ? LIMIT 1");
                                $stmt->bind_param("i", $uid);
                                $stmt->execute();
                                $stmt->bind_result($user_name);
                                $stmt->fetch();
                                $stmt->close();
                                $_SESSION['user_name'] = $user_name;
                            }
                            ?>
                            <span class="text-[#1a4977] font-semibold px-3 py-2 text-sm">Hello, <?php echo htmlspecialchars($user_name); ?></span>
                            <form action="logout.php" method="post" style="display:inline;">
                                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium ml-2">Logout</button>
                            </form>
                        <?php else: ?>
                            <button class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium" onclick="window.location.href='sign-up.php'">Sign In</button>
                        <?php endif; ?>
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
        <main class="flex-grow relative">
            <!-- Search Section -->
            <div class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Find Your Perfect College Accommodation</h1>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-grow">
                            <div class="flex items-center border rounded-lg p-2 bg-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            <input type="text" id="searchInputPg" value="<?php echo $search_query_display; ?>" placeholder="Search by location, college, or property name" class="ml-2 w-full outline-none text-sm">
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button id="filterButton" class="bg-white border rounded-lg p-2 px-4 text-sm flex items-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                            <button id="toggleMapButton" class="bg-white border rounded-lg p-2 px-4 text-sm flex items-center shadow-sm ml-2">Hide Map</button>
                            <button id="searchButtonPg" class="bg-[#1a4977] text-white rounded-lg p-2 px-4 text-sm shadow-sm">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Sidebar Overlay -->
            <div id="filterOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

            <!-- Filter Sidebar -->
            <div id="filterSidebar" class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg z-30 transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                <div class="p-5 flex flex-col h-full">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="font-bold text-lg">Filter Options</h2>
                        <button id="closeFilterButton" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium text-sm mb-3">Price Range (₹/month)</h3>
                        <div class="mb-2">
                            <input type="range" id="priceRange" min="0" max="20000" value="20000" class="w-full accent-[#1a4977]">
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>₹0</span>
                                <span id="priceValue">₹20,000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Type Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium text-sm mb-3">Accommodation Type</h3>
                        <div class="relative">
                            <select id="accommodationType" class="appearance-none border rounded-md px-3 py-2 pr-8 text-sm bg-white w-full">
                                <option value="">All Types</option>
                                <option value="pg">PG</option>
                                <option value="hostel">Hostel</option>
                                <option value="apartment">Apartment</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium text-sm mb-3">Amenities</h3>
                        <div class="grid grid-cols-2 gap-2" id="amenitiesFilterContainer">
                            <?php foreach ($all_amenities as $amenity): ?>
                            <div class="flex items-center">
                                <input type="checkbox" id="amenity-<?php echo htmlspecialchars($amenity); ?>" value="<?php echo htmlspecialchars($amenity); ?>" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                <label for="amenity-<?php echo htmlspecialchars($amenity); ?>" class="ml-2 text-sm text-gray-600"><?php echo htmlspecialchars($amenity); ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mt-auto flex gap-3">
                        <button id="resetFilters" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg text-sm">Reset</button>
                        <button id="applyFilters" class="flex-1 bg-[#1a4977] text-white py-2 rounded-lg text-sm">Apply Filters</button>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Applied Filters -->
                <div id="appliedFilters" class="mb-4 flex flex-wrap gap-2 hidden">
                    <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                        TV
                        <button class="ml-1 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                    <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                        WiFi
                        <button class="ml-1 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                    <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                        AC
                        <button class="ml-1 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                    <button id="clearAllFilters" class="text-[#1a4977] text-xs font-medium">Clear All</button>
                </div>

                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                    <div>
                        <h2 id="resultsCount" class="font-bold text-lg text-gray-900"><?php echo $results_count_text; ?></h2>
                        <p class="text-sm text-gray-500"><?php echo $page_subtitle; ?></p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <div class="relative flex-grow sm:flex-grow-0">
                            <select class="appearance-none border rounded-md px-3 py-2 pr-8 text-sm bg-white w-full">
                                <option>Recommended</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Rating</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accommodation Grid - Always 2 columns on mobile and more on larger screens -->
                <div id="properties-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php if ($query_error): ?>
                        <p class="col-span-full text-red-500">Error fetching properties: <?php echo htmlspecialchars($query_error); ?></p>
                    <?php elseif (empty($properties)): ?>
                        <p class="col-span-full text-gray-500">No properties found matching your criteria.</p>
                    <?php else: ?>
                        <?php foreach ($properties as $property): ?>
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                            <div class="relative aspect-[4/3]">
                                <?php 
                                    $image_path = htmlspecialchars($property['main_image_path'] ? $property['main_image_path'] : 'https://via.placeholder.com/400x300.png?text=No+Image');
                                    // Assuming $property['main_image_path'] is like 'uploads/property_images/foo.jpg'
                                    // and pgs.php is in public_html, so the path is relative from public_html.
                                    // If pgs.php was in public_html/pages/ and uploads in public_html/uploads, it would be '../uploads/...'
                                    // Current assumption: pgs.php is in public_html, db path starts with 'uploads/'
                                ?>
                                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($property['name']); ?>" class="w-full h-full object-cover">
                                <?php
                                    $is_saved = in_array($property['id'], $user_saved_property_ids);
                                    $heart_icon_class = $is_saved ? 'text-red-500' : 'text-gray-400';
                                    $heart_icon_fill = $is_saved ? 'currentColor' : 'none';
                                ?>
                                <button class="save-property-btn absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm" data-property-id="<?php echo $property['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 <?php echo $heart_icon_class; ?>" fill="<?php echo $heart_icon_fill; ?>" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">
                                            <?php echo htmlspecialchars(ucfirst($property['property_category'])); // e.g. Girls, Boys, Co-ed ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 flex-grow flex flex-col">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500 truncate" title="<?php echo htmlspecialchars($property['landmark'] ?: $property['address']); ?>">
                                        <?php echo htmlspecialchars($property['landmark'] ?: substr($property['address'], 0, 30) . (strlen($property['address']) > 30 ? '...' : '')); ?>
                                    </span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1 truncate" title="<?php echo htmlspecialchars($property['name']); ?>">
                                    <?php echo htmlspecialchars($property['name']); ?>
                                </h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1"><?php echo htmlspecialchars(number_format((float)($property['property_rating'] ?? 0), 1)); ?></span>
                                    </div>
                                    <!-- Distance: Omitted for now as not in base query, can add later -->
                                    <!-- <span class="text-xs text-gray-500">0.5 km</span> -->
                                </div>
                                <div class="flex flex-wrap gap-1 mb-2">
                                    <?php $amenities = get_property_amenities($conn, $property['id']); foreach ($amenities as $amenity): ?>
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full"><?php echo htmlspecialchars($amenity); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mt-auto">
                                    <p class="font-medium text-sm mb-2">₹<?php echo htmlspecialchars(number_format((float)($property['base_price'] ?? 0))); ?><span class="text-xs text-gray-500">/month</span></p>
                                    <a href="view-details.php?id=<?php echo $property['id']; ?>" class="block w-full text-center bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <nav class="flex items-center gap-1">
                        <?php
                        if ($total_pages > 1):
                            $url_params = $_GET; // Get all current GET parameters
                            
                            // Previous Button
                            if ($current_page > 1):
                                $url_params['page'] = $current_page - 1; ?>
                                <a href="?<?php echo http_build_query($url_params); ?>" class="px-3 py-1 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Previous</a>
                            <?php else: ?>
                                <span class="px-3 py-1 border rounded-md text-sm text-gray-400 bg-gray-100 cursor-not-allowed">Previous</span>
                            <?php endif;

                            // Page Number Buttons (simplified for now, can add ellipsis later)
                            $num_links_to_show = 5; // Number of page links to show around current page
                            $start_page = max(1, $current_page - floor($num_links_to_show / 2));
                            $end_page = min($total_pages, $start_page + $num_links_to_show - 1);
                             // Adjust start_page again if end_page is capacity-limited
                            $start_page = max(1, $end_page - $num_links_to_show + 1);


                            if ($start_page > 1) {
                                $url_params['page'] = 1;
                                echo "<a href='?page=1&".http_build_query($url_params)."' class='px-3 py-1 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50'>1</a>";
                                if ($start_page > 2) {
                                     echo "<span class='px-3 py-1 text-sm'>...</span>";
                                }
                            }

                            for ($i = $start_page; $i <= $end_page; $i++):
                                $url_params['page'] = $i;
                                $is_current_page = ($i == $current_page);
                                $active_class = $is_current_page ? 'bg-[#1a4977] text-white' : 'text-gray-700 bg-white hover:bg-gray-50';
                            ?>
                                <a href="?<?php echo http_build_query($url_params); ?>" class="px-3 py-1 border rounded-md text-sm <?php echo $active_class; ?>"><?php echo $i; ?></a>
                            <?php endfor;

                            if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1) {
                                    echo "<span class='px-3 py-1 text-sm'>...</span>";
                                }
                                $url_params['page'] = $total_pages;
                                 echo "<a href='?page=".$total_pages."&".http_build_query($url_params)."' class='px-3 py-1 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50'>".$total_pages."</a>";
                            }

                            // Next Button
                            if ($current_page < $total_pages):
                                $url_params['page'] = $current_page + 1; ?>
                                <a href="?<?php echo http_build_query($url_params); ?>" class="px-3 py-1 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Next</a>
                            <?php else: ?>
                                <span class="px-3 py-1 border rounded-md text-sm text-gray-400 bg-gray-100 cursor-not-allowed">Next</span>
                            <?php endif;
                        endif;
                        ?>
                    </nav>
                </div>
            </div>
        </main>

        <!-- Footer -->
 <?php include "footer.php"?>
    </div>

    <script>
        // Filter sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filterButton');
            const searchInputPg = document.getElementById('searchInputPg');
            const searchButtonPg = document.getElementById('searchButtonPg');

            if(searchButtonPg && searchInputPg) {
                searchButtonPg.addEventListener('click', function() {
                    const query = searchInputPg.value.trim();
                    if (query) {
                        window.location.href = 'pgs.php?search_query=' + encodeURIComponent(query);
                    } else {
                        window.location.href = 'pgs.php';
                    }
                });

                searchInputPg.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = searchInputPg.value.trim();
                        if (query) {
                            window.location.href = 'pgs.php?search_query=' + encodeURIComponent(query);
                        } else {
                            window.location.href = 'pgs.php';
                        }
                    }
                });
            }
            
            const closeFilterButton = document.getElementById('closeFilterButton');
            const filterSidebar = document.getElementById('filterSidebar');
            const filterOverlay = document.getElementById('filterOverlay');
            const applyFilters = document.getElementById('applyFilters');
            const resetFilters = document.getElementById('resetFilters');
            const clearAllFilters = document.getElementById('clearAllFilters');
            const appliedFilters = document.getElementById('appliedFilters');
            const priceRange = document.getElementById('priceRange');
            const priceValue = document.getElementById('priceValue');
            
            // Update price value display
            priceRange.addEventListener('input', function() {
                priceValue.textContent = '₹' + parseInt(this.value).toLocaleString();
            });
            
            // Open filter sidebar
            filterButton.addEventListener('click', function() {
                filterSidebar.classList.remove('translate-x-full');
                filterOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
            
            // Close filter sidebar
            function closeFilterSidebar() {
                filterSidebar.classList.add('translate-x-full');
                filterOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            closeFilterButton.addEventListener('click', closeFilterSidebar);
            filterOverlay.addEventListener('click', closeFilterSidebar);
            
            // Apply filters
            applyFilters.addEventListener('click', function() {
                const priceMax = document.getElementById('priceRange').value;
                const accommodationTypeValue = document.getElementById('accommodationType').value;
                const amenitiesCheckboxes = document.querySelectorAll('#amenitiesFilterContainer input[type="checkbox"]:checked');
                
                const selectedAmenityValues = [];
                amenitiesCheckboxes.forEach(checkbox => {
                    selectedAmenityValues.push(checkbox.value); 
                });

                const params = new URLSearchParams(window.location.search); 

                // Set or delete price_max
                // Using 20000 as a string, as input type range value is a string
                if (priceMax && priceMax !== "20000") { 
                    params.set('price_max', priceMax);
                } else {
                    params.delete('price_max');
                }

                // Set or delete type
                if (accommodationTypeValue && accommodationTypeValue !== "") { // Check against empty string for "All Types"
                    params.set('type', accommodationTypeValue);
                } else {
                    params.delete('type');
                }

                // Clear existing amenities params before adding new ones
                params.delete('amenities[]'); 
                selectedAmenityValues.forEach(amenity => {
                    params.append('amenities[]', amenity);
                });
                
                window.location.href = window.location.pathname + '?' + params.toString();
                // No need to call closeFilterSidebar() as the page will reload.
            });
            
            // Reset filters
            resetFilters.addEventListener('click', function() {
                document.getElementById('priceRange').value = 20000; // Reset to max/default
                document.getElementById('priceValue').textContent = '₹20,000';
                document.getElementById('accommodationType').value = ""; // Reset to "All Types"
                document.querySelectorAll('#amenitiesFilterContainer input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
                // Optionally, could also clear displayed applied filters here if they were purely JS driven before page reload
            });
            
            // Clear all applied filters (from the main page, not sidebar)
            if (clearAllFilters) {
                clearAllFilters.addEventListener('click', function() {
                    const params = new URLSearchParams(window.location.search);
                    params.delete('price_max');
                    params.delete('type');
                    params.delete('amenities[]');
                    // Only keep search_query if it exists
                    const searchQuery = params.get('search_query');
                    const newParams = new URLSearchParams();
                    if (searchQuery) {
                        newParams.set('search_query', searchQuery);
                    }
                    window.location.href = window.location.pathname + (searchQuery ? '?' + newParams.toString() : '');
                });
            }

            // Function to set filter states from URL params on page load
            function setFilterStatesFromURL() {
                const params = new URLSearchParams(window.location.search);

                const priceRangeInput = document.getElementById('priceRange');
                const priceValueDisplay = document.getElementById('priceValue');
                const accommodationTypeSelect = document.getElementById('accommodationType');

                const priceMaxFromURL = params.get('price_max');
                if (priceMaxFromURL && priceRangeInput) {
                    priceRangeInput.value = priceMaxFromURL;
                    if (priceValueDisplay) {
                         priceValueDisplay.textContent = '₹' + parseInt(priceMaxFromURL).toLocaleString();
                    }
                } else if (priceRangeInput) { // Reset to default if not in URL
                    priceRangeInput.value = "20000";
                     if (priceValueDisplay) {
                        priceValueDisplay.textContent = '₹20,000';
                     }
                }


                const typeFromURL = params.get('type');
                if (typeFromURL && accommodationTypeSelect) {
                    accommodationTypeSelect.value = typeFromURL;
                } else if (accommodationTypeSelect) {
                     accommodationTypeSelect.value = ""; // Default to "All Types"
                }

                // Uncheck all amenity checkboxes first
                document.querySelectorAll('#amenitiesFilterContainer input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
                // Then check the ones from the URL
                const amenitiesFromURL = params.getAll('amenities[]');
                if (amenitiesFromURL.length > 0) {
                    amenitiesFromURL.forEach(amenityValue => {
                        // Ensure the selector correctly targets the checkbox by its value attribute
                        const checkbox = document.querySelector(`#amenitiesFilterContainer input[type="checkbox"][value="${CSS.escape(amenityValue)}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
                
                // Update displayed applied filters (tags)
                updateDisplayedAppliedFilters();
            }

            function updateDisplayedAppliedFilters() {
                const params = new URLSearchParams(window.location.search);
                const appliedFiltersContainer = document.getElementById('appliedFilters');
                appliedFiltersContainer.innerHTML = ''; // Clear current tags
                let hasFilters = false;

                const priceMaxParam = params.get('price_max');
                if (priceMaxParam) {
                    addFilterTag(`Price: ≤ ₹${parseInt(priceMaxParam).toLocaleString()}`, 'price_max', appliedFiltersContainer);
                    hasFilters = true;
                }
                const typeParam = params.get('type');
                if (typeParam && typeParam !== "") {
                    // Get the display text from the option value
                    const typeOption = document.querySelector(`#accommodationType option[value="${CSS.escape(typeParam)}"]`);
                    const typeDisplayText = typeOption ? typeOption.textContent : typeParam;
                    addFilterTag(`Type: ${typeDisplayText}`, 'type', appliedFiltersContainer);
                    hasFilters = true;
                }
                const amenitiesParams = params.getAll('amenities[]');
                amenitiesParams.forEach(amenityValue => {
                    // Get the display text from the checkbox label or value
                    const amenityCheckbox = document.querySelector(`#amenitiesFilterContainer input[type="checkbox"][value="${CSS.escape(amenityValue)}"]`);
                    const amenityLabel = amenityCheckbox && amenityCheckbox.nextElementSibling ? amenityCheckbox.nextElementSibling.textContent : amenityValue;
                    addFilterTag(`Amenity: ${amenityLabel}`, `amenities[]=${amenityValue}`, appliedFiltersContainer);
                    hasFilters = true;
                });

                if (hasFilters) {
                    appliedFiltersContainer.classList.remove('hidden');
                    const clearAllBtn = document.createElement('button');
                    // Use the existing ID if it's meant for this, or ensure a unique one if needed.
                    // Assuming 'clearAllFilters' is the ID of the button in the static HTML for this purpose.
                    // If not, it should be added to the HTML or this should be clearAllFiltersRuntime
                    clearAllBtn.id = 'clearAllFiltersTagButton'; 
                    clearAllBtn.className = 'text-[#1a4977] text-xs font-medium';
                    clearAllBtn.textContent = 'Clear All';
                    clearAllBtn.addEventListener('click', function() {
                        const currentParams = new URLSearchParams(window.location.search);
                        const searchQuery = currentParams.get('search_query');
                        const newParams = new URLSearchParams();
                        if (searchQuery && searchQuery.trim() !== "") {
                            newParams.set('search_query', searchQuery);
                            window.location.href = window.location.pathname + '?' + newParams.toString();
                        } else {
                            window.location.href = window.location.pathname; // Go to page without any query params
                        }
                    });
                    appliedFiltersContainer.appendChild(clearAllBtn);
                } else {
                    appliedFiltersContainer.classList.add('hidden');
                }
            }
            
            function addFilterTag(text, paramName, container) {
                const tag = document.createElement('span');
                tag.className = 'bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center';
                tag.textContent = text;
                const removeBtn = document.createElement('button');
                removeBtn.className = 'ml-1 text-gray-500 hover:text-gray-700';
                removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>`;
                removeBtn.addEventListener('click', function() {
                    const params = new URLSearchParams(window.location.search);
                    if (paramName.startsWith('amenities[]=')) { // Handle amenity array removal
                        const amenityValue = paramName.split('=')[1];
                        const currentAmenities = params.getAll('amenities[]');
                        params.delete('amenities[]');
                        currentAmenities.filter(a => a !== amenityValue).forEach(a => params.append('amenities[]', a));
                    } else {
                        params.delete(paramName);
                    }
                    window.location.href = window.location.pathname + '?' + params.toString();
                });
                tag.appendChild(removeBtn);
                container.appendChild(tag);
            }

            setFilterStatesFromURL(); // Call on page load to set filter states

            // Add heart toggle functionality for favorites (Save Property)
            const savePropertyButtons = document.querySelectorAll('.save-property-btn');
            
            savePropertyButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const propertyId = this.dataset.propertyId;
                    const svgElement = this.querySelector('svg');
                    const pathElement = svgElement.querySelector('path');
                    
                    // Determine action based on current state
                    const isCurrentlySaved = pathElement.getAttribute('fill') === 'currentColor';
                    const action = isCurrentlySaved ? 'unsave' : 'save';

                    fetch('handle_save_property.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            property_id: propertyId,
                            action: action
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.status === 'saved') {
                                pathElement.setAttribute('fill', 'currentColor');
                                svgElement.classList.remove('text-gray-400');
                                svgElement.classList.add('text-red-500');
                            } else if (data.status === 'unsaved') {
                                pathElement.setAttribute('fill', 'none');
                                svgElement.classList.remove('text-red-500');
                                svgElement.classList.add('text-gray-400');
                            }
                            // Optionally, show a small success message/toast
                        } else {
                            if (data.action === 'login_required') {
                                window.location.href = 'sign-in.php'; // Or your login page
                            } else {
                                alert(data.message || 'An error occurred.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error saving property:', error);
                        alert('An error occurred while saving the property. Please try again.');
                    });
                });
            });
            
            // View details button functionality
            const viewDetailsButtons = document.querySelectorAll('button.w-full');
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const accommodationName = this.closest('.p-3').querySelector('h3').textContent;
                    alert(`Viewing details for ${accommodationName}`);
                });
            });
            
            // Filter tag removal
            const filterTags = document.querySelectorAll('#appliedFilters span button');
            filterTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    this.parentElement.remove();
                    
                    // Check if there are any remaining filter tags
                    if (document.querySelectorAll('#appliedFilters span').length === 0) {
                        appliedFilters.classList.add('hidden');
                        document.getElementById('resultsCount').textContent = '3 Results Found';
                    } else {
                        document.getElementById('resultsCount').textContent = '4 Results Found';
                    }
                });
            });

            // Map Section
            document.addEventListener('DOMContentLoaded', function() {
                var defaultLat = <?php echo isset($_GET['lat']) ? floatval($_GET['lat']) : 20.5937; ?>;
                var defaultLng = <?php echo isset($_GET['lng']) ? floatval($_GET['lng']) : 78.9629; ?>;
                var map = L.map('map').setView([defaultLat, defaultLng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // User's current location marker (blue)
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLat = position.coords.latitude;
                        var userLng = position.coords.longitude;
                        L.marker([userLat, userLng], {icon: L.icon({iconUrl: 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-blue.png', shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png', iconSize: [25,41], iconAnchor: [12,41], popupAnchor: [1,-34], shadowSize: [41,41]})})
                            .addTo(map)
                            .bindPopup('Your Current Location').openPopup();
                    });
                }

                // Draggable search marker (red)
                var searchMarker = L.marker([defaultLat, defaultLng], {
                    draggable: true,
                    icon: L.icon({iconUrl: 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-red.png', shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png', iconSize: [25,41], iconAnchor: [12,41], popupAnchor: [1,-34], shadowSize: [41,41]})
                }).addTo(map)
                .bindPopup('Drag me or click on the map to set search location.<br>PGs will be shown near this point.')
                .openPopup();

                searchMarker.on('dragend', function(e) {
                    var pos = searchMarker.getLatLng();
                    updateLocation(pos.lat, pos.lng);
                });
                map.on('click', function(e) {
                    searchMarker.setLatLng(e.latlng);
                    updateLocation(e.latlng.lat, e.latlng.lng);
                });
                function updateLocation(lat, lng) {
                    var params = new URLSearchParams(window.location.search);
                    params.set('lat', lat);
                    params.set('lng', lng);
                    window.location.search = params.toString();
                }

                // Show PGs as markers
                <?php foreach ($properties as $property):
                    if (!empty($property['latitude']) && !empty($property['longitude'])): ?>
                    L.marker([<?php echo $property['latitude']; ?>, <?php echo $property['longitude']; ?>])
                        .addTo(map)
                        .bindPopup(`<?php echo addslashes(htmlspecialchars($property['name'])); ?><br><a href='view-details.php?id=<?php echo $property['id']; ?>' target='_blank'>View Details</a>`);
                <?php endif; endforeach; ?>
            });

            // Map toggle logic
            var mapDiv = document.getElementById('map');
            var toggleMapBtn = document.getElementById('toggleMapButton');
            toggleMapBtn.addEventListener('click', function() {
                if (mapDiv.style.display === 'none') {
                    mapDiv.style.display = '';
                    toggleMapBtn.textContent = 'Hide Map';
                } else {
                    mapDiv.style.display = 'none';
                    toggleMapBtn.textContent = 'Show Map';
                }
            });
        });
    </script>
</body>
</html>

