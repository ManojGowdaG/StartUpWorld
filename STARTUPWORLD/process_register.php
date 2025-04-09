<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/referral_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Generate unique referral code
    do {
        $referralCode = generateReferralCode();
    } while (!isReferralCodeUnique($referralCode));
    
    // Check if user was referred
    $referredBy = null;
    if (!empty($_POST['referral_code'])) {
        $referrer = getUserByReferralCode($_POST['referral_code']);
        if ($referrer) {
            $referredBy = $referrer['id'];
        }
    }
    
    try {
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, referral_code, referred_by) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $referralCode, $referredBy]);
        
        // Update referrer's count if applicable
        if ($referredBy) {
            $stmt = $pdo->prepare("UPDATE users SET referral_count = referral_count + 1 WHERE id = ?");
            $stmt->execute([$referredBy]);
            
            // Create pending reward
            $newUserId = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO referral_rewards (user_id, referred_user_id, reward_points, action_type) 
                                  VALUES (?, ?, 10, 'signup')");
            $stmt->execute([$referredBy, $newUserId]);
        }
        
        // Clear session
        unset($_SESSION['referral_code']);
        
        // Set success message
        $_SESSION['registration_success'] = true;
        
        // Redirect to success page
        header("Location: register_success.php");
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            // Duplicate entry error (username or email already exists)
            $error = "Username or email already exists. Please choose different ones.";
        } else {
            $error = "Registration failed. Please try again later.";
        }
        
        $_SESSION['register_error'] = $error;
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
?>