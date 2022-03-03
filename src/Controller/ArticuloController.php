<?php

namespace App\Controller;

use App\Entity\Articulo;
use App\Form\ArticuloType;
use App\Repository\ArticuloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articulo')]
class ArticuloController extends AbstractController
{
    #[Route('/', name: 'articulo_index', methods: ['GET'])]
    public function index(ArticuloRepository $articuloRepository): Response
    {
        return $this->render('articulo/index.html.twig', [
            'articulos' => $articuloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'articulo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articulo = new Articulo();
        $form = $this->createForm(ArticuloType::class, $articulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($articulo);
            $entityManager->flush();

            return $this->redirectToRoute('articulo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articulo/new.html.twig', [
            'articulo' => $articulo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'articulo_show', methods: ['GET'])]
    public function show(Articulo $articulo): Response
    {
        return $this->render('articulo/show.html.twig', [
            'articulo' => $articulo,
        ]);
    }

    #[Route('/{id}/edit', name: 'articulo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articulo $articulo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticuloType::class, $articulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('articulo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articulo/edit.html.twig', [
            'articulo' => $articulo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'articulo_delete', methods: ['POST'])]
    public function delete(Request $request, Articulo $articulo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articulo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($articulo);
            $entityManager->flush();
        }
        $this->addFlash("success", "Artículo borrado correctamente");
        return $this->redirectToRoute('articulo_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/categoria/{cat}", name="categoria")
     */
    public function categorias(ArticuloRepository $articuloRepository, String $cat): Response
    {
        return $this->render('articulo/index.html.twig', [
            'articulos' => $articuloRepository->findBy(["categoria" => $cat]),
        ]);
    }
}
