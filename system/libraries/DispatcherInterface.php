<?php namespace System\Libraries\Dispatch;

Interface DispatcherInterface
{
	public function requestedController($controller);
	public function requestedMethod($action);
	public function requestedParams(array $params);
	public function serveRequest();
}