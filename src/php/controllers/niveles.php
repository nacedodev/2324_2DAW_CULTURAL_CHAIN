<?php

require_once '../php/models/mNiveles.php';
/**
 * Controlador para la gestión de niveles.
 */
class Niveles {

    /** @var mNivel Objeto para la manipulación de niveles. */
    public $objNiveles;
     /** @var string Página actual del controlador. */
    public $pagina;
    /** @var string Vista por defecto del controlador. */
    public $view;
    /**
     * Constructor del controlador de centros.
     */
    public function __construct() {
        $this->pagina = '';
        $this->objNiveles = new mNivel();
    }
/**
     * Lista los centros disponibles.
     *
     * @return array Datos de los centros.
     */

     public function listarNivelesReflexiones()
     {
         $this->view = 'nivelesReflexiones';
         return $this->objNiveles->listar(); // Obtener los niveles
     
         // Obtener la información de las reflexiones para cada nivel
        
     }
     

     public function listarNiveles() {
        $this->view = 'niveles';
        $niveles = $this->objNiveles->listar();
    
        foreach ($niveles as &$nivel) {
            try {
                $nivel['tieneReflexiones'] = $this->objNiveles->tieneReflexiones($nivel['id']);
            } catch (Exception $e) {
                // Manejar el error aquí o simplemente asignar false en caso de error
                $nivel['tieneReflexiones'] = false;
            }
        }
        return $niveles;

    }
    
    /**
     * Añade un nuevo centro.
     */
    public function aniadirNivel() {
        $this->view = 'aniadirNiveles';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombrepais']) && isset($_FILES['imagen']['tmp_name'])) {
                $nombrepais = $_POST['nombrepais'];
                $imagenTmp = $_FILES['imagen']['tmp_name'];
                $imagenBinaria = file_get_contents($imagenTmp);

                $this->objNiveles->aniadir($nombrepais, $imagenBinaria);

                header("Location: index.php?action=listarNiveles&controller=niveles");
            }
        }
    }

     /**
     * Borra un centro existente.
     */
    public function borrarNivel() {
        $this->view='borradoNiveles';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (isset($_GET['id'])) {
            $this->objNiveles->borrar($_GET['id']);
            header("Location: index.php?action=listarNiveles&controller=niveles&");
            }
        }
    }
    /**
     * Modifica un centro existente.
     */
    public function modificarNivel() {
        $this->view='modificarNiveles';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lógica para actualizar el centro en la base de datos
        if ($_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Se ha seleccionado un archivo
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $imagenBinaria = file_get_contents($imagenTmp);
        } else
        $imagenBinaria = 0;
        $this->objNiveles->modificar($_POST['id'], $_POST['nombrepais'],$imagenBinaria);
        header("Location: index.php?action=listarNiveles&controller=niveles");
    }

    }

}
