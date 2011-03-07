<?

map('content', 'messages/private/new/:username', 'new', 'new_private_message');
map('content', 'messages/private', 'list', 'list_private_messages');
map('content', 'messages/private/view/:id', 'view', 'view_private_message_thread');
map('content', 'messages/private/sent', 'sent', 'list_sent_private_messages');
map('before_render', 'messages/private/view/:id', 'mark_thread_read');