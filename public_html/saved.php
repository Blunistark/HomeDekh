<?php
require_once 'config/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    // Not logged in: redirect or show message
    echo '<div class="min-h-screen flex items-center justify-center"><div class="bg-white p-8 rounded shadow text-center"><h2 class="text-xl font-bold mb-4">Please sign in to view your saved accommodations.</h2><a href="sign-in.php" class="bg-[#1a4977] text-white px-4 py-2 rounded">Sign In</a></div></div>';
    exit;
}
$user_id = $_SESSION['user_id'];
$saved_properties = [];
$sql = "SELECT p.*, pi.image_path AS main_image_path, sp.created_at AS saved_at
        FROM saved_properties sp
        JOIN properties p ON sp.property_id = p.id
        LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_thumbnail = 1
        WHERE sp.user_id = ?
        ORDER BY sp.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $saved_properties[] = $row;
}
$stmt->close();
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
        <main class="flex-grow">
            <!-- Page Header -->
            <div class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Saved Accommodations</h1>
                            <p class="text-sm text-gray-500 mt-1">Your favorite places in one location</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Results Section -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Saved Count -->
                <div class="mb-6">
                    <h2 class="font-bold text-lg text-gray-900"><?php echo count($saved_properties); ?> Saved Accommodation<?php echo count($saved_properties) == 1 ? '' : 's'; ?></h2>
                </div>
                <?php if (empty($saved_properties)): ?>
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl p-8 text-center border border-gray-100 mt-6">
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
                <?php else: ?>
                <!-- Accommodation Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($saved_properties as $property): ?>
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="<?php echo htmlspecialchars($property['main_image_path'] ? $property['main_image_path'] : 'https://via.placeholder.com/400x300.png?text=No+Image'); ?>" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" stroke="currentColor" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <div class="absolute top-2 left-2 bg-[#1a4977] text-white text-xs px-2 py-1 rounded-full">
                                Saved <?php echo date('j M Y', strtotime($property['saved_at'])); ?>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium"><?php echo htmlspecialchars($property['property_category']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow flex flex-col">
                            <div class="flex items-center gap-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-500"><?php echo htmlspecialchars(substr($property['address'], 0, 30)); ?></span>
                            </div>
                            <h3 class="font-medium text-sm sm:text-base mb-1"><?php echo htmlspecialchars($property['name']); ?></h3>
                            <div class="flex items-center gap-1 mb-2">
                                <!-- Optionally, show rating if available -->
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <?php $amenities = get_property_amenities($conn, $property['id']); foreach ($amenities as $amenity): ?>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full"><?php echo htmlspecialchars($amenity); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹<?php echo htmlspecialchars(number_format((float)($property['base_price'] ?? 0))); ?><span class="text-xs text-gray-500">/month</span></p>
                                <a href="view-details.php?id=<?php echo $property['id']; ?>" class="w-full block bg-[#1a4977] text-white py-1.5 rounded-lg text-sm text-center">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </main>
        <!-- Footer -->
        <?php include "footer.php"; ?>
    </div>
</body>
</html>



