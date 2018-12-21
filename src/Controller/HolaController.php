<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HolaController extends AbstractController
{
    /**
     * @Route("/hola", name="hola")
     */
    public function index()
    {
        return $this->render('hola/index.html.twig', [
            'controller_name' => 'HolaController',
            'hello' => 'Hola Mundo con Symfony 4',
        ]);
    }

    public function animales($nombre, $apellidos) {
        $title = "Bienvenido a la página de animales";


        return $this->render('hola/animales.html.twig', [
            'title' => $title,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
        ]);
    }


    public function redirigir() {
        #return $this->redirectToRoute('index', array(), 301);
        /*return $this->redirectToRoute('animales', [
            'nombre' => 'Juan Pedro',
            'apellidos' => 'De todos los Santos'
        ])*/;
        #return $this->redirect('https://www.as.com');
    }
}
