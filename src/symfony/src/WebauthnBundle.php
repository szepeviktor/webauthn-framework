<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Webauthn\Bundle;

use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webauthn\Bundle\DependencyInjection\Compiler\AttestationStatementSupportCompilerPass;
use Webauthn\Bundle\DependencyInjection\WebauthnExtension;
use Webauthn\Bundle\Security\Factory\WebauthnSecurityFactory;

class WebauthnBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new WebauthnExtension('webauthn');
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AttestationStatementSupportCompilerPass());

        /* @var SecurityExtension $extension */
        if ($container->hasExtension('security')) {
            $extension = $container->getExtension('security');
            $extension->addSecurityListenerFactory(new WebauthnSecurityFactory());
        }
    }
}