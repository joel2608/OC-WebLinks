<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;

class ApiController {

    /**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */
    public function getLinksAction(Application $app) {
        $links = $app['dao.link']->findAll();
        // Convert an array of objects ($links) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($links as $link) {
            $responseData[] = array(
                'link_id' => $link->getId(),
                'link_title' => $link->getTitle(),
                'link_url' => $link->getUrl()
            );
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API link details controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     *
     * @return Link details in JSON format
     */
    public function getLinkAction($id, Application $app) {
        $link = $app['dao.link']->find($id);
        // Convert an object ($link) into an associative array ($responseData)
        $responseData = array(
            'link_id' => $link->getId(),
            'link_title' => $link->getTitle(),
            'link_url' => $link->getUrl()
        );
        // Create and return a JSON response
        return $app->json($responseData);
    }


//    /**
//     * Converts an Link object into an associative array for JSON encoding
//     *
//     * @param Link $link Link object
//     *
//     * @return array Associative array whose fields are the article properties.
//     */
//    private function buildLinkArray(Link $link) {
//        $data  = array(
//            'link_id' => $link->getId(),
//            'link_title' => $link->getTitle(),
//            'link_url' => $link->getUrl()
//        );
//        return $data;
//    }
}
