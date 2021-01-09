<?php


namespace App\Controller;


use App\Form\SearchForm;
use App\Service\ElasticResult;
use App\Service\ElasticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @var ElasticService
     */
    private $elasticService;

    public function __construct(ElasticService $elasticService)
    {
        $this->elasticService = $elasticService;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $result = $this->elasticService->search($data['searchTerm']);

            return new JsonResponse($result);
        }

        return $this->render('autocomplete.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/autocomplete/", name="auto-complete")
     * @param Request $request
     * @return Response
     */
    public function autoComplete(Request $request): Response
    {
        $term = $request->query->get('term');

        $form = $this->createForm(SearchForm::class);

        $form->submit(['searchTerm' => $term]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $result = $this->elasticService->fuzzinessAutoComplete($data['searchTerm']);

            return new JsonResponse(ElasticResult::buildResults($result));
        }

        return $this->render('autocomplete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
