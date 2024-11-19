<?php

class AbmMenu {

    public function __construct(){

    }

    public function obtenerMenu()
    {
        $objMenu = new Menu();
        $resultado = [];
        try {
            $resultado = $objMenu->ordenMenu();
        } catch (PDOException $e) {
            throw new PDOException('Error: ' . $e->getMessage());
        }
        return $resultado; 
    }

}