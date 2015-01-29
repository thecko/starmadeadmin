<?php

namespace Starmade\APIBundle\Controller;

use Starmade\APIBundle\Model\Player;
use Starmade\APIBundle\Model\PlayerCollection;
use Starmade\APIBundle\Model\Sector;

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
 * Rest controller for players
 *
 * @package Starmade\APIBundle\Controller
 * @author Theck <jumptard.theck@gmail.com>
 */
class PlayersController extends FOSRestController
{
    /**
     * return \Starmade\APIBundle\BlueprintsManager
     */
    public function getPlayersManager()
    {
        return $this->get('starmade.api.players_manager');
    }

    /**
     * List all players.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing players.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many players to return.")
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getPlayersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $players = $this->getPlayersManager()->fetch($start, $limit);
        
        return new PlayerCollection($players, $offset, $limit);
    }

    /**
     * Get a single player.
     *
     * @ApiDoc(
     *   output = "Starmade\APIBundle\Model\Player",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the player is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="player")
     *
     * @param Request $request the request object
     * @param int     $id      the shop id
     *
     * @return array
     *
     * @throws NotFoundHttpException when shop not exist
     */
    public function getPlayerAction(Request $request, $id)
    {
        $player = $this->getPlayersManager()->get($id);
        if (false === $player) {
            throw $this->createNotFoundException("Player does not exist.");
        }

        $view = new View($player);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }
}
