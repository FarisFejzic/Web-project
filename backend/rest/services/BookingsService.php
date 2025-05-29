<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookingsDao.php';

class BookingsService extends BaseService {
    public function __construct()
    {
        parent::__construct(new BookingsDao());
    }

    public function get_by_user_id($user_id) {
        return $this->dao->get_by_user_id($user_id);
    }

    public function get_by_package_id($package_id) {
        return $this->dao->get_by_package_id($package_id);
    }

    public function create_booking($booking) {
        
        if (empty($booking['user_id']) || empty($booking['package_id']) || empty($booking['travel_date'])) {
            throw new Exception("Missing required booking fields");
        }
        
        return $this->add($booking);
    }

    public function update_booking_status($id, $status) {
        $valid_statuses = ['pending', 'confirmed', 'cancelled'];
        if (!in_array($status, $valid_statuses)) {
            throw new Exception("Invalid booking status");
        }
        
        return $this->update(['status' => $status], $id);
    }
}