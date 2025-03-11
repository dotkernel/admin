<?php

declare(strict_types=1);

namespace Admin\Setting\Enum;

use function array_column;

enum SettingEnum: string
{
    case IdentifierTableAdminListSelectedColumns       = 'table_admin_list_selected_columns';
    case IdentifierTableAdminListLoginsSelectedColumns = 'table_admin_list_logins_selected_columns';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
