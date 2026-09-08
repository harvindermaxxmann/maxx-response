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
$list_id = isset($_POST['list_id']) ? decrypt_int($_POST['list_id']) : null;
$subscribers_json = isset($_POST['subscribers']) ? $_POST['subscribers'] : null;

if ($api_key == null) respond_json(false, array('message' => 'API key not passed'), 422);
if (!verify_api_key($api_key)) respond_json(false, array('message' => 'Invalid API key'), 401);
if ($list_id == null) respond_json(false, array('message' => 'List ID not passed'), 422);
if ($subscribers_json == null || trim($subscribers_json) === '') respond_json(false, array('message' => 'Subscribers not passed'), 422);

$list_result = mysqli_query($mysqli, 'SELECT id FROM lists WHERE id = '.$list_id.' LIMIT 1');
if (!$list_result || mysqli_num_rows($list_result) == 0) respond_json(false, array('message' => 'List does not exist'), 404);

$subscribers = json_decode($subscribers_json, true);
if (!is_array($subscribers)) respond_json(false, array('message' => 'Subscribers must be a JSON array'), 422);

$now = time();
$join_date = round(time() / 60) * 60;
$inserted = 0;
$updated = 0;
$skipped = 0;

mysqli_query($mysqli, 'LOCK TABLES subscribers WRITE');
$max_result = mysqli_query($mysqli, 'SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM subscribers');
$max_row = $max_result ? mysqli_fetch_assoc($max_result) : array('next_id' => 1);
$next_id = (int) $max_row['next_id'];

foreach ($subscribers as $subscriber) {
    $email = isset($subscriber['email']) ? trim($subscriber['email']) : '';
    $name = isset($subscriber['name']) ? trim($subscriber['name']) : '';

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $skipped++;
        continue;
    }

    if ($name === '') $name = $email;

    $email_safe = mysqli_real_escape_string($mysqli, $email);
    $name_safe = mysqli_real_escape_string($mysqli, strip_tags($name));

    $existing = mysqli_query($mysqli, 'SELECT id FROM subscribers WHERE email = "'.$email_safe.'" AND list = '.$list_id.' LIMIT 1');

    if ($existing && mysqli_num_rows($existing) > 0) {
        $row = mysqli_fetch_assoc($existing);
        $subscriber_id = (int) $row['id'];
        $update = 'UPDATE subscribers SET name = "'.$name_safe.'", unsubscribed = 0, bounced = 0, bounce_soft = 0, complaint = 0, confirmed = 1, timestamp = '.$now.' WHERE id = '.$subscriber_id;

        if (mysqli_query($mysqli, $update)) $updated++;
        else $skipped++;
    } else {
        $subscriber_id = $next_id++;
        $insert = 'INSERT INTO subscribers (id, name, email, list, unsubscribed, bounced, bounce_soft, complaint, confirmed, added_via, timestamp, join_date) VALUES ('.$subscriber_id.', "'.$name_safe.'", "'.$email_safe.'", '.$list_id.', 0, 0, 0, 0, 1, 2, '.$now.', '.$join_date.')';

        if (mysqli_query($mysqli, $insert)) $inserted++;
        else $skipped++;
    }
}

mysqli_query($mysqli, 'UNLOCK TABLES');

respond_json(true, array(
    'total' => count($subscribers),
    'inserted' => $inserted,
    'updated' => $updated,
    'skipped' => $skipped
));
?>
