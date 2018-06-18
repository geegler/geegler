<?php

namespace System\Libraries;

interface DispatchInterface
{
    public function requestedController($controller);
    public function requestedMethod($action);
    public function requestedParams(array $params);
    public function serveRequest();
}
