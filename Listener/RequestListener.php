<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Clicktrend\ReverseProxyBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RequestListener {
    
    protected $router; 
    protected $baseUrl;
    
    public function __construct(Router $router, $baseUrl) {
        $this->router = $router;
        $this->baseUrl = $baseUrl;
    }
    
    public function onRequest(GetResponseEvent $event) {
        $headers = $event->getRequest()->headers;
        if($headers->get('x-forwarded-host') != $this->router->getContext()->getHost()) { //Reverse Proxy is enabled
            $this->router->getContext()->setHost($headers->get('x-forwarded-host'));
            $this->router->getContext()->setBaseUrl($this->baseUrl . $this->router->getContext()->getBaseUrl());
        }
    }
    
}
