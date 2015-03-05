<?php

namespace Starmade\APIBundle\Controller;

use Starmade\APIBundle\Model\Shop;
use Starmade\APIBundle\Model\ShopCollection;
use Starmade\APIBundle\Entity\StarmadeShopEntityBuilder;
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
 * Rest controller for ingame shops
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class ShopsController extends FOSRestController {

    /**
     * return \Starmade\APIBundle\BlueprintsManager
     */
    public function getShopsManager() {
        $builder = new StarmadeShopEntityBuilder();
        $manager = new StarmadeElasticsearchEntityRepository($builder);

        return $manager;
    }

    /**
     * List all shops.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing shops.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many shops to return.")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getShopsAction(Request $request, ParamFetcherInterface $paramFetcher) {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $shops = $this->getShopsManager()->findAll($start, $limit);
        $count = $this->getShopsManager()->count();

        return new ShopCollection($shops, $offset, $limit,$count);
    }

    /**
     * Get a single shop.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Shop",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the shop is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="shop")
     *
     * @param Request $request the request object
     * @param int     $id      the shop id
     *
     * @return array
     *
     * @throws NotFoundHttpException when shop not exist
     */
    public function getShopAction(Request $request, $id) {
        $shop = $this->getShopsManager()->get($id);
        if (false === $shop) {
            throw $this->createNotFoundException("Shop does not exist.");
        }

        $view = new View($shop);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }

}
