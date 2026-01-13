<?php
declare(strict_types=1);

namespace Networkteam\Flow\Altcha\Validation\Validator;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Networkteam\Flow\Altcha\Service\AltchaService;

/*
 * This file is part of the Networkteam.Flow.Altcha package.
 *
 * (c) networkteam GmbH
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

class CaptchaValidator extends AbstractValidator
{
    /**
     * @var array<string, array<int, mixed>>
     */
    protected $supportedOptions = [];

    protected $acceptsEmptyValues = false;

    #[Flow\Inject]
    protected AltchaService $altchaService;

    /**
     * @param mixed $value
     */
    protected function isValid($value): void
    {
        if ($value === null || $value === '') {
            $this->addError('This field is required.', 1742223415);
            return;
        }

        if (!is_string($value)) {
            $this->addError('Value must be of type string.', 1751545289);
            return;
        }

        if ($this->altchaService->validate($value) === false) {
            $this->addError('Captcha validation failed.', 1744199570);
        }
    }
}
