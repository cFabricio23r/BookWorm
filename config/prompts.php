<?php

return [
    'function_request' => 'Perform function requests for the user',

    'book_summary_function' => [
        'name' => 'book_summary',
        'description' => 'Get a full and detail insight of book provided by the user',
        'parameters' => [
            'type' => 'object',
            'properties' => [
                'title' => [
                    'type' => 'string',
                    'description' => "Book's title",
                ],
                'author' => [
                    'type' => 'string',
                    'description' => "Book's author",
                ],
                'year' => [
                    'type' => 'string',
                    'description' => "Book's publication year",
                ],
                'key_aspects' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'aspect' => [
                                'type' => 'string',
                                'description' => 'Provide a key aspect of the book',
                            ],
                            'page' => [
                                'type' => 'string',
                                'description' => 'The page number where the key aspect was found',
                            ],
                            'description' => [
                                'type' => 'string',
                                'description' => 'Provide a comprehensive analysis of the key aspect provided, text must be at least 100 words',
                            ],
                        ],
                        'required' => [
                            'aspect',
                            'page',
                            'description',
                        ],
                    ],
                    'description' => "Provide 5 key aspects of the book taking as criteria the following: Brief plot summary, main themes explored in the book, significant quotes with context. Avoid the pages that may be or contains the following: cover, abstract, bibliography, table of contents, references, index and another information which is not part of the book's content itself",
                ],
                'summary' => [
                    'type' => 'string',
                    'description' => 'Provide a summary of the book, text must be at least 500 words',
                ],
            ],
            'required' => [
                'title',
                'author',
                'year',
                'key_aspects',
                'summary',
            ],
        ],
    ],

];
