<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
require_once __DIR__ . '/../../Data/Roles.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;
    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao);
    }

    public function register($entity) {   
        if (empty($entity['email']) || empty($entity['password']) || empty($entity['first_name']) || empty($entity['last_name'])) {
        return ['success' => false, 'error' => 'All fields are required.'];
    }

        $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
        if($email_exists){
            return ['success' => false, 'error' => 'Email already registered.'];
        }

        $user_data = [
        'first_name' => $entity['first_name'],
        'last_name' => $entity['last_name'],
        'email' => $entity['email'],
        'password' => password_hash($entity['password'], PASSWORD_BCRYPT),
        'role' => Roles::USER
    ];
        $entity = parent::add($user_data);

        unset($entity['password']);

        return ['success' => true, 'data' => $entity];              
    }

    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }

    

    public function login($entity) {   
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);
        

        if(!$user || !password_verify($entity['password'], $user['password']))
            return ['success' => false, 'error' => 'Invalid username or password.'];

        unset($user['password']);
        
        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24), 
            'role' => $user['role']
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];              
    }
}