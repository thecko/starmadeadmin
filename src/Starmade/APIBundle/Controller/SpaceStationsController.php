<?php

namespace Starmade\APIBundle\Controller;

use Starmade\APIBundle\Model\SpaceStation;
use Starmade\APIBundle\Model\SpaceStationCollection;
use Starmade\APIBundle\Entity\StarmadeSpaceStationEntityBuilder;
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
 * Rest controller for ingame space stations
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class SpaceStationsController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\SpaceStationsManager
     */
    public function getSpaceStationsManager()
    {
        $builder = new StarmadeSpaceStationEntityBuilder();
        $manager = new StarmadeElasticsearchEntityRepository($builder);

        return $manager;
    }

    /**
     * List all space stations.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing space stations.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many space stations to return.")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getSpacestationsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $spaceStations = $this->getSpaceStationsManager()->findAll($start, $limit);
        $count = $this->getSpaceStationsManager()->count();
        
        return new SpaceStationCollection($spaceStations, $offset, $limit,$count);
    }

    /**
     * Get a single space station.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\SpaceStation",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the space station is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="spaceStation")
     *
     * @param Request $request the request object
     * @param int     $id      the space station id
     *
     * @return array
     *
     * @throws NotFoundHttpException when space station not exist
     */
    public function getSpacestationAction(Request $request, $id)
    {
        $spaceStation = $this->getSpaceStationsManager()->get($id);
        if (false === $spaceStation) {
            throw $this->createNotFoundException("Space station does not exist.");
        }

        $view = new View($spaceStation);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
