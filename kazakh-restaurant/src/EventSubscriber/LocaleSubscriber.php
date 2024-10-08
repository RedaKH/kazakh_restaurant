<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct(string $defaultLocale = 'fr') {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {

            return;
        }
        
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale',$locale);

        } else {
            $request->setLocale($request->getSession()->get('_locale',$this->defaultLocale));
        }
    }

    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest',20]],
        ];

    }

    

    
}

?>
