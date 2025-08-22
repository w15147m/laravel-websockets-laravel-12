

import './echo';
const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content'); // or however you get user ID

if (userId) {
    window.Echo.private(`chat.${userId}`)
        .listen('MessageSent', (data) => {
            console.log('New Chat Message Notification:', data);
        });
}
