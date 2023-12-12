<?php

declare(strict_types=1);

namespace Frontend\App;

class Message
{
    public const VALIDATOR_REQUIRED_FIELD_BY_NAME = '%s is required and cannot be empty.';
    public const INVALID_VALUE                    = 'The value specified for \'%s\' is invalid.';
    public const METHOD_NOT_ALLOWED               = 'Method not allowed.';

    public const ADMIN_NOT_FOUND = "Admin not found.";

    public const SETTING_NOT_FOUND = "Setting not found.";
}
