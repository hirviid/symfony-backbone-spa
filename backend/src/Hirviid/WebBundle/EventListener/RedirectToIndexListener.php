<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 27/12/2014
 * Time: 11:07
 */

namespace Hirviid\WebBundle\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * This serves only as a .htaccess fallback
 * The .htaccess file should make sure that only urls matching /api/ should continue in the symfony flow
 * If that doesn't work, this listener will do the same.
 *
 * Class RedirectToIndexListener
 * @package WebBundle\EventListener
 */
class RedirectToIndexListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $pathInfo = $request->getPathInfo();

        // Only allow routes that start with /api through
        if (1 === preg_match('/^\/api/', $pathInfo)) {
            return;
        }

        $resource = $request->server->get('CONTEXT_DOCUMENT_ROOT') . '/public/index.html';

        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

        $response = new Response();
        $response->setContent(file_get_contents($resource));

        $event->setResponse($response);
    }
} 