<?php
declare(strict_types=1);

namespace Networkteam\Flow\Altcha\Eel\Helper;

/*
 * This file is part of the Networkteam.Flow.Altcha package.
 *
 * (c) networkteam GmbH
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n\Translator;
use Networkteam\Flow\Altcha\Service\AltchaService;

class AltchaHelper implements ProtectedContextAwareInterface
{
    #[Flow\Inject]
    protected AltchaService $altchaService;

    #[Flow\Inject]
    protected Translator $translator;

    public function getChallengeJson(): string
    {
        return json_encode($this->altchaService->createChallenge());
    }

    public function getWidgetStringsJson(): string
    {
        $strings = [
            'ariaLinkLabel' => $this->translate('widget.ariaLinkLabel'),
            'error' => $this->translate('widget.error'),
            'expired' => $this->translate('widget.expired'),
            'footer' => $this->translate('widget.footer'),
            'label' => $this->translate('widget.label'),
            'verified' => $this->translate('widget.verified'),
            'verifying' => $this->translate('widget.verifying'),
            'waitAlert' => $this->translate('widget.waitAlert'),
        ];

        return json_encode($strings);
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }

    private function translate(string $id): string
    {
        $translation = $this->translator->translateById(
            $id,
            [],
            null,
            null,
            'Main',
            'Networkteam.Flow.Altcha'
        );

        return is_string($translation) ? $translation : '';
    }
}

