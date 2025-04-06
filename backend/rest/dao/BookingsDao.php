<?php

require_once __DIR__ . '/BaseDao.php';

class BookingsDao extends BaseDao {

    protected $table_name;

    public function __construct(){
        $this->table_name = "bookings";
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
    public function get_by_user_id($user_id)
    {
    return $this->query( 'SELECT * FROM ' . $this->table_name . ' WHERE user_id=:user_id', ['user_id' => $user_id]);
    }

    public function get_by_package_id($package_id)
    {
    return $this->query('SELECT * FROM ' . $this->table_name . ' WHERE package_id=:package_id',  ['package_id' => $package_id]);
    }

}    