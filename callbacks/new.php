<?

require_authenticated();

$recipient = User::find_by_username($params['username']);

$message = PrivateMessage::new_model_instance( array(
  'attributes'=>array(
    'sender_id'=>$current_user->id
  )
));
$message->recipients[] = $recipient;

event('contact_user_init_message', array('recipient'=>$recipient, 'message'=>&$message));

if (is_postback())
{
  $message->update_attributes($params['private_message']);
  if ($message->is_valid)
  {
    foreach($message->recipients as $to)
    {
      notify($to, 'new_private_message', array('from'=>$current_user, 'message'=>$message));
    }
    flash("Message sent.");
    if (array_key_exists('r', $params))
    {
      flash_next("Message sent.");
      redirect_to($params['r']);
    }
  }
}