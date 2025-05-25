<?php
header('Content-Type: application/json');

require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

try {
    // 4. Handle Request Parameters
    $search = trim($_GET['search'] ?? '');
    $type = trim($_GET['type'] ?? ''); // PG, Hostel, Apartment - assumed to be property_type field
    $status_filter = trim($_GET['status'] ?? ''); // Draft, Pending, Active, Inactive
    $price_min = !empty(trim($_GET['price_min'] ?? '')) ? (float)trim($_GET['price_min']) : null;
    $price_max = !empty(trim($_GET['price_max'] ?? '')) ? (float)trim($_GET['price_max']) : null;
    $category = trim($_GET['category'] ?? ''); // Girls, Boys, Co-ed - assumed to be property_category field
    $amenities_filter = $_GET['amenities'] ?? []; // Array of amenity IDs
    if (!is_array($amenities_filter)) $amenities_filter = [$amenities_filter]; // Ensure it's an array
    $amenities_filter = array_filter(array_map('intval', $amenities_filter)); // Sanitize to array of ints


    $sort_by = trim($_GET['sort_by'] ?? 'p.created_at');
    $sort_order = strtoupper(trim($_GET['sort_order'] ?? 'DESC'));
    if (!in_array($sort_order, ['ASC', 'DESC'])) {
        $sort_order = 'DESC';
    }
    // Whitelist sortable columns (p refers to properties table alias)
    $allowed_sort_columns = ['p.name', 'p.base_price', 'p.created_at', 'p.property_type', 'p.status', 'p.property_category'];
    if (!in_array($sort_by, $allowed_sort_columns)) {
        $sort_by = 'p.created_at';
    }


    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    if ($limit < 1) $limit = 10;
    $offset = ($page - 1) * $limit;

    // 5. Construct SQL Query Dynamically
    // Fetch Main Image Path: Modified $sql_select and $sql_joins
    $sql_select = "SELECT p.*, pi.image_path AS main_image_path ";
    $sql_count = "SELECT COUNT(DISTINCT p.id) "; 

    $sql_from = "FROM properties p ";
    // Always LEFT JOIN property_images to get the main image if available
    $sql_joins = "LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_thumbnail = TRUE "; 
    
    $sql_where = "WHERE 1=1 "; // Start WHERE clause
    $params = []; // For prepared statements
    $types = ""; // For prepared statements bind_param types

    // Search
    if (!empty($search)) {
        // Assuming 'landmark' is a field in 'properties' or part of 'address'
        $sql_where .= "AND (p.name LIKE ? OR p.address LIKE ? OR p.landmark LIKE ?) ";
        $search_param = "%{$search}%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= "sss";
    }

    // Type (PG, Hostel, Apartment) - assumed field 'property_type'
    if (!empty($type)) {
        $sql_where .= "AND p.property_type = ? ";
        $params[] = $type;
        $types .= "s";
    }

    // Status (Draft, Pending, Active, Inactive)
    if (!empty($status_filter)) {
        $db_status = '';
        $sf_lower = strtolower($status_filter);
        if (in_array($sf_lower, ['draft', 'pending', 'inactive'])) {
            $db_status = 'unavailable';
        } elseif ($sf_lower === 'active') {
            $db_status = 'available';
        }
        // If you have a 'booked' status and want to query it directly:
        // elseif ($sf_lower === 'booked') $db_status = 'booked';

        if (!empty($db_status)) {
            $sql_where .= "AND p.status = ? ";
            $params[] = $db_status;
            $types .= "s";
        }
    }

    // Price Range - assumed field 'base_price' in properties table
    if ($price_min !== null) {
        $sql_where .= "AND p.base_price >= ? ";
        $params[] = $price_min;
        $types .= "d";
    }
    if ($price_max !== null) {
        $sql_where .= "AND p.base_price <= ? ";
        $params[] = $price_max;
        $types .= "d";
    }

    // Category (Girls, Boys, Co-ed) - assumed field 'property_category'
    if (!empty($category)) {
        $sql_where .= "AND p.property_category = ? ";
        $params[] = $category;
        $types .= "s";
    }

    // Amenities (filter by ALL selected)
    if (!empty($amenities_filter)) {
        $num_selected_amenities = count($amenities_filter);
        $num_selected_amenities = count($amenities_filter);
        $placeholders_amenities_in = implode(',', array_fill(0, $num_selected_amenities, '?'));

        // Ensure property_amenities join is only added once if amenities are filtered
        // The $sql_joins for property_images is already there.
        // We need to ensure that the property_amenities join is correctly aliased and used.
        // The current structure might re-add JOINs if not careful.
        // Let's ensure $sql_joins is built carefully.
        // $sql_joins already has the property_images join.
        // Add property_amenities join if not already implicitly part of a more complex structure.
        // The subquery approach is safer.
        
        $sql_where .= "AND p.id IN (
            SELECT pa_sub.property_id 
            FROM property_amenities pa_sub 
            WHERE pa_sub.amenity_id IN ($placeholders_amenities_in)
            GROUP BY pa_sub.property_id 
            HAVING COUNT(DISTINCT pa_sub.amenity_id) = ?
        ) ";
        // Add params for the subquery's IN clause
        foreach ($amenities_filter as $amenity_id) {
            $params[] = $amenity_id;
            $types .= "i";
        }
        // Add param for the HAVING COUNT
        $params[] = $num_selected_amenities;
        $types .= "i";
    }
    
    // Construct full queries
    // $sql_joins will contain the LEFT JOIN for property_images and potentially others if added for specific filters.
    // The property_amenities join for filtering is handled via a subquery in WHERE.
    $sql_query_base = $sql_from . $sql_joins . $sql_where;

    $sql_main = $sql_select . $sql_query_base . " ORDER BY {$sort_by} {$sort_order} LIMIT ? OFFSET ?";
    $sql_total_count = $sql_count . $sql_query_base;


    // 6. Execute Query and Fetch Data
    // Fetch Total Records
    $stmt_count = $conn->prepare($sql_total_count);
    if (!$stmt_count) {
        // Provide more context for debugging
        throw new Exception("Prepare failed (count): " . $conn->error . " Query: " . $sql_total_count);
    }
    // Parameters for count query are the same as for the main query's WHERE part
    $count_params = $params; 
    $count_types = $types;

    if (!empty($count_types)) { 
        $stmt_count->bind_param($count_types, ...$count_params);
    }
    if (!$stmt_count->execute()) {
        throw new Exception("Execute failed (count): " . $stmt_count->error);
    }
    $result_count = $stmt_count->get_result();
    $total_records_row = $result_count->fetch_row();
    $total_records = $total_records_row ? $total_records_row[0] : 0;
    $stmt_count->close();


    // Fetch Properties for the current page
    $stmt_main = $conn->prepare($sql_main);
    if (!$stmt_main) {
        throw new Exception("Prepare failed (main): " . $conn->error . " Query: " . $sql_main);
    }
    $main_params = $params; // Params for the main query's WHERE part
    $main_types = $types;   // Types for the main query's WHERE part
    
    // Add LIMIT and OFFSET params for the main query
    $main_params[] = $limit;
    $main_types .= "i";
    $main_params[] = $offset;
    $main_types .= "i";

    if (!empty($main_types)) {
        $stmt_main->bind_param($main_types, ...$main_params);
    }
    if (!$stmt_main->execute()) {
        throw new Exception("Execute failed (main): " . $stmt_main->error);
    }
    $result_main = $stmt_main->get_result();
    $properties = [];
    while ($row = $result_main->fetch_assoc()) {
        // Optionally fetch related data like images, amenities for each property here if needed for display
        // For now, just returning property data
        $properties[] = $row;
    }
    $stmt_main->close();

    $total_pages = ceil($total_records / $limit);

    // 7. Return JSON Response
    echo json_encode([
        'properties' => $properties,
        'pagination' => [
            'total_records' => (int)$total_records,
            'current_page' => $page,
            'total_pages' => (int)$total_pages,
            'limit' => $limit
        ]
    ]);

} catch (Exception $e) {
    // 8. Error Handling
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
