<?php
// This should be protected by admin authentication in your actual implementation
if (!isset($allReferrals) || !isset($topReferrers)) {
    die("Direct access not permitted");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Referral Dashboard - StartupWorld</title>
    <link rel="stylesheet" href="../assets/css/referral.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-chart-line"></i> Admin Referral Dashboard</h1>
        
        <div class="stats-section">
            <h2><i class="fas fa-trophy"></i> Top Referrers</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Referrals</th>
                        <th>Join Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topReferrers as $index => $referrer): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($referrer['username']); ?></td>
                        <td><?php echo htmlspecialchars($referrer['referral_count']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($referrer['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="all-referrals">
            <h2><i class="fas fa-list"></i> All Referral Activities</h2>
            <div class="filters">
                <form method="get">
                    <div class="filter-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" placeholder="Username or email">
                    </div>
                    <button type="submit">Apply Filters</button>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Referrer</th>
                        <th>Referred User</th>
                        <th>Points</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allReferrals as $referral): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($referral['referrer']); ?></td>
                        <td><?php echo htmlspecialchars($referral['referred']); ?></td>
                        <td><?php echo htmlspecialchars($referral['reward_points']); ?></td>
                        <td class="status-<?php echo htmlspecialchars($referral['reward_status']); ?>">
                            <?php echo ucfirst(htmlspecialchars($referral['reward_status'])); ?>
                        </td>
                        <td><?php echo htmlspecialchars($referral['action_type']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($referral['created_at'])); ?></td>
                        <td>
                            <?php if ($referral['reward_status'] === 'pending'): ?>
                                <a href="?action=complete&id=<?php echo $referral['id']; ?>" class="action-btn complete">Complete</a>
                                <a href="?action=cancel&id=<?php echo $referral['id']; ?>" class="action-btn cancel">Cancel</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <style>
        .filters {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .filter-group {
            margin-bottom: 10px;
        }
        
        .filter-group label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 0.9em;
            margin-right: 5px;
        }
        
        .complete {
            background: #27ae60;
        }
        
        .cancel {
            background: #e74c3c;
        }
        
        .action-btn:hover {
            opacity: 0.8;
        }
    </style>
</body>
</html>