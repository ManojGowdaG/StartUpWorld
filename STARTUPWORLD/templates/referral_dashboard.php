<?php
if (!isset($userId) || !isset($userData) || !isset($referrals) || !isset($referralLink)) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Dashboard - StartupWorld</title>
    <link rel="stylesheet" href="../assets/css/referral.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-friends"></i> Your Referral Dashboard</h1>
        
        <div class="referral-stats">
            <div class="stat-box">
                <h3><i class="fas fa-id-card"></i> Your Referral Code</h3>
                <p class="referral-code"><?php echo htmlspecialchars($userData['referral_code']); ?></p>
                <p>Share this code with friends</p>
            </div>
            <div class="stat-box">
                <h3><i class="fas fa-users"></i> People Referred</h3>
                <p class="count"><?php echo htmlspecialchars($userData['referral_count']); ?></p>
                <p>Total referrals</p>
            </div>
            <?php $stats = getReferralStats($userId); ?>
            <div class="stat-box">
                <h3><i class="fas fa-coins"></i> Your Rewards</h3>
                <p class="count"><?php echo $stats['total_points']; ?> pts</p>
                <p><?php echo $stats['completed_rewards']; ?> completed rewards</p>
            </div>
        </div>
        
        <div class="referral-link">
            <h2><i class="fas fa-link"></i> Your Referral Link</h2>
            <div class="link-container">
                <input type="text" id="referralLink" value="<?php echo htmlspecialchars($referralLink); ?>" readonly>
                <button><i class="fas fa-copy"></i> Copy</button>
            </div>
            <p class="share-text">Share your link via:</p>
            <div class="share-buttons">
                <a href="https://wa.me/?text=Join%20StartupWorld%20using%20my%20referral%20link:%20<?php echo urlencode($referralLink); ?>" class="share-btn whatsapp">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="mailto:?subject=Join%20StartupWorld&body=Check%20out%20StartupWorld%20using%20my%20referral%20link:%20<?php echo urlencode($referralLink); ?>" class="share-btn email">
                    <i class="fas fa-envelope"></i> Email
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($referralLink); ?>" class="share-btn facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text=Join%20StartupWorld%20with%20my%20referral%20link:%20<?php echo urlencode($referralLink); ?>" class="share-btn twitter">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="#" class="share-btn copy-btn">
                    <i class="fas fa-copy"></i> Copy Link
                </a>
            </div>
        </div>
        
        <div class="referral-history">
            <h2><i class="fas fa-history"></i> Your Referral History</h2>
            <?php if (count($referrals) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Referred User</th>
                            <th>Points</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($referrals as $referral): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($referral['username']); ?></td>
                            <td><?php echo htmlspecialchars($referral['reward_points']); ?></td>
                            <td class="status-<?php echo htmlspecialchars($referral['reward_status']); ?>">
                                <?php echo ucfirst(htmlspecialchars($referral['reward_status'])); ?>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($referral['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($referral['action_type']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You haven't referred anyone yet. Share your referral link to start earning rewards!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="../assets/js/referral.js"></script>
</body>
</html>