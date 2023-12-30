<?php
namespace MVC\models;

use MVC\core\model;

class shop extends model {
    // ...
    public function search($searchTerm, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $searchPattern = '%' . $searchTerm . '%';
        $query = "SELECT id, brand, name, description, img, price FROM product WHERE name LIKE ? LIMIT $perPage OFFSET $offset";
        $data = $this->db()->run($query, [$searchPattern])->fetchAll();

        return $data;
    }




    public function getTotalResultsCount($searchTerm) {
        $searchPattern = '%' . $searchTerm . '%';
        $query = "SELECT COUNT(*) as total_count FROM product WHERE name LIKE ?";
        $result = $this->db()->run($query, [$searchPattern])->fetch();

        return ($result !== false) ? $result['total_count'] : 0;
    }

    public function search_by_higher($searchTerm)
    {
        $searchPattern = '%' . $searchTerm . '%';
        $data = model::db()->run("SELECT brand, name, description, img, price FROM product WHERE name LIKE ? ORDER BY price DESC", [$searchPattern])->fetchAll();
        return $data;
    }
    public function search_by_lower($searchTerm)
    {
        $searchPattern = '%' . $searchTerm . '%';
        $data = model::db()->run("SELECT brand, name, description, img, price FROM product WHERE name LIKE ? ORDER BY price ASC", [$searchPattern])->fetchAll();
        return $data;
    }
    public function search_latest()
    {
        $data = model::db()->run("SELECT brand, name, description, img, price FROM product ORDER BY created_at DESC")->fetchAll();
        return $data;
    }





}