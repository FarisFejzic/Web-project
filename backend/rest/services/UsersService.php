<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService {
    public function __construct()
    {
        parent::__construct(new UsersDao());
    }

    public function get_by_email($email) {
        return $this->dao->get_by_email($email);
    }

    public function create_user($user) {
        // Validate required fields
        if (empty($user['first_name']) || empty($user['last_name']) || 
            empty($user['email']) || empty($user['password'])) {
            throw new Exception("Missing required user fields");
        }
        
        // Check if email already exists
        $existing_user = $this->get_by_email($user['email']);
        if ($existing_user) {
            throw new Exception("User with this email already exists");
        }
        
        // Set default role if not provided
        if (!isset($user['role'])) {
            $user['role'] = 'user';
        }
        
        return $this->add($user);
    }

}