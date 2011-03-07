<?
require_authenticated();

$thread = PrivateMessageThread::find_by_id($params['id']);
$thread->mark_read_for($current_user);
