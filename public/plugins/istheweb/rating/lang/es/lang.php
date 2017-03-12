<?php

return [
    'plugin'       => [
        'name'        => 'Rating Plugin',
        'description' => 'Interactive Ranting Plugin that allows your users vote and rate products, post...',
    ],
    'components'   => [
        'ratings'  => [
            'name'          => 'Ratings Component',
            'description'   => 'Show a rating tool',
        ],
    ],
    'descriptions' => [

    ],
    'labels'       => [
        'answer'                    => 'Answer',
        'edit_answer'               => 'Edit answer here',
        'public'                    => 'Public',
        'featured'                  => 'Featured',
        'replay_email'              => 'Replay Email',
        'created_at'                => 'Created at',
        'creation_date'             => 'Creation date',
        'creation_date_description' => 'When the question was created',
        'is_public'                 => 'Is Public?',
        'is_featured'               => 'Is Featured?',
        'make_featured'             => 'Make this question featured',
        'notification_email'        => 'Notification Email',

    ],
    'symbol'      => [
        'title'             => 'Symbol used for rank',
        'description'       => 'Which symbol must be displayed in the rank tool',
    ],
    'toolsize'     => [
        'title'             => 'Rank Size',
        'description'       => 'Controls the symbol\'s size',

    ],
    'step'     => [
        'title'             => 'Rank Step',
        'description'       => 'Rank\'s step avaible for the user',

    ]
];