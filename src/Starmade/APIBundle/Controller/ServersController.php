<?php

namespace Starmade\APIBundle\Controller;

//use Acme\DemoBundle\Form\NoteType;
use Starmade\APIBundle\Model\Server;
use Starmade\APIBundle\Model\ServerCollection;
use Starmade\APIBundle\Entity\StarmadeServerEntityBuilder;
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
 * Rest controller for servers status
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class ServersController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\ServersManager
     */
    public function getServersManager()
    {
        $builder = new StarmadeServerEntityBuilder();
        $manager = new StarmadeElasticsearchEntityRepository($builder);

        return $manager;
    }

    /**
     * List all servers
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing servers.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many servers to return.")
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
    public function getServersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');
        $field = $paramFetcher->get('field');
        $term = $paramFetcher->get('term');

        $servers = $this->getServersManager()->findAllBy( $field , $term , $start, $limit );
        $count = $this->getServersManager()->count();
        
        return new ServerCollection($servers, $offset, $limit, $count);
    }

    /**
     * Get a single faction.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Server",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the server is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="server")
     *
     * @param Request $request the request object
     * @param int     $id      the server id
     *
     * @return array
     *
     * @throws NotFoundHttpException when server not exist
     */
    public function getServerAction(Request $request, $id)
    {
        $server = $this->getServerManager()->get($id);
        if (false === $server) {
            throw $this->createNotFoundException("Server does not exist.");
        }

        $view = new View($server);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
