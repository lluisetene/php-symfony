<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Animal;

use App\Form\AnimalType;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;

class AnimalController extends AbstractController
{

    public function validarEmail($email) {

        $validator = Validation::createValidator();
        $errores = $validator->validate($email, [
            new Email()
        ]);

        if(count($errores) != 0) {
            echo "El email no se ha validado correctamente";
        } else {
            echo "El email sí se ha validado correctamente";
        }
        var_dump($email);
        die();
    }

    public function crearAnimal(Request $request) {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();

            // Redireccionar a la misma web para resetear los campos
            return $this->redirectToRoute('crear_animal');
        }

        return $this->render('animal/crear-animal.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/animal", name="animal")
     */
    public function index()
    {

        // Sacar todos los animales de la tabla
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);

        // Saca todos los animales
        $animales = $animal_repo->findAll();

        // Sacar un animal a partir de una característica buscada
        $animalFind = $animal_repo->findOneBy([
            'tipo' => 'Avestruz'
        ]);

        // Sacar todos los animales que tengan la misma característica buscada
        $animalesFind = $animal_repo->findBy([
            'tipo' => 'Avestruz'
        ], [
            'id' => 'DESC' // para ordenar los resultados obtenidos
        ]);

        //var_dump($animalFind);
        //var_dump($animalesFind);

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales
        ]);
    }

    public function save() {
        // Guardar en una tabla de la base de datos

        // Cargo el EntityManager (em)
        $entityManager = $this->getDoctrine()->getManager();

        // Creo el objeto y le doy valores
        $animal = new Animal();

        $animal->setTipo('Avestruz');
        $animal->setColor('verde');
        $animal->setRaza('africana');

        // Guardar objeto en doctrine (persistir el objeto)
        $entityManager->persist($animal);

        // Guardar (volcar) en la tabla
        $entityManager->flush();

        return new Response("El animal guardado tiene el id: " . $animal->getId());
    }

    public function update($id) {
        // Cargar doctrine (ORM)
        $doctrine = $this->getDoctrine();

        // Cargar EntityManager (em)
        $em = $doctrine->getManager();

        // Cargar repo Animal
        $animal_repo = $em->getRepository(Animal::class);

        // Consulta -> Find para conseguir el objeto
        $animal = $animal_repo->find($id);

        // Comprobar si el objeto me llega
        if(!$animal) {
            $message = "El animal no existe en la bbdd";
        } else {
            // Asignar valores al objeto
            $animal->setTipo('Perro');
            $animal->setColor('rojo');
            $animal->setRaza('Pastor Belga');

            // Persistir en doctrine
            $em->persist($animal);

            // Guardar en la bd
            $em->flush();

            $message = 'Has actualizado el animal ' . $animal->getId();
        }

        // Respuesta
        return new Response($message);
    }

    public function delete(Animal $animal) {
        $em = $this->getDoctrine()->getManager();

        if($animal && is_object($animal)) {
            $em->remove($animal); // lo borra de local
            $em->flush();

            $message = "Animal borrado correctamente";
        } else {
            $message = 'El animal indicado no existe';
        }
        return new Response($message);
    }
}
