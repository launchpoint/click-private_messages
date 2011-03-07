<?

function private_message_thread_next_message_to_read_for($t, $u)
{
  $m = $t->unread_messages_for($u);
  if (count($m)>0)
  {
    return $m[0];
  } 
  if ($t->last_received_message_for($u)) 
  {
    $ts= $t->last_received_message_for($u);
    return $ts[0];
  }
  return $t->last_sent_message;
}

function private_message_thread_get_last_sent_message($t)
{
  return $t->private_messages[count($t->private_messages)-1];
}


function private_message_thread_last_received_message_for($t, $u)
{
  $messages = PrivateMessage::find_all( array(
    'conditions'=>array(
      'sender_id !=  '. $u->id.'  and private_message_thread_id = '. $t->id
    ),
    'limit'=>'1',
    'order'=>'created_at desc'
  ));
  return $messages;
}

function private_message_thread_unread_messages_for($t, $u)
{
  $messages = PrivateMessage::find_all( array(
    'joins'=>'join private_message_recipients pmr on private_messages.id = pmr.private_message_id',
    'conditions'=>array(
      'pmr.read_at is null and private_messages.private_message_thread_id = '. $t->id .' and sender_id !=  '. $u->id
    )
  ));
  
  return $messages;
}

function private_message_thread_messages_for($t,$u)
{
  return $t->private_messages;
}

function private_message_thread_is_member($t, $u)
{
  $sql = <<<SQL
    select
      count(distinct pmt.id) c
    from
      private_message_threads pmt join private_messages pm on pmt.id = pm.private_message_thread_id 
      right join private_message_recipients pmr on pmr.private_message_id = pm.id 
    where
      pmr.user_id = {$u->id} or pm.sender_id = {$u->id}
SQL;
  $res = query_assoc($sql);
  return $res[0]['c']>0;
}

function private_message_thread_mark_read_for($t, $u)
{
  foreach($t->private_messages as $m)
  {
    $pmr = $m->status_for($u);
    if (!$pmr->read_at)
    {
      $pmr->read_at = time();
      $pmr->save();
    }
  }

}

function private_message_thread_recipients_for($t, $u)
{
  $recips = User::find_all( array (
    'conditions'=>array('id in (
          select
            distinct pmr.user_id
          from 
            private_message_recipients pmr join private_messages pm on pmr.private_message_id = pm.id 
          where
            pm.private_message_thread_id = ?
        UNION
          select
            distinct pm.sender_id
          from 
            private_messages pm
          where
            pm.private_message_thread_id = ?
      ) and id <> ?', $t->id, $t->id,$u->id)
  ));
  return $recips;
}