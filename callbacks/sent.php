<?


$messages = PrivateMessage::find_all(array('conditions'=>'sender_id = '.$current_user->id));