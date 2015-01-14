<?php

namespace Starmade\APIBundle\Controller;

//use Acme\DemoBundle\Form\NoteType;
use Starmade\APIBundle\Model\Faction;
use Starmade\APIBundle\Model\FactionCollection;

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
 * Rest controller for server factions
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class FactionsController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\FactionsManager
     */
    public function getFactionsManager()
    {
        return $this->get('starmade.api.factions_manager');
    }

    /**
     * List all factions of the server
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing factions.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many factions to return.")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getFactionsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $factions = $this->getFactionsManager()->fetch($start, $limit);
        
        return new FactionCollection($factions, $offset, $limit);
    }

    /**
     * Get a single faction.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Faction",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the blueprint is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="faction")
     *
     * @param Request $request the request object
     * @param int     $id      the faction id
     *
     * @return array
     *
     * @throws NotFoundHttpException when faction not exist
     */
    public function getFactionAction(Request $request, $id)
    {
        $faction = $this->getFactionsManager()->get($id);
        if (false === $faction) {
            throw $this->createNotFoundException("Faction does not exist.");
        }

        $view = new View($faction);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
