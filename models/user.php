<?

function user_get_unread_private_message_count($user)
{
  $sql = <<<SQL
    select
      count(id) c
    from
      private_message_recipients
    where user_id = {$user->id} and read_at is null
SQL;
  $ret = query_assoc($sql);
  return $ret[0]['c'];
}

function user_get_private_message_threads($user)
{
  $threads = PrivateMessageThread::find_all( array(
    'conditions'=>array(
      'id in (!)',
      "select distinct pm.private_message_thread_id from private_messages pm right join private_message_recipients pmr on pmr.user_id={$user->id} or pm.sender_id={$user->id}"
    )
  ));

  return $threads;
}