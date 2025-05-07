<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PackagesDao.php';

class PackagesService extends BaseService {
    public function __construct()
    {
        parent::__construct(new PackagesDao());
    }

    public function get_by_destination($destination) {
        return $this->dao->get_by_destination($destination);
    }

    public function get_available_packages() {
        return $this->dao->get_available_packages();
    }

    public function create_package($package) {
        // Validation
        if (empty($package['title']) || empty($package['destination']) || 
            empty($package['duration_days']) || empty($package['price'])) {
            throw new Exception("Missing required package fields");
        }
        
        // Set default status 
        if (!isset($package['status'])) {
            $package['status'] = 'active';
        }
        
        return $this->add($package);
    }

    public function toggle_package_status($id, $status) {
        $valid_statuses = ['active', 'inactive'];
        if (!in_array($status, $valid_statuses)) {
            throw new Exception("Invalid package status");
        }
        
        return $this->update(['status' => $status], $id);
    }
}