<?php
namespace Payum\Core\Bridge\Symfony;

use Payum\Core\Bridge\Symfony\Reply\HttpResponse as SymfonyHttpResponse;
use Payum\Core\Exception\LogicException;
use Payum\Core\Reply\ReplyInterface;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ReplyToSymfonyResponseConverter
{
    /**
     * @param ReplyInterface $reply
     *
     * @return Response
     */
    public function convert(ReplyInterface $reply)
    {
        if ($reply instanceof SymfonyHttpResponse) {
            return $reply->getResponse();
        } elseif ($reply instanceof HttpResponse) {
            return new Response($reply->getContent());
        } elseif ($reply instanceof HttpRedirect) {
            return new RedirectResponse($reply->getUrl());
        }

        $ro = new \ReflectionObject($reply);

        throw new LogicException(
            sprintf('Cannot convert reply %s to http response.', $ro->getShortName()),
            null,
            $reply
        );
    }
} 