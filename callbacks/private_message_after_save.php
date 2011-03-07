<?

$m = $private_message;

if (!$m->private_message_thread_id)
{
  $mt = PrivateMessageThread::new_model_instance();
  $mt->most_recent_private_message_id = $m->id;
  $mt->subject = $m->subject;
  $mt->save();
  $m->private_message_thread_id = $mt->id;
  $m->save(); // this will cause save to fire twice
} else {
  $m->private_message_thread->most_recent_private_message_id = $m->id;
  $m->private_message_thread->save();
  foreach($m->recipients as $recipient)
  {
    PrivateMessageRecipient::create( array(
      'attributes'=>array(
        'user_id'=>$recipient->id,
        'private_message_id'=>$m->id
      )
    ));
  }

}
