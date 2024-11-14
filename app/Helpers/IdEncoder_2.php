<?php

namespace App\Helpers;

class IdEncoder_2
{
    // Khóa mã hóa - nên lưu trong config hoặc .env
    private static string $key = 'your-secret-key-here';

    // Salt để tăng độ phức tạp - nên lưu trong config hoặc .env  
    private static string $salt = 'random-salt-string';

    // Độ dài chuỗi hash tối thiểu
    private static int $minHashLength = 12;

    /**
     * Mã hóa ID thành chuỗi hash không đoán được
     */
    public static function encode(int $id): string
    {
        // Thêm salt và timestamp để tránh các hash giống nhau
        $timestamp = time();
        $data = $id . self::$salt . $timestamp;

        // Tạo HMAC để đảm bảo tính toàn vẹn
        $hmac = hash_hmac('sha256', $data, self::$key);

        // Kết hợp các thành phần và mã hóa base64
        $combined = $id . '|' . $timestamp . '|' . $hmac;
        $encoded = base64_encode($combined);

        // Thay thế các ký tự đặc biệt để sử dụng an toàn trên URL
        return strtr($encoded, '+/', '-_');
    }

    /**
     * Giải mã chuỗi hash để lấy ID gốc
     * @throws \InvalidArgumentException
     */
    public static function decode(string $hash): int
    {
        try {
            // Khôi phục các ký tự đặc biệt từ URL safe
            $hash = strtr($hash, '-_', '+/');

            // Giải mã base64
            $decoded = base64_decode($hash);

            // Tách các thành phần
            [$id, $timestamp, $hmac] = explode('|', $decoded);

            // Xác thực HMAC
            $data = $id . self::$salt . $timestamp;
            $expectedHmac = hash_hmac('sha256', $data, self::$key);

            if (!hash_equals($expectedHmac, $hmac)) {
                throw new \InvalidArgumentException('Invalid hash');
            }

            return (int) $id;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid hash format');
        }
    }

    /**
     * Kiểm tra tính hợp lệ của hash
     */
    public static function isValid(string $hash): bool
    {
        try {
            self::decode($hash);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
