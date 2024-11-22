<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class IdEncoder_2
{
    private static string $secretKey;
    private static string $encryptionKey;
    const CIPHER_METHOD = 'aes-256-cbc';

    public static function configure(string $secretKey, string $encryptionKey)
    {
        self::$secretKey = $secretKey;
        self::$encryptionKey = $encryptionKey;
    }

    public static function encode(int $id): string
    {
        try {
            // Tăng tính ngẫu nhiên
            $nonce = bin2hex(random_bytes(4));
            $timestamp = time();

            // Kết hợp thông tin
            $payload = json_encode([
                'id' => $id,
                'nonce' => $nonce,
                'timestamp' => $timestamp
            ]);

            // Mã hóa payload
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt(
                $payload,
                'aes-256-cbc',
                self::$encryptionKey,
                0,
                $iv
            );

            // Tạo chữ ký
            $signature = hash_hmac('sha256', $encrypted, self::$secretKey);

            // Kết hợp các thành phần
            $encodedData = base64_encode($iv . $encrypted . $signature);

            // Làm an toàn cho URL
            return strtr($encodedData, '+/', '-_');
        } catch (Exception $e) {
            throw new InvalidArgumentException('Mã hóa ID thất bại');
        }
    }

    public static function decode(string $encodedId, int $expirationTime = 3600): int
    {
        if (empty($encodedId)) {
            throw new InvalidArgumentException('Encoded ID không được để trống');
        }

        try {
            Log::info('Bắt đầu giải mã ID', ['encoded_id' => $encodedId]);

            // Giải mã Base64 và kiểm tra độ dài dữ liệu
            $decodedData = base64_decode(strtr($encodedId, '-_', '+/'));
            if ($decodedData === false || strlen($decodedData) < 64) {
                throw new InvalidArgumentException('Encoded ID không hợp lệ');
            }

            // Tách các thành phần từ dữ liệu
            $ivLength = openssl_cipher_iv_length(self::CIPHER_METHOD);
            $iv = substr($decodedData, 0, $ivLength);
            $encryptedData = substr($decodedData, $ivLength, -64);
            $signature = substr($decodedData, -64);

            // Xác minh chữ ký
            $computedSignature = hash_hmac('sha256', $encryptedData, self::$secretKey);
            if (!hash_equals($signature, $computedSignature)) {
                throw new InvalidArgumentException('Chữ ký không hợp lệ');
            }

            // Giải mã dữ liệu
            $decrypted = openssl_decrypt(
                $encryptedData,
                self::CIPHER_METHOD,
                self::$encryptionKey,
                0,
                $iv
            );
            if ($decrypted === false) {
                throw new InvalidArgumentException('Giải mã dữ liệu thất bại');
            }

            // Phân tích payload
            $payload = json_decode($decrypted, true);
            if (!is_array($payload) || !isset($payload['id'], $payload['timestamp'])) {
                throw new InvalidArgumentException('Cấu trúc payload không hợp lệ');
            }

            // Kiểm tra thời gian hết hạn
            if (time() - $payload['timestamp'] > $expirationTime) {
                throw new InvalidArgumentException('ID đã hết hạn');
            }

            // Ghi log thành công
            Log::info('Giải mã ID thành công', [
                'decoded_id' => $payload['id'],
                'timestamp' => $payload['timestamp']
            ]);

            return $payload['id'];
        } catch (Exception $e) {
            // Ghi log lỗi bảo mật
            Log::warning('Giải mã ID thất bại', [
                'error' => $e->getMessage(),
                'encoded_id' => $encodedId
            ]);
            throw new InvalidArgumentException('Giải mã ID thất bại');
        }
    }


    public static function isValid(string $encodedId): bool
    {
        try {
            self::decode($encodedId);
            return true;
        } catch (InvalidArgumentException) {
            return false;
        }
    }
}

// Cấu hình mặc định
IdEncoder_2::configure(
    env('ID_SECRET_KEY', 'default-secret-key'),
    env('ID_ENCRYPTION_KEY', 'default-encryption-key')
);
