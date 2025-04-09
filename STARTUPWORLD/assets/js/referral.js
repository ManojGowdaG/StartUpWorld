document.addEventListener('DOMContentLoaded', function() {
    // Copy Referral Link Functionality
    const copyReferralLink = () => {
        const referralLink = document.getElementById('referralLink');
        referralLink.select();
        referralLink.setSelectionRange(0, 99999);
        
        document.execCommand('copy');
        
        // Show notification
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = 'Referral link copied to clipboard!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 2000);
    };
    
    // Attach event listener to copy button
    const copyButton = document.querySelector('.link-container button');
    if (copyButton) {
        copyButton.addEventListener('click', copyReferralLink);
    }
    
    // Share button handlers
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('copy-btn')) {
                e.preventDefault();
                copyReferralLink();
            }
        });
    });
    
    // Notification styling (dynamically added)
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
        }
        .notification.show {
            opacity: 1;
        }
    `;
    document.head.appendChild(style);
});