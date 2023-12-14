<?php
return [
	'how-it-work' => [
		'field_name' => [
			'title' => 'text',
			'short_description' => 'textarea',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:2000',
		],
	],

	'testimonial' => [
        'field_name' => [
            'title' => 'text',
            'designation' => 'text',
            'review' => 'text',
            'short_description' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:30',
            'designation.*' => 'required|max:100',
            'review.*' => 'required|integer|between:1,5',
            'short_description.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '68x68'
        ]
    ],

	'feature' => [
		'field_name' => [
			'title' => 'text',
			'short_description' => 'textarea',
			'image' => 'file',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:500',
			'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
		],
		'size' => [
            'image' => '64x64'
        ]
	],

	'faq' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:190',
            'description.*' => 'required|max:3000'
        ]
    ],

	'social-links' => [
		'field_name' => [
			'title' => 'text',
			'social_icon' => 'icon',
			'social_link' => 'url',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:20',
			'social_icon.*' => 'required',
			'social_link.*' => 'required|url',
		],
	],

	'pages' => [
		'field_name' => [
			'title' => 'text',
			'description' => 'textarea'
		],
		'validation' => [
			'description.*' => 'required|max:300000'
		]
	],


	'message' => [
		'required' => 'This field is required.',
		'min' => 'This field must be at least :min characters.',
        'max' => [
            'file' => 'This image may not be greater than :max kilobytes.',
            'string' => 'The field may not be greater than :max characters.',
        ],
		'image' => 'This field must be image.',
		'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
	],

	'content_media' => [
		'image' => 'file',
		'thumbnail' => 'file',
		'youtube_link' => 'url',
		'social_icon' => 'icon',
		'social_link' => 'url',
		'button_link' => 'url'
	]

];
