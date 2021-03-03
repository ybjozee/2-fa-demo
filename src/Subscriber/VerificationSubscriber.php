<?php

namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\{RedirectResponse, Request};
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class VerificationSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {

        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    : void {

        if ($this->shouldRedirectToVerificationPage($event->getRequest())) {
            $event->setController(fn() => new RedirectResponse('/verify'));
        }
    }

    private function shouldRedirectToVerificationPage(Request $request)
    : bool {

        $requestRoute = $request->attributes->get('_route');

        return
            $this->requiresVerification($requestRoute) &&
            !$this->verificationPassed($request);
    }

    private function requiresVerification(?string $route)
    : bool {

        $permittedRoutes = [
            'app_login', 'app_verify_otp',
            'app_logout', 'app_register', '_wdt'
        ];

        return !in_array($route, $permittedRoutes);
    }

    private function verificationPassed(Request $request)
    : bool {

        return $request->getSession()->get('2fa-verified') === true;
    }

}
