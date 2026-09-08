<?php include(__DIR__.'/../_connect.php');?>
<?php include(__DIR__.'/../../includes/helpers/short.php');?>
<?php
header('Content-Type: application/json');

function respond_json($success, $payload = array(), $status = 200)
{
    http_response_code($status);
    echo json_encode(array_merge(array('success' => $success), $payload));
    exit;
}

$api_key = isset($_POST['api_key']) ? mysqli_real_escape_string($mysqli, $_POST['api_key']) : null;
$brand_id = isset($_POST['brand_id']) && is_numeric($_POST['brand_id']) ? (int) $_POST['brand_id'] : null;
$name = isset($_POST['name']) ? trim($_POST['name']) : null;

if ($api_key == null) respond_json(false, array('message' => 'API key not passed'), 422);
if (!verify_api_key($api_key)) respond_json(false, array('message' => 'Invalid API key'), 401);
if ($brand_id == null) respond_json(false, array('message' => 'Brand ID not passed'), 422);
if ($name == null || $name === '') respond_json(false, array('message' => 'List name not passed'), 422);

$user_query = 'SELECT id FROM login WHERE api_key = "'.$api_key.'" ORDER BY id ASC LIMIT 1';
$user_result = mysqli_query($mysqli, $user_query);
if (!$user_result || mysqli_num_rows($user_result) == 0) respond_json(false, array('message' => 'Invalid API key'), 401);
$user = mysqli_fetch_assoc($user_result);
$userID = (int) $user['id'];

$app_query = 'SELECT id FROM apps WHERE id = '.$brand_id.' AND userID = '.$userID.' LIMIT 1';
$app_result = mysqli_query($mysqli, $app_query);
if (!$app_result || mysqli_num_rows($app_result) == 0) respond_json(false, array('message' => 'Brand does not belong to API user'), 403);

mysqli_query($mysqli, 'LOCK TABLES lists WRITE');

$stmt = $mysqli->prepare('SELECT id FROM lists WHERE userID = ? AND app = ? AND name = ? LIMIT 1');
if (!$stmt) {
    mysqli_query($mysqli, 'UNLOCK TABLES');
    respond_json(false, array('message' => mysqli_error($mysqli)), 500);
}
$stmt->bind_param('iis', $userID, $brand_id, $name);
$stmt->execute();
$stmt->bind_result($existing_id);

if ($stmt->fetch()) {
    $stmt->close();
    mysqli_query($mysqli, 'UNLOCK TABLES');
    respond_json(true, array('id' => encrypt_val($existing_id), 'raw_id' => $existing_id, 'name' => $name, 'action' => 'existing'));
}
$stmt->close();

$max_result = mysqli_query($mysqli, 'SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM lists');
$max_row = $max_result ? mysqli_fetch_assoc($max_result) : array('next_id' => 1);
$list_id = (int) $max_row['next_id'];

$stmt = $mysqli->prepare('INSERT INTO lists (id, app, userID, name, opt_in, hide) VALUES (?, ?, ?, ?, 0, 0)');
if (!$stmt) {
    mysqli_query($mysqli, 'UNLOCK TABLES');
    respond_json(false, array('message' => mysqli_error($mysqli)), 500);
}
$stmt->bind_param('iiis', $list_id, $brand_id, $userID, $name);
$ok = $stmt->execute();
$error = mysqli_error($mysqli);
$stmt->close();
mysqli_query($mysqli, 'UNLOCK TABLES');

if (!$ok) respond_json(false, array('message' => $error), 500);

respond_json(true, array('id' => encrypt_val($list_id), 'raw_id' => $list_id, 'name' => $name, 'action' => 'created'));
?>
