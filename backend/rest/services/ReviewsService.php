<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewsDao.php';

class ReviewsService extends BaseService {
    public function __construct()
    {
        parent::__construct(new ReviewsDao());
    }

    public function get_reviews_by_package_id($package_id) {
        return $this->dao->get_reviews_by_package_id($package_id);
    }

    public function get_reviews_by_user_id($user_id) {
        return $this->dao->get_reviews_by_user_id($user_id);
    }

    public function create_review($review) {
        // Validate required fields
        if (empty($review['user_id']) || empty($review['package_id']) || 
            empty($review['rating'])) {
            throw new Exception("Missing required review fields");
        }
        
        // Validate  range
        if ($review['rating'] < 1 || $review['rating'] > 5) {
            throw new Exception("Rating must be between 1 and 5");
        }
        
        return $this->add($review);
    }
}