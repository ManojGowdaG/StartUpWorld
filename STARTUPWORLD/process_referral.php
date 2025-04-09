
<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/referral_functions.php';

// This would typically be called via AJAX or after specific user actions

// Check if user is logged in and is admin (for admin actions)
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Access denied");
}

$userId = $_SESSION['user_id'];

// Handle different referral actions
if (isset($_GET['action'])) {
    try {
        switch ($_GET['action']) {
            case 'complete_reward':
                if (!isset($_GET['reward_id'])) {
                    throw new Exception("Reward ID not specified");
                }
                
                $rewardId = (int)$_GET['reward_id'];
                $stmt = $pdo->prepare("UPDATE referral_rewards SET reward_status = 'completed' 
                                      WHERE id = ? AND user_id = ?");
                $stmt->execute([$rewardId, $userId]);
                
                // Here you would add logic to actually grant the reward
                
                echo json_encode(['success' => true, 'message' => 'Reward completed successfully']);
                break;
                
            case 'get_stats':
                $stats = getReferralStats($userId);
                echo json_encode(['success' => true, 'stats' => $stats]);
                break;
                
            default:
                throw new Exception("Invalid action");
        }
    } catch (Exception $e) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['success' => false, 'error' => 'No action specified']);
}
?>