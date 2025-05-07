<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PaymentsDao.php';

class PaymentsService extends BaseService {
    public function __construct()
    {
        parent::__construct(new PaymentsDao());
    }

    public function get_by_status($status) {
        return $this->dao->get_by_status($status);
    }

    public function create_payment($payment) {
        // Validate required fields
        if (empty($payment['booking_id']) || empty($payment['amount']) || 
            empty($payment['payment_method'])) {
            throw new Exception("Missing required payment fields");
        }
        
        // Set default status if not provided
        if (!isset($payment['status'])) {
            $payment['status'] = 'pending';
        }
        
        return $this->add($payment);
    }

    public function update_payment_status($id, $status) {
        $valid_statuses = ['pending', 'completed', 'failed'];
        if (!in_array($status, $valid_statuses)) {
            throw new Exception("Invalid payment status");
        }
        
        return $this->update(['status' => $status], $id);
    }
}