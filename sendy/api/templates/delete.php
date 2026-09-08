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

if ($api_key == null) respond_json(false, array('message' => 'API key not passed'), 422);
if (!verify_api_key($api_key)) respond_json(false, array('message' => 'Invalid API key'), 401);
if ($app == null) respond_json(false, array('message' => 'Brand ID not passed'), 422);
if ($template_id == null) respond_json(false, array('message' => 'Template ID not passed'), 422);

$user_query = 'SELECT id FROM login WHERE api_key = "'.$api_key.'" ORDER BY id ASC LIMIT 1';
$user_result = mysqli_query($mysqli, $user_query);
if (!$user_result || mysqli_num_rows($user_result) == 0) respond_json(false, array('message' => 'Invalid API key'), 401);
$user = mysqli_fetch_assoc($user_result);
$userID = (int) $user['id'];

$app_query = 'SELECT id FROM apps WHERE id = '.$app.' AND userID = '.$userID.' LIMIT 1';
$app_result = mysqli_query($mysqli, $app_query);
if (!$app_result || mysqli_num_rows($app_result) == 0) respond_json(false, array('message' => 'Brand does not belong to API user'), 403);

$stmt = $mysqli->prepare('DELETE FROM template WHERE id = ? AND userID = ? AND app = ?');
if (!$stmt) respond_json(false, array('message' => mysqli_error($mysqli)), 500);
$stmt->bind_param('iii', $template_id, $userID, $app);
$ok = $stmt->execute();
$deleted = $stmt->affected_rows;
$stmt->close();

if (!$ok) respond_json(false, array('message' => mysqli_error($mysqli)), 500);

respond_json(true, array('id' => $template_id, 'deleted' => $deleted));
?>
