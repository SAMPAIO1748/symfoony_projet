<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMediaController extends AbstractController
{

    /**
     * @Route("admin/medias/", name="admin_list_media")
     */
    public function listMedia(MediaRepository $mediaRepository)
    {
        $medias = $mediaRepository->findAll();

        return $this->render('admin/medias.html.twig', ['medias' => $medias]);
    }

    /**
     * @Route("admin/media/{id}", name="admin_show_media")
     */
    public function showMedia($id, MediaRepository $mediaRepository)
    {
        $media = $mediaRepository->find($id);

        return $this->render('admin/media.html.twig', ['media' => $media]);
    }


    /**
     * @Route("admin/create/media", name="admin_create_media")
     */
    public function createMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $media = new Media();

        $mediaForm = $this->createForm(MediaType::class, $media);

        $mediaForm->handleRequest($request);

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {

            $mediaFile = $mediaForm->get('src')->getData();

            if ($mediaFile) {
                // On créé un nom unique avec le nom original de l'image pour éviter
                // tout problème
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on utilise slug sur le nom original de l'image pour avoir un nom valide
                $safeFilename = $sluggerInterface->slug($originalFilename);
                // on ajoute un id unique au nom de l'image
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();


                // On déplace le fichier dans le dossier public/media
                // la destination du fichier est enregistré dans 'images_directory'
                // qui est défini dans le fichier config\services.yaml
                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }

            $media->setAlt($mediaForm->get('title')->getData());

            $entityManagerInterface->persist($media);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }

        return $this->render('admin/mediaform.html.twig', ['mediaForm' => $mediaForm->createView()]);
    }

    /**
     * @Route("admin/update/media/{id}", name="admin_update_media")
     */
    public function updateMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface,
        $id,
        MediaRepository $mediaRepository
    ) {

        $media = $mediaRepository->find($id);

        $mediaForm = $this->createForm(MediaType::class, $media);

        $mediaForm->handleRequest($request);

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {

            $mediaFile = $mediaForm->get('src')->getData();

            if ($mediaFile) {
                // On créé un nom unique avec le nom original de l'image pour éviter
                // tout problème
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on utilise slug sur le nom original de l'image pour avoir un nom valide
                $safeFilename = $sluggerInterface->slug($originalFilename);
                // on ajoute un id unique au nom de l'image
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();


                // On déplace le fichier dans le dossier public/media
                // la destination du fichier est enregistré dans 'images_directory'
                // qui est défini dans le fichier config\services.yaml
                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }

            $media->setAlt($mediaForm->get('title')->getData());

            $entityManagerInterface->persist($media);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }

        return $this->render('admin/mediaform.html.twig', ['mediaForm' => $mediaForm->createView()]);
    }
}
