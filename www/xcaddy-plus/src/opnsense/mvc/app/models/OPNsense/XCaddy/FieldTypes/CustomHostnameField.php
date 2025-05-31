<?php

/*
 * Copyright (C) 2025 Cedrik Pischem
 * Copyright (C) 2017-2024 Deciso B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace OPNsense\XCaddy\FieldTypes;

use OPNsense\Base\FieldTypes\HostnameField;
use OPNsense\Base\Validators\CallbackValidator;

class CustomHostnameField extends HostnameField
{
    public function getValidators()
    {
        $validators = parent::getValidators();
        $sender = $this;

        // remove original validator (last in array)
        array_pop($validators);

        if ($this->internalValue != null) {
            $validators[] = new CallbackValidator([
                "callback" => function ($data) use ($sender) {
                    $result = false;
                    $response = [];

                    $values = $sender->internalFieldSeparator === null
                        ? [$data]
                        : explode($sender->internalFieldSeparator, $data);

                    foreach ($values as $value) {
                        $val_is_ip = filter_var($value, FILTER_VALIDATE_IP) !== false;

                        // trim allowed wildcards if set
                        if ($sender->internalFqdnWildcardAllowed && str_starts_with($value, '*.')) {
                            $value = substr($value, 2);
                        } elseif ($sender->internalZoneRootAllowed && str_starts_with($value, '@.')) {
                            $value = substr($value, 2);
                        }

                        if ($sender->internalZoneRootAllowed && $value === '@') {
                            $result = true;
                        } elseif ($sender->internalHostWildcardAllowed && $value === '*') {
                            $result = true;
                        } elseif ($sender->internalIpAllowed && $val_is_ip) {
                            $result = true;
                        } else {
                            // Only disallow whitespace
                            $result = preg_match('/\s/', $value) === 0;
                        }

                        if (!$result) {
                            $response[] = $this->getValidationMessage();
                            break;
                        }
                    }

                    return $response;
                }
            ]);
        }

        return $validators;
    }
}
