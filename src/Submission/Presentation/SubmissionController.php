<?php 
declare(strict_types=1);

namespace SocialNews\Submission\Presentation;

use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SocialNews\Framework\Rendering\TemplateRenderer;
use Symfony\Component\HttpFoundation\Session\Session;
use SocialNews\Submission\Application\SubmitLink;
use SocialNews\Submission\Application\SubmitLinkHandler; 
use SocialNews\Framework\Rbac\AuthenticatedUser;   

final class SubmissionController
{
    private $templateRenderer;
    private $storedTokenValidator;
    private $session;

    public function __construct(
        TemplateRenderer $templateRenderer,
        StoredTokenValidator $storedTokenValidator,
        Session $session
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
        $this->session = $session;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Submission.html.twig');
        
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
    
        $response = new RedirectResponse('/submit');
    
        if (!$this->storedTokenValidator->validate(
                'submission',
                new Token((string)$request->get('token'))
            )) {
                $this->session->getFlashBag()->add('errors', 'Invalid token');
                return $response;
            }

        if (!$this->user instanceof AuthenticatedUser) {
            throw new \LogicException('Only authenticated users can submit links');
        }

        if (!$this->user->hasPermission(new Permission\SubmitLink())) {
                $this->session->getFlashBag()->add(
                    'errors',
                    'You have to log in before you can submit a link.'
                );
        
                return new RedirectResponse('/login');
        }

        $this->submitLinkHandler->handle($form->toCommand($this->user));

        $this->submitLinkHandler->handle(new SubmitLink(
            $request->get('url'),
            $request->get('title')
        ));

        $this->session->getFlashBag()->add(
            'success',
            'Your URL was submitted successfully'
        );

        return $response;
    }


}
