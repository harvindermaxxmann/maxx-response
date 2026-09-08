<?php include(__DIR__.'/../_connect.php');?>
<?php
header('Content-Type: application/json');

function respond_json($success, $payload = array(), $status = 200)
{
    http_response_code($status);
    echo json_encode(array_merge(array('success' => $success), $payload));
    exit;
}

$api_key = isset($_POST['api_key']) ? mysqli_real_escape_string($mysqli, $_POST['api_key']) : null;
$app = isset($_POST['brand_id']) && is_numeric($_POST['brand_id']) ? (int) $_POST['brand_id'] : null;
$template_id = isset($_POST['template_id']) && is_numeric($_POST['template_id']) ? (int) $_POST['template_id'] : null;
$template_name = isset($_POST['template_name']) ? trim($_POST['template_name']) : null;
$html_text = isset($_POST['html_text']) ? $_POST['html_text'] : null;
$plain_text = isset($_POST['plain_text']) ? $_POST['plain_text'] : '';

if ($api_key == null) respond_json(false, array('message' => 'API key not passed'), 422);
if (!verify_api_key($api_key)) respond_json(false, array('message' => 'Invalid API key'), 401);
if ($app == null) respond_json(false, array('message' => 'Brand ID not passed'), 422);
if ($template_name == null || $template_name === '') respond_json(false, array('message' => 'Template name not passed'), 422);
if ($html_text == null || trim($html_text) === '') respond_json(false, array('message' => 'HTML not passed'), 422);

$user_query = 'SELECT id FROM login WHERE api_key = "'.$api_key.'" ORDER BY id ASC LIMIT 1';
$user_result = mysqli_query($mysqli, $user_query);
if (!$user_result || mysqli_num_rows($user_result) == 0) respond_json(false, array('message' => 'Invalid API key'), 401);
$user = mysqli_fetch_assoc($user_result);
$userID = (int) $user['id'];

$app_query = 'SELECT id FROM apps WHERE id = '.$app.' AND userID = '.$userID.' LIMIT 1';
$app_result = mysqli_query($mysqli, $app_query);
if (!$app_result || mysqli_num_rows($app_result) == 0) respond_json(false, array('message' => 'Brand does not belong to API user'), 403);

if ($template_id) {
    $stmt = $mysqli->prepare('UPDATE template SET template_name = ?, html_text = ?, plain_text = ? WHERE id = ? AND userID = ? AND app = ?');
    if (!$stmt) respond_json(false, array('message' => mysqli_error($mysqli)), 500);
    $stmt->bind_param('sssiii', $template_name, $html_text, $plain_text, $template_id, $userID, $app);
    $ok = $stmt->execute();
    $updated = $stmt->affected_rows;
    $stmt->close();

    if (!$ok) respond_json(false, array('message' => mysqli_error($mysqli)), 500);

    $check = mysqli_query($mysqli, 'SELECT id FROM template WHERE id = '.$template_id.' AND userID = '.$userID.' AND app = '.$app.' LIMIT 1');
    if ($check && mysqli_num_rows($check) > 0) {
        respond_json(true, array('id' => $template_id, 'action' => 'updated', 'updated' => $updated));
    }
}

mysqli_query($mysqli, 'LOCK TABLES template WRITE');

$max_result = mysqli_query($mysqli, 'SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM template');
$max_row = $max_result ? mysqli_fetch_assoc($max_result) : array('next_id' => 1);
$new_id = (int) $max_row['next_id'];

$stmt = $mysqli->prepare('INSERT INTO template (id, userID, app, template_name, html_text, plain_text) VALUES (?, ?, ?, ?, ?, ?)');
if (!$stmt) {
    mysqli_query($mysqli, 'UNLOCK TABLES');
    respond_json(false, array('message' => mysqli_error($mysqli)), 500);
}
$stmt->bind_param('iiisss', $new_id, $userID, $app, $template_name, $html_text, $plain_text);
$ok = $stmt->execute();
$error = mysqli_error($mysqli);
$stmt->close();
mysqli_query($mysqli, 'UNLOCK TABLES');

if (!$ok) respond_json(false, array('message' => $error), 500);

respond_json(true, array('id' => $new_id, 'action' => 'created'));
?>
