<?php

namespace Starmade\APIBundle\Controller;

use Starmade\APIBundle\Model\Planet;
use Starmade\APIBundle\Model\PlanetCollection;
use Starmade\APIBundle\Entity\StarmadePlanetEntityBuilder;
use Starmade\APIBundle\Entity\StarmadeElasticsearchEntityRepository;

use FOS\RestBundle\Util\Codes;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\RouteRedirectView;

use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Rest controller for ingame planets
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class PlanetsController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\PlanetsManager
     */
    public function getPlanetsManager()
    {
        $builder = new StarmadePlanetEntityBuilder();
        $manager = new StarmadeElasticsearchEntityRepository($builder);
    
        return $manager;
    }

    /**
     * List all planets.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing planets.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many planets to return.")
     * @Annotations\QueryParam(name="field", default="", description="Field to search by")
     * @Annotations\QueryParam(name="term", default="", description="Value to search")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getPlanetsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');
        $field = $paramFetcher->get('field');
        $term = $paramFetcher->get('term');

        $planets = $this->getPlanetsManager()->findAllBy( $field , $term , $start, $limit );
        $count = $this->getPlanetsManager()->count();
        
        return new PlanetCollection($planets, $offset, $limit,$count);
    }

    /**
     * Get a single planet.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Planet",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the planet is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="planet")
     *
     * @param Request $request the request object
     * @param int     $id      the planet id
     *
     * @return array
     *
     * @throws NotFoundHttpException when planet not exist
     */
    public function getPlanetAction(Request $request, $id)
    {
        $planet = $this->getPlanetsManager()->get($id);
        if (false === $planet) {
            throw $this->createNotFoundException("Planet does not exist.");
        }

        $view = new View($planet);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
