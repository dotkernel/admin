<?php

declare(strict_types=1);

namespace Admin\Setting\Enum;

enum SettingEnum: string
{
    case IdentifierTableAdminListSelectedColumns       = 'table_admin_list_selected_columns';
    case IdentifierTableAdminListLoginsSelectedColumns = 'table_admin_list_logins_selected_columns';
}
