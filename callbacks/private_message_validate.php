<?

if (isset($private_message->subject))
{
  $private_message->subject = trim($private_message->subject);
  if (strlen($private_message->subject)==0) $private_message->errors['subject'] = 'is required.';
}
$private_message->body = trim($private_message->body);
if (strlen($private_message->body)==0) $private_message->errors['body'] = 'is required.';
