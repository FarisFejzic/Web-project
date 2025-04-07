<?php

require_once __DIR__ . '/BaseDao.php';

class PaymentsDao extends BaseDao {

    protected $table_name;

    public function __construct(){
        $this->table_name = "payments";
        parent::__construct($this->table_name);
    }
    public function get_all()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_by_id($id)
    {
        return $this->query_unique('SELECT * FROM ' . $this->table_name . ' WHERE id=:id', ['id' => $id]);
    }

    public function get_by_status($status)
    {
        $status = strtolower($status);
        $valid_statuses = ['pending', 'completed', 'failed'];
        if (!in_array($status, $valid_statuses)) {
            throw new InvalidArgumentException('Invalid payment status');
        }
        return $this->query( 'SELECT * FROM ' . $this->table_name . ' WHERE status=:status',['status' => $status]);

    }


}    