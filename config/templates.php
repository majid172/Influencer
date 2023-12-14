<?php
return [
	'hero' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'short_description' => 'textarea',
            'button_name' => 'text',
            'button_link' => 'url',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:70',
            'sub_title.*' => 'required|max:100',
            'short_description.*' => 'required|max:2000',
            'button_name.*' => 'required|max:50',
            'button_link.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '500x500',
        ]
    ],

	'experience' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
			'years_experience' => 'text',
			'project_done' => 'text',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:500',
			'years_experience.*' => 'required|integer',
			'project_done.*' => 'required|integer',
		],
	],

	'about-us' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
			'short_description' => 'textarea',
			'button_name' => 'text',
            'button_link' => 'url',
			'image' => 'file',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:2000',
			'button_name.*' => 'required|max:50',
            'button_link.*' => 'required|max:2000',
			'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
		],
        'size' => [
            'image' => '500x500',
        ]
	],

	'how-it-work' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
			'short_description' => 'textarea',
			'image' => 'file',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:2000',
			'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
		],
    'size' => [
        'image' => '955x716',
    ]
	],

	'testimonial' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
		]
	],

	'feature' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
		]
	],

	'contact' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
			'short_description' => 'textarea',
			'email' => 'text',
			'phone' => 'text',
			'location' => 'text',
			'footer_short_details' => 'textarea'
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:2000',
			'email.*' => 'required|min:2|max:100',
			'phone.*' => 'required|min:2|max:100',
			'location.*' => 'required|min:2|max:100',
			'footer_short_details.*' => 'required|max:1000',
		],
	],

  'news-letter' => [
      'field_name' => [
          'title' => 'text',
          'sub_title' => 'text'
      ],
      'validation' => [
          'title.*' => 'required|max:80',
          'sub_title.*' => 'required|max:300'
      ]
  ],

	'blog' => [
		'field_name' => [
			'title' => 'text',
			'sub_title' => 'text',
			'short_description' => 'textarea',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'sub_title.*' => 'required|min:2|max:100',
			'short_description.*' => 'required|min:2|max:2000',
		],
	],

	'sign-in' => [
		'field_name' => [
			'title' => 'text',
			'image' => 'file',
		],
		'validation' => [
			'title.*' => 'required|min:2|max:100',
			'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
		],
		'size' => [
			'image' => '460x551',
		]
	],

	'sign-up' => [
		'field_name' => [
			'button_one_name' => 'text',
			'title_one' => 'text',
			'button_two_name' => 'text',
			'title_two' => 'text',
		],
		'validation' => [
			'button_one_name.*' => 'required|min:2|max:15',
			'title_one.*' => 'required|min:2|max:35',
			'button_two_name.*' => 'required|min:2|max:15',
			'title_two.*' => 'required|min:2|max:35',
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

	'template_media' => [
		'image' => 'file',
		'thumbnail' => 'file',
		'image_one' => 'file',
		'image_two' => 'file',
		'image_three' => 'file',
		'button_link' => 'url'
	]

];
