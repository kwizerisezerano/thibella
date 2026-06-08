<?php

class Response
{
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function success($data = null, string $message = 'Success', int $status = 200): void
    {
        $payload = ['success' => true, 'message' => $message];
        if ($data !== null) $payload['data'] = $data;
        self::json($payload, $status);
    }

    public static function error(string $message, int $status = 400): void
    {
        self::json(['success' => false, 'message' => $message], $status);
    }

    /**
     * Paginated list response — used by products, orders
     */
    public static function paginated(
        array  $items,
        int    $total,
        int    $page,
        int    $limit,
        string $itemsKey = 'data'
    ): void {
        self::json([
            'success'    => true,
            'pagination' => [
                'page'        => $page,
                'limit'       => $limit,
                'total'       => $total,
                'total_pages' => (int) ceil($total / max($limit, 1)),
            ],
            $itemsKey => $items,
        ]);
    }
}
