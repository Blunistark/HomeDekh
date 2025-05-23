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
    $sql_select = "SELECT p.* "; // Select all from properties, can be specific later
    $sql_count = "SELECT COUNT(DISTINCT p.id) "; // Count distinct property IDs

    $sql_from = "FROM properties p ";
    $sql_joins = "";
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
        $placeholders = implode(',', array_fill(0, $num_selected_amenities, '?'));

        $sql_joins .= "LEFT JOIN property_amenities pa ON p.id = pa.property_id ";
        // We need to ensure that properties selected have ALL the amenities.
        // One way is to ensure they are in the list of selected amenities and then count them.
        $sql_where .= "AND pa.amenity_id IN ($placeholders) ";
        foreach ($amenities_filter as $amenity_id) {
            $params[] = $amenity_id;
            $types .= "i";
        }
        // This subquery approach for a direct join might be simpler than GROUP BY in main query for selection part
        // However, the COUNT query will need the GROUP BY.
        // For the main selection, we use a subquery to get property IDs that match all amenities
        $sql_where .= "AND p.id IN (
            SELECT pa_sub.property_id 
            FROM property_amenities pa_sub 
            WHERE pa_sub.amenity_id IN ($placeholders)
            GROUP BY pa_sub.property_id 
            HAVING COUNT(DISTINCT pa_sub.amenity_id) = ?
        ) ";
        // Add params for the subquery's IN clause again
        foreach ($amenities_filter as $amenity_id) {
            $params[] = $amenity_id;
            $types .= "i";
        }
        // Add param for the HAVING COUNT
        $params[] = $num_selected_amenities;
        $types .= "i";
    }


    // Construct full queries
    $sql_main = $sql_select . $sql_from . $sql_joins . $sql_where . " ORDER BY {$sort_by} {$sort_order} LIMIT ? OFFSET ?";
    $sql_total_count = $sql_count . $sql_from . $sql_joins . $sql_where;


    // 6. Execute Query and Fetch Data
    // Fetch Total Records
    $stmt_count = $conn->prepare($sql_total_count);
    if (!$stmt_count) {
        throw new Exception("Prepare failed (count): " . $conn->error);
    }
    if (!empty($types)) { // Bind params if there are any WHERE conditions
        $stmt_count->bind_param($types, ...$params);
    }
    if (!$stmt_count->execute()) {
        throw new Exception("Execute failed (count): " . $stmt_count->error);
    }
    $result_count = $stmt_count->get_result();
    $total_records = $result_count->fetch_row()[0];
    $stmt_count->close();


    // Fetch Properties for the current page
    $stmt_main = $conn->prepare($sql_main);
    if (!$stmt_main) {
        throw new Exception("Prepare failed (main): " . $conn->error);
    }
    $current_params = $params; // Params for the main query
    $current_types = $types;   // Types for the main query
    $current_params[] = $limit;
    $current_types .= "i";
    $current_params[] = $offset;
    $current_types .= "i";

    if (!empty($current_types)) {
        $stmt_main->bind_param($current_types, ...$current_params);
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
