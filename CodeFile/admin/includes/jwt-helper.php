<?php
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

echo 'ENCRYPTED_SECRET_KEY: ' . getenv('ENCRYPTED_SECRET_KEY') . "\n";
echo 'DECRYPTION_PASSWORD: ' . getenv('DECRYPTION_PASSWORD') . "\n";
// Sử dụng Dotenv để tải biến môi trường
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


// Lấy khóa bí mật từ biến môi trường
// $key = getenv('SECRET_KEY');
// $key = $_ENV['SECRET_KEY'];
// $key = "your_secret_key"; // Khóa bí mật

// Hàm giải mã biến môi trưong base64 và thực hiện giải mã AES-256-CBC
function decryptEnvironmentVariable($encryptedValue, $password) {
    // Mã hóa base64 trước khi giải mã
    $decoded = base64_decode($encryptedValue);
    if ($decoded === false) {
        throw new Exception('Failed to decode base64 value');
    }
    
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($decoded, 0, $iv_length);
    $ciphertext = substr($decoded, $iv_length);
    
    // Giải mã dữ liệu
    $decrypted = openssl_decrypt($ciphertext, 'aes-256-cbc', $password, 0, $iv);
    if ($decrypted === false) {
        throw new Exception('Decryption failed');
    }
    return $decrypted;
}

// Hàm lấy khóa bí mật
function getSecretKey() {
    try {
        // Lấy giá trị mã hóa từ biến môi trường
        $encryptedSecretKey = getenv('ENCRYPTED_SECRET_KEY');
        if ($encryptedSecretKey === false) {
            throw new Exception('ENCRYPTED_SECRET_KEY is not set in environment');
        }
        var_dump(getenv('ENCRYPTED_SECRET_KEY'));

        // Mật khẩu giải mã (nên được bảo mật)
        $decryptionPassword = getenv('DECRYPTION_PASSWORD');
        if ($decryptionPassword === false) {
            throw new Exception('DECRYPTION_PASSWORD is not set in environment');
        }

        // Giải mã khóa bí mật
        return decryptEnvironmentVariable($encryptedSecretKey, $decryptionPassword);

    } catch (Exception $e) {
        // Xử lý ngoại lệ: ghi log hoặc thông báo cho người dùng
        error_log('Error retrieving secret key: ' . $e->getMessage());
        // Hoặc hiển thị thông báo lỗi ra màn hình
        echo 'Error: ' . $e->getMessage() . "\n";
        // Có thể trả về giá trị mặc định hoặc kết thúc chương trình tùy thuộc vào yêu cầu
        return null;
    }
}


// Retrieve the secret key
$key = getSecretKey();
var_dump($key);


if (!is_string($key) || empty($key)) {
    throw new Exception('JWT secret key is not a valid string');
}
// Hàm tạo JWT
function createJWT($userId) {
    global $key;
    $issuedAt = time();
    $expirationTime = $issuedAt + (60 * 60); // Thời hạn 1 giờ

    $payload = [
        'iss' => 'localhost',
        'aud' => 'localhost',
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'userId' => $userId,
    ];

    return JWT::encode($payload, $key, 'HS256');
}

// Hàm xác thực JWT
function verifyJWT($jwt) {
    global $key;

    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        return null; // Token không hợp lệ hoặc đã hết hạn
    }
}
