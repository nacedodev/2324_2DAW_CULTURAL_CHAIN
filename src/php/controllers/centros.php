<?php

require_once '../php/models/mCentros.php';
/**
 * Controlador para la gestión de centros.
 */
class Centros {

    /** @var mCentro Objeto para la manipulación de centros. */
    public $objCentros;
     /** @var string Página actual del controlador. */
    public $pagina;
    /** @var string Vista por defecto del controlador. */
    public $view;
    /**
     * Constructor del controlador de centros.
     */
    public function __construct() {
        $this->pagina = '';
        $this->objCentros = new mCentro(HOST,USER,PASSWORD,DATABASE, CHARSET);
    }
/**
     * Lista los centros disponibles.
     *
     * @return array Datos de los centros.
     */
    public function listarCentros(): array
    {
        $this->view='centros';
        return $this->objCentros->listar();
    }
    /**
     * Añade un nuevo centro.
     */
    public function aniadirCentro() {
        $this->view='aniadirCentros';
        if (isset($_POST['nombre']) && isset($_POST['localidad']) && !empty($_POST['nombre']) && !empty($_POST['localidad'])) {
            // Llamar a la función aniadir solo si las variables están presentes y no son vacías
             $this->objCentros->aniadir($_POST['nombre'], $_POST['localidad']);
             header("Location: index.php?action=listarCentros&controller=centros");
         }
    }
     /**
     * Borra un centro existente.
     */
    public function borrarCentro() {
        $this->view='borradoCentros';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (isset($_GET['id'])) {
            $this->objCentros->borrar($_GET['id']);
            header("Location: index.php?action=listarCentros&controller=centros");
            }
        }
    }
    /**
     * Modifica un centro existente.
     */
    public function modificarCentro() {
        $this->view='modificarCentros';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lógica para actualizar el centro en la base de datos
        $this->objCentros->modificar($_POST['id'], $_POST['nombre'], $_POST['localidad']);
        header("Location: index.php?action=listarCentros&controller=centros");
    }

    }

}
