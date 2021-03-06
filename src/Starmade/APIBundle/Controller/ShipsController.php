<?php

namespace Starmade\APIBundle\Controller;

use Starmade\APIBundle\Model\Ship;
use Starmade\APIBundle\Model\ShipCollection;
use Starmade\APIBundle\Entity\StarmadeShipEntityBuilder;
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
 * Rest controller for ingame ships
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class ShipsController extends FOSRestController {

  /**
   * return \Starmade\APIBundle\BlueprintsManager
   */
  public function getShipsManager() {
    $builder = new StarmadeShipEntityBuilder();
    $manager = new StarmadeElasticsearchEntityRepository($builder);
    
    return $manager;
  }

  /**
   * List all ships.
   *
   * @ApiDoc(
   *   resource = true,
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing ships.")
   * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many ships to return.")
   * @Annotations\QueryParam(name="field", default="", description="Field to search by")
   * @Annotations\QueryParam(name="term", default="", description="Value to search")
   * @Annotations\QueryParam(name="order", default="", description="Field to order by")
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getShipsAction(Request $request, ParamFetcherInterface $paramFetcher) {
    $offset = $paramFetcher->get('offset');
    $start = null == $offset ? 0 : $offset + 1;
    $limit = $paramFetcher->get('limit');
    $field = $paramFetcher->get('field');
    $term = $paramFetcher->get('term');
    $order = $paramFetcher->get('order');

    $resultset = $this->getShipsManager()->findAllBy( $field , $term , $start, $limit , $order );
    
    $data = $resultset->data();
    $count = $resultset->count();
    
    return new ShipCollection($data, $offset, $limit, $count);
  }

  /**
   * Get a single ship.
   *
   * @ApiDoc(
   *   output = "Starmade\APIBundle\Model\Ship",
   *   statusCodes = {
   *     200 = "Returned when successful",
   *     404 = "Returned when the ship is not found"
   *   }
   * )
   *
   * @Annotations\View(templateVar="ship")
   *
   * @param Request $request the request object
   * @param int     $id      the ship id
   *
   * @return array
   *
   * @throws NotFoundHttpException when ship not exist
   */
  public function getShipAction(Request $request, $id) {
    $ship = $this->getShipsManager()->findById($id);
    if (false === $ship) {
      throw $this->createNotFoundException("Ship does not exist.");
    }

    $view = new View($ship);
    $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
    $view->getSerializationContext()->setGroups(array('Default', $group));

    return $view;
  }

}
