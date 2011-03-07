<?

function private_message_get_excerpt($m)
{
  return truncate($m->body);
}

function private_message_status_for($message, $user)
{
  $status = PrivateMessageRecipient::find_or_new_by( array(
    'conditions'=>array('user_id = ? and private_message_id = ?', $user->id, $message->id),
    'attributes'=>array(
      'user_id'=>$user->id,
      'private_message_id'=>$message->id
    )
  ));
  return $status;
}

function private_message_get_recipient($message)
{
  $status = PrivateMessageRecipient::find_all( array(
    'conditions'=>array(
      'private_message_id = ?', $message->id
    )
  ));
  return $status[0]->user;
}