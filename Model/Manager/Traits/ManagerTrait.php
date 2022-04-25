<?php

namespace Model\Manager\Traits;

use Model\DB;
use PDO;

trait ManagerTrait {

    private ?PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }
}