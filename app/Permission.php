<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends \Spatie\Permission\Models\Permission
{

    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];

    /**
     * The attibutes for logging the event change
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'guard_name'];

    /**
     * Logging name
     *
     * @var string
     */
    protected static $logName = 'permission';

    /**
     * Logging only the changed attributes
     *
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * Prevent save logs items that have no changed attribute
     *
     * @var boolean
     */
    protected static $submitEmptyLogs = false;

    /**
     * Custom logging description
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Data has been {$eventName}";
    }

    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'view_permissions',
            'add_permissions',
            'edit_permissions',
            'delete_permissions',

            'view_logs',
        ];
    }

    public static function modulePermission()
    {
        return [
            'view_satker',
            'add_satker',
            'edit_satker',
            'delete_satker',

            'view_jabatan',
            'add_jabatan',
            'edit_jabatan',
            'delete_jabatan',

            'view_jenker',
            'add_jenker',
            'edit_jenker',
            'delete_jenker',

            'view_pekerjaan',
            'add_pekerjaan',
            'edit_pekerjaan',
            'delete_pekerjaan',

            'view_kontrak',
            'add_kontrak',
            'edit_kontrak',
            'delete_kontrak',

            'view_lahan',
            'add_lahan',
            'edit_lahan',
            'delete_lahan',

            'view_pengguna',
            'add_pengguna',
            'edit_pengguna',
            'delete_pengguna',

            'view_pelaksanaan',
            'add_pelaksanaan',
            'edit_pelaksanaan',
            'delete_pelaksanaan',

        ];
    }
}
