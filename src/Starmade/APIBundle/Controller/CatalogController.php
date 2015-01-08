<?php

namespace Starmade\APIBundle\Controller;

//use Acme\DemoBundle\Form\NoteType;
use Starmade\APIBundle\Model\Blueprint;
use Starmade\APIBundle\Model\BlueprintCollection;

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
 * Rest controller for blueprint catalog
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class CatalogController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\CatalogManager
     */
    public function getCatalogManager()
    {
        return $this->get('starmade.api.catalog_manager');
    }

    /**
     * List all blueprints in the catalog.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing blueprints.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many blueprints to return.")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCatalogAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $blueprints = $this->getCatalogManager()->fetch($start, $limit);

        return new BlueprintCollection($blueprints, $offset, $limit);
    }

    /**
     * Get a single blueprint.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Blueprint",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the blueprint is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="blueprint")
     *
     * @param Request $request the request object
     * @param int     $id      the blueprint id
     *
     * @return array
     *
     * @throws NotFoundHttpException when blueprint not exist
     */
    public function getBlueprintAction(Request $request, $id)
    {
        $blueprint = $this->getCatalogManager()->get($id);
        if (false === $blueprint) {
            throw $this->createNotFoundException("Blueprint does not exist.");
        }

        $view = new View($blueprint);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
