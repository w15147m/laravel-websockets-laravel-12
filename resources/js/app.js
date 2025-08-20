/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content'); // or however you get user ID

if (userId) {
    window.Echo.private(`chat.${userId}`)
        .listen('MessageSent', (data) => {
            console.log('New Chat Message Notification:', data);
        });
}
