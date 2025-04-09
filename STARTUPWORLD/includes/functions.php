<?php
require_once 'config/database.php';

function generateReferralCode($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $code;
}

function isReferralCodeUnique($code) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE referral_code = ?");
    $stmt->execute([$code]);
    
    return $stmt->rowCount() === 0;
}

function getUserByReferralCode($code) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE referral_code = ?");
    $stmt->execute([$code]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>