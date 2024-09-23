<?php

namespace App\Controller;

use App\Form\Type\VideoType;
use App\Service\OpenAIChatService;
use App\Service\VideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly OpenAIChatService $openAIChatService,
        private readonly VideoService $videoService
    ) {}

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {

        $form = $this
            ->createForm(VideoType::class)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //\dd($data);
            $this->openAIChatService->createVideo($form->getData());
           
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/index.html.twig', [ 
            'form' => $form->createView(),
            'videos' => $this->videoService->findAllVideos()
        ]);
    }
}
