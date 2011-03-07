<?

 $notDelivered = PrivateMessageRecipient::find_all(array("conditions'=>'delivered_at=''", 'load'=>array('user', 'private_message')));
 foreach ($notDelivered as $rec)
 {
    deliver('new_private_email', array(
    'user'=>$rec->user
    ));
 }