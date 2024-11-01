<?php

namespace App\Helpers;

class IdEncoder
{
    private static $key = 'your-secret-key';

    public static function encode($id)
    {
        return base64_encode($id . '::' . self::$key);
    }

    public static function decode($encodedId)
{
    $decoded = base64_decode($encodedId);
    $parts = explode('::', $decoded);

    // Kiểm tra xem có đúng 2 phần tử không
    if (count($parts) !== 2) {
        abort(404); // Chuyển hướng đến trang 404 nếu không băm được
    }

    list($id, $key) = $parts;

    // Kiểm tra khóa
    if ($key !== self::$key) {
        abort(403, 'Unauthorized access.');
    }

    return $id;
}

}
