<?php
class menu {
    private $dbh;
    private $menuItems;
    
    public function __construct() {
        $this->connectToDatabase();
        $this->loadMenuItems();
    }
    
    private function connectToDatabase() {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=feltalalokdb', 'feltalalokdb', 'UvegPohar111',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $this->dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        } catch (PDOException $e) {
            die("Hiba: " . $e->getMessage());
        }
    }
    
    private function loadMenuItems() {
        $sql = "SELECT * FROM menu";
        $sth = $this->dbh->query($sql);
        $this->menuItems = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buildMenu($parentId = null) {
        $html = '';
        $items = $this->getChildItems($parentId);
        
        if (!empty($items)) {
            $html .= '<ul>';
            foreach ($items as $item) {
                $html .= $this->createMenuItem($item);
            }
            $html .= '</ul>';
        }
        return $html;
    }
    
    private function getChildItems($parentId) {
        return array_filter($this->menuItems, function($item) use ($parentId) {
            return $item['szulo_id'] == $parentId;
        });
    }
    
    private function hasChildren($itemId) {
        return !empty($this->getChildItems($itemId));
    }
    
    private function createMenuItem($item) {
        $html = '<li>';
        
        if ($this->hasChildren($item['id'])) {
            $html .= '<span class="opener">' . htmlspecialchars($item['nev']) . '</span>';
            $html .= $this->buildMenu($item['id']);
        } else {
            $link = !empty($item['url']) ? $item['url'] : '#';
            $html .= '<a href="' . htmlspecialchars($link) . '">' . 
                     htmlspecialchars($item['nev']) . '</a>';
        }
        
        $html .= '</li>';
        return $html;
    }
}