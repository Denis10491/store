<?php

return [
    /**
     * List of user types.
     * The list can be both the real name of the classes
     * or pseudonyms like "group".
     *
     * It is important in series of elements,
     * after the appointment of rights it is undesirable to change
     */
    'owner_types' => [
        App\Models\User::class,
        'Group',
        'Role',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false, if you want to implement custom logic for checking permissions.
     */
    'register_permission_check_method' => true,

    'table_names' => [

        /*
         * When using the "hasPermission" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */
        'rule' => 'access_rules',

        /*
         * When using the "hasPermission" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */
        'permission' => 'access_rules_permission',

        /*
         * When using the "hasPermission" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */
        'owner' => 'access_rules_owner',

        /*
         * When using the "hasPermission" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */
        'inheritance' => 'access_rules_inheritance',
    ],

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */
        'expiration_time' => 24*60,

        /*
         * The cache key used to prefix store list permissions.
         */
        'key' => 'access_rules.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */
        'store' => 'default',
    ],
];
