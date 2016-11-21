<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/14/2016
 * Time: 11:12 PM
 */

namespace Dot\Admin\Admin;

/**
 * Class UIMessages
 * @package Dot\Admin\Admin
 */
class UIMessages
{

    /** ADMIN ACCOUNT RELATED MESSAGES */
    const ADMIN_ACCOUNT_UPDATE_OK = 'Admin account successfully updated';
    const ADMIN_ACCOUNT_CREATE_OK = 'Admin account successfully created';
    const ADMIN_ACCOUNT_DELETE_OK = 'Admin accounts successfully removed';

    const ADMIN_ACCOUNT_DELETE_NO_IDS = 'No valid accounts selected for removal. No changes were made';
    const ADMIN_ACCOUNT_DELETE_CANCELED = 'Accounts removal was not confirmed. No changes were made';

    const ADMIN_ACCOUNT_UPDATE_ERROR = 'Could not update account due to a server error. Please try again';
    const ADMIN_ACCOUNT_CREATE_ERROR = 'Could not create account due to a server error. Please try again';
    const ADMIN_ACCOUNT_DELETE_ERROR = 'Could not remove selected accounts due to a server error. Please try again';

    const ADMIN_ACCOUNT_EDIT_NO_ID = 'No admin selected for editing. No changes were made';
    const ADMIN_ACCOUNT_EDIT_INVALID_ID = 'Could not load selected admin - invalid admin ID';

    /** ADMIN FORM RELATED MESSAGES */
    const USERNAME_REQUIRED = 'Username is required and cannot be empty';
    const USERNAME_LENGTH_LIMIT = 'Username must have at least 3 and up to 150 characters';
    const USERNAME_INVALID_CHARS = 'Username contains invalid characters';
    const USERNAME_ALREADY_TAKEN = 'Username is already taken';

    const EMAIL_REQUIRED = 'Email address is required and cannot be empty';
    const EMAIL_INVALID = 'Email address format is invalid';
    const EMAIL_ALREADY_REGISTERED = 'Email address is already registered';

    const FIRSTNAME_CHARACTER_LIMIT = 'First name cannot have more than 150 characters';
    const LASTNAME_CHARACTER_LIMIT = 'Last name cannot have more than 150 characters';

    const PASSWORD_REQUIRED = 'Password is required and cannot be empty';
    const PASSWORD_CHARACTER_LIMIT = 'Password must have at least 4 and up to 150 characters';
    const PASSWORD_VERIFY_REQUIRED = 'Password confirmation is required and cannot be empty';
    const PASSWORD_VERIFY_MISMATCH = 'Password confirmation does not match';

    const CSRF_EXPIRED = 'The form used to make the request has expired. Try again now';
}