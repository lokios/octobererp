<?php return [
    'plugin' => [
        'name' => 'RESTful',
        'description' => 'Generate RESTful controllers'
    ],
    'settings' => [
        'name' => 'API Configuration',
        'description' => 'Manage the API nodes.',
        'prefix_label' => 'API Prefix',
        'prefix_comment' => 'Specify a prefix to be used globally for all API nodes',
        'enable_label' => 'Enable Nodes',
        'disable_label' => 'Disable Nodes',
        'action_confirm' => 'Are you sure you want to :action these nodes?',
        'enable_success' => 'Successfully enabled the selected node(s).',
        'disable_success' => 'Successfully disabled the selected node(s).',
    ]
];
