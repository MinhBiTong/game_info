<?php
    function encryptSecretKey($secretKey, $password) {
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted = openssl_encrypt($secretKey, 'aes-256-cbc', $password, 0, $iv);
        return base64_encode($iv . $encrypted);
    }
    # Ma hoa bi mat
    $originalKey = '';
    $encryptionPassword = '';
    echo $encryptedKey = encryptSecretKey($originalKey, $encryptionPassword);
?>