<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class OrderController
{
    private const VALID_STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    // Mask mobile money number for privacy
    private function mask(array $order): array
    {
        if (!empty($order['mobile_money_number'])) {
            $order['mobile_money_number'] = '******' . substr($order['mobile_money_number'], -4);
        }
        return $order;
    }

    // Attach order_items to an order row
    private function withItems(array $order): array
    {
        $order['items'] = DB::fetchAll(
            'SELECT * FROM order_items WHERE order_id = ?',
            'i', [$order['id']]
        );
        return $order;
    }

    // ── GET /api/orders  (admin) ─────────────────────────────────────────────
    // ?page=1 &limit=10 &status=pending
    public function index(): void
    {
        [$page, $limit, $offset] = getPagination(10);

        $where  = [];
        $types  = '';
        $values = [];

        if ($status = qStr('status')) {
            if (!in_array($status, self::VALID_STATUSES)) {
                Response::error('Invalid status filter', 400);
            }
            $where[] = 'status = ?'; $types .= 's'; $values[] = $status;
        }

        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $total    = DB::count('orders', ltrim($whereSQL, 'WHERE '), $types, $values);

        $rows = DB::fetchAll(
            "SELECT * FROM orders $whereSQL ORDER BY id DESC LIMIT ? OFFSET ?",
            $types . 'ii',
            array_merge($values, [$limit, $offset])
        );

        $orders = array_map(fn($o) => $this->withItems($this->mask($o)), $rows);

        Response::paginated($orders, $total, $page, $limit, 'orders');
    }

    // ── GET /api/orders/user?user_id=5  (auth) ───────────────────────────────
    // Token user can only see their own orders. Admin can see any.
    public function userOrders(array $authUser): void
    {
        $userId = qInt('user_id');
        if (!$userId) Response::error('user_id is required', 400);

        if ($authUser['role'] !== 'admin' && $authUser['id'] !== $userId) {
            Response::error('Forbidden', 403);
        }

        [$page, $limit, $offset] = getPagination(10);
        $total  = DB::fetchOne('SELECT COUNT(*) as c FROM orders WHERE user_id = ?', 'i', [$userId])['c'];
        $rows   = DB::fetchAll(
            'SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT ? OFFSET ?',
            'iii', [$userId, $limit, $offset]
        );

        Response::paginated(array_map(fn($o) => $this->withItems($this->mask($o)), $rows), $total, $page, $limit, 'orders');
    }

    // ── POST /api/orders  (auth) ─────────────────────────────────────────────
    // Body: { fullName, phoneNumber, email, country, province, district,
    //         sector, nearbyLandmark, paymentMethod, mobileMoneyNumber,
    //         orderItems: [{ productId, productName, priceCents, quantity,
    //                        selectedColor, selectedSize, imageUrl }] }
    public function store(array $authUser): void
    {
        $d      = jsonBody();
        $userId = $authUser['id']; // always from verified token — never body

        $fullName      = (string) ($d['fullName']          ?? '');
        $phone         = (string) ($d['phoneNumber']       ?? '');
        $email         = (string) ($d['email']             ?? '');
        $country       = (string) ($d['country']           ?? '');
        $province      = (string) ($d['province']          ?? '');
        $district      = (string) ($d['district']          ?? '');
        $sector        = (string) ($d['sector']            ?? '');
        $landmark      = (string) ($d['nearbyLandmark']    ?? '');
        $paymentMethod = (string) ($d['paymentMethod']     ?? '');
        $mobileNumber  = (string) ($d['mobileMoneyNumber'] ?? '');
        $items         = $d['orderItems'] ?? [];

        if (empty($items)) Response::error('orderItems cannot be empty', 400);

        $total = array_reduce($items, fn($carry, $item) =>
            $carry + (($item['priceCents'] ?? 0) * ($item['quantity'] ?? 1)), 0);

        $orderId = DB::insert(
            'INSERT INTO orders
                (user_id, full_name, phone_number, email, country, province,
                 district, sector, nearby_landmark, payment_method,
                 mobile_money_number, orderTotalAmount, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'issssssssssis',
            [$userId, $fullName, $phone, $email, $country, $province,
             $district, $sector, $landmark, $paymentMethod, $mobileNumber, $total, 'pending']
        );

        foreach ($items as $item) {
            $itemTotal = ($item['priceCents'] ?? 0) * ($item['quantity'] ?? 1);
            DB::insert(
                'INSERT INTO order_items
                    (order_id, product_id, product_name, price_cents, quantity,
                     selected_color, selected_size, image_url, productTotalAmount)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                'iisissisi',
                [$orderId, $item['productId'] ?? null, $item['productName'] ?? '',
                 $item['priceCents'] ?? 0, $item['quantity'] ?? 1,
                 $item['selectedColor'] ?? '', $item['selectedSize'] ?? '',
                 $item['imageUrl'] ?? '', $itemTotal]
            );
        }

        Response::success(['orderId' => $orderId], 'Order placed successfully');
    }

    // ── PUT /api/orders?id=1  (admin) ────────────────────────────────────────
    // Body: { status }
    public function updateStatus(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        $status = trim(jsonBody()['status'] ?? '');

        if (!in_array($status, self::VALID_STATUSES))
            Response::error('Invalid status. Allowed: ' . implode(', ', self::VALID_STATUSES), 400);

        $current = DB::fetchOne('SELECT status FROM orders WHERE id = ?', 'i', [$id]);
        if (!$current) Response::error('Order not found', 404);

        if ($current['status'] === $status)
            Response::success(null, 'Nothing to update, status is already ' . $status);

        DB::execute('UPDATE orders SET status = ? WHERE id = ?', 'si', [$status, $id]);
        Response::success(null, 'Order status updated');
    }

    // ── DELETE /api/orders?id=1  (admin) ─────────────────────────────────────
    public function destroy(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        if (!DB::fetchOne('SELECT id FROM orders WHERE id = ?', 'i', [$id]))
            Response::error('Order not found', 404);

        DB::execute('DELETE FROM orders WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Order deleted');
    }
}
