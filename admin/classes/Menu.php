<?php

class Menu
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function read($role_id)
    {

        $query = "SELECT
                    men.direktori as dir_menu,
                    sub.direktori as dir_submenu,
                    men.*,
                    sub.*,
                    ha.*
                FROM
                    menu men
                LEFT JOIN submenu sub ON
                    men.menu_id = sub.menu_id
                LEFT JOIN hak_akses ha ON
                    men.menu_id = ha.menu_id
                WHERE 
                    ha.role_id = :role_id
                ORDER BY
                    men.menu_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();

        $menu = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (is_null($row['submenu_id'])) {
                $menu[$row['menu_id']]['nama_menu'] = $row['nama_menu'];
                $menu[$row['menu_id']]['direktori'] = $row['dir_menu'];
                $menu[$row['menu_id']]['icon'] = $row['icon'];
            } else {
                $menu[$row['menu_id']]['nama_menu'] = $row['nama_menu'];
                $menu[$row['menu_id']]['icon'] = $row['icon'];
                $menu[$row['menu_id']]['submenu'][] = [
                    'nama_submenu' => $row['nama_submenu'],
                    'direktori' => $row['dir_submenu'],
                ];
            }
        }

        return $menu;
    }
}
