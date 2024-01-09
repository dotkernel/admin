<?php

declare(strict_types=1);

namespace Frontend\App;

class Message
{
    public const VALIDATOR_REQUIRED_FIELD_BY_NAME = '%s is required and cannot be empty.';
    public const INVALID_VALUE                    = 'The value specified for \'%s\' is invalid.';
    public const METHOD_NOT_ALLOWED               = 'Method not allowed.';
    public const ADMIN_NOT_FOUND                  = "Admin not found.";
    public const SETTING_NOT_FOUND                = "Setting not found.";
    public const AN_ERROR_OCCURRED                = "An error occurred, please try again later";
    public const ADMIN_UPDATED_SUCCESSFULLY       = "Admin updated successfully";
    public const ADMIN_CREATED_SUCCESSFULLY       = "Admin created successfully";
    public const ADMIN_DELETED_SUCCESSFULLY       = "Admin deleted successfully";
    public const ACCOUNT_UPDATE_SUCCESSFULLY      = "Your account was updated successfully";
    public const CURRENT_PASSWORD_INCORRECT       = "Current password is incorrect";
}
