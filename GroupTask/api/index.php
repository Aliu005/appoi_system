<?php
declare(strict_types=1);

// CORS headers for frontend access
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	http_response_code(204);
	exit;
}

require_once __DIR__ . '/config/database.php';

// Helper: send JSON response
function json_response($data, int $statusCode = 200): void
{
	http_response_code($statusCode);
	echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

// Helper: parse JSON body
function get_json_input(): array
{
	$raw = file_get_contents('php://input');
	$decoded = json_decode($raw, true);
	return is_array($decoded) ? $decoded : [];
}

// Basic router
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Allow hosting API at /GroupTask/api or document root
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($scriptDir !== '' && $scriptDir !== '/') {
	$path = preg_replace('#^' . preg_quote($scriptDir, '#') . '#', '', $path);
}
// Also support paths like /index.php/appointments
$path = preg_replace('#^/index\.php#', '', $path);

$db = (new DatabaseConnection())->getPdo();

// Routes
// GET /appointments -> list with optional query params
if ($method === 'GET' && $path === '/appointments') {
	$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 100;
	$offset = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;

	$sql = 'SELECT id, national_id, full_name, phone_number, appointment_date, appointment_reason, reason_description, created_at
			FROM appointments ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	json_response(['data' => $rows]);
	exit;
}

// GET /appointments/{id}
if ($method === 'GET' && preg_match('#^/appointments/(\d+)$#', $path, $m)) {
	$id = (int)$m[1];
	$stmt = $db->prepare('SELECT id, national_id, full_name, phone_number, appointment_date, appointment_reason, reason_description, created_at FROM appointments WHERE id = :id');
	$stmt->execute([':id' => $id]);
	$row = $stmt->fetch();
	if (!$row) {
		json_response(['error' => 'Appointment not found'], 404);
		exit;
	}
	json_response(['data' => $row]);
	exit;
}

// POST /appointments
if ($method === 'POST' && $path === '/appointments') {
	$input = get_json_input();

	$required = ['national_id', 'full_name', 'phone_number', 'appointment_date', 'appointment_reason', 'reason_description'];
	foreach ($required as $field) {
		if (!isset($input[$field]) || $input[$field] === '') {
			json_response(['error' => "Missing field: {$field}"], 400);
			exit;
		}
	}

	try {
		$stmt = $db->prepare('INSERT INTO appointments (national_id, full_name, phone_number, appointment_date, appointment_reason, reason_description, created_at)
			VALUES (:national_id, :full_name, :phone_number, :appointment_date, :appointment_reason, :reason_description, NOW())');
		$stmt->execute([
			':national_id' => $input['national_id'],
			':full_name' => $input['full_name'],
			':phone_number' => $input['phone_number'],
			':appointment_date' => $input['appointment_date'],
			':appointment_reason' => $input['appointment_reason'],
			':reason_description' => $input['reason_description'],
		]);
		$id = (int)$db->lastInsertId();
		json_response(['message' => 'Appointment created', 'id' => $id], 201);
		exit;
	} catch (Throwable $e) {
		json_response(['error' => 'Failed to create appointment', 'details' => $e->getMessage()], 500);
		exit;
	}
}

// PUT /appointments/{id}
if ($method === 'PUT' && preg_match('#^/appointments/(\d+)$#', $path, $m)) {
	$id = (int)$m[1];
	$input = get_json_input();

	$allowed = ['national_id', 'full_name', 'phone_number', 'appointment_date', 'appointment_reason', 'reason_description'];
	$fields = [];
	$params = [':id' => $id];
	foreach ($allowed as $field) {
		if (array_key_exists($field, $input)) {
			$fields[] = "$field = :$field";
			$params[":$field"] = $input[$field];
		}
	}

	if (count($fields) === 0) {
		json_response(['error' => 'No valid fields provided'], 400);
		exit;
	}

	$sql = 'UPDATE appointments SET ' . implode(', ', $fields) . ' WHERE id = :id';
	$stmt = $db->prepare($sql);
	$stmt->execute($params);

	json_response(['message' => 'Appointment updated']);
	exit;
}

json_response(['error' => 'Not Found', 'method' => $method, 'path' => $path], 404);


