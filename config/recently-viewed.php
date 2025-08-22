<?php

// return [

//     /*
//      * Session prefix.
//      */
//     'session_prefix' => env('RECENTLY_VIEWED_SESSION_PREFIX', 'recently_viewed'),

//     'max_items' => 10,
//     'persist_enabled' => (bool) env('RECENTLY_VIEWED_PERSIST_ENABLED', false),
//     'persist_table'   => 'recent_views',
//     'persist_model'   => \RecentlyViewed\Models\RecentViews::class,
// ];

return [
    'session_key' => 'recently_viewed',
    'max_items' => 10,
    'persist' => [
        'enabled' => env('RECENTLY_VIEWED_PERSIST_ENABLED', false),
        'viewer_class' => \App\Models\User::class,
    ],
];