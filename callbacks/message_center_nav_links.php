<?

$c = $current_user->unread_private_message_count;
$s="";
if ($c>0) $s = "($c)";

$links = array(
  array('href'=>list_private_messages_url(), 'label'=>se("Mail").$s),
  array('href'=>list_sent_private_messages_url(), 'label'=>se('Sent'))
);
