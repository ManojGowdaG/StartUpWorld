<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/referral_functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get user's referral data
$stmt = $pdo->prepare("SELECT id, username, referral_code, referral_count FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    header("Location: login.php");
    exit();
}

// Get referral rewards
$stmt = $pdo->prepare("SELECT r.referred_user_id, u.username, r.reward_points, r.reward_status, r.action_type, r.created_at 
                       FROM referral_rewards r
                       JOIN users u ON r.referred_user_id = u.id
                       WHERE r.user_id = ?
                       ORDER BY r.created_at DESC");
$stmt->execute([$userId]);
$referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate referral link
$referralLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.php?ref=" . $userData['referral_code'];

require_once 'templates/referral_dashboard.php';
?>