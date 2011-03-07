<?

require_authenticated();

$thread = PrivateMessageThread::find_by_id($params['id']);

require_membership($thread);

$new_message = PrivateMessage::new_model_instance( array(
  'attributes'=>array(
    'sender_id'=>$current_user->id,
    'private_message_thread_id'=>$thread->id
  )
));

if (is_postback())
{
  $new_message->recipients = $thread->recipients_for($current_user);
  $new_message->update_attributes($params['private_message']);
  if ($new_message->is_valid)
  {
    flash("Message sent.");
    $new_message = PrivateMessage::new_model_instance( array(
      'attributes'=>array(
        'sender_id'=>$current_user->id,
        'private_message_thread_id'=>$thread->id
      )
    ));
    $thread = $thread->reload();
  }
}