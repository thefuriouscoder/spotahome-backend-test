<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 10/03/16
 * Time: 11:38
 */

namespace Spotahome\App\Controllers;

use Sabre\Xml\Reader;


/**
 * Class PropertyController
 * @package App\Controller
 */
class PropertyController
{
    /**
     * @param \Slim\App $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     */
    public function listAction($request,$response,$args)
    {

        $dataUrl = $this->app->settings["app"]["dataUrl"];

        $parsed = $this->app->get('xml')->parse(file_get_contents($dataUrl));

        $data = $this->transformPropertyData($parsed);

        if(count($data) > $_GET["offset"])
            echo(json_encode($data));
        else
            echo(json_encode([]));

    }

    /**
     * @param Array $parsed
     * @return Array
     */
    private function transformPropertyData($parsed) {

        $data = [];

        foreach ($parsed as $property) {

            $data[] = [
                "id"        => $property["value"]['{}id'],
                "title"     => $property["value"]['{}title'],
                "url"       => $property["value"]['{}url'],
                "city"      => $property["value"]['{}city'],
                "picture"   => $property["value"]['{}pictures'][0]['value'][0]['value'],
            ];

        }

        return $data;
    }

}