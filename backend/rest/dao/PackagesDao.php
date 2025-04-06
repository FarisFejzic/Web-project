<?php

require_once __DIR__ . '/BaseDao.php';

class PackagesDao extends BaseDao {

    protected $table_name;

    public function __construct(){
        $this->table_name = "tour_packages";
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

    public function get_by_destination($destination)
    {
        return $this->query( 'SELECT * FROM ' . $this->table_name . ' WHERE LOWER(destination) LIKE LOWER(:destination)', 
        ['destination' => '%' . $destination . '%']);   
    }

    public function get_available_packages()
    {
        return $this->query( 'SELECT * FROM ' . $this->table_name . ' WHERE status = :status',
        [':status' => 'active'] );
    }
    

}    