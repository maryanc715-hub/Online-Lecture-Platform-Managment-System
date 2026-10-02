import './bootstrap';

// Real-time notification polling (swap for Laravel Echo + Pusher/Reverb in production)
document.addEventListener('DOMContentLoaded', () => {
    const badge = document.querySelector('[data-notification-badge]');
    if (!badge) return;

    setInterval(async () => {
        const res = await fetch('/notifications?unread_count=1', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        if (res.ok) {
            const data = await res.json();
            badge.textContent = data.count;
            badge.classList.toggle('hidden', data.count === 0);
        }
    }, 30000);
});
