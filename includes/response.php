<?php

declare(strict_types=1);

class Response
{
    public static $STATUS_SUCCESS = 200;
    public static $STATUS_SERVER_ERROR = 500;
    public static $STATUS_FORBIDDEN = 403;
    public static $STATUS_UNAUTHORIZED_ERROR = 401;
    public static $STATUS_NOT_FOUND = 404;

    private static function create_response(bool $success, int $status_code, string $message, array $other_params): array
    {
        return [
            'success' => $success,
            'status_code' => $status_code,
            'message' => $message,
            ...$other_params
        ];
    }
    public static function success(string $message = '', $other_params = []): array
    {
        return self::create_response(true, self::$STATUS_SUCCESS, $message, $other_params);
    }

    public static function failed(string $message = 'Something went wrong, Please try again later!',int $status_code=500,$other_params = []): array
    {
        return self::create_response(false,$status_code,$message,$other_params);
    }
}
