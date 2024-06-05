<?php

return [
    'book_worm' => [
        'name' => 'Book Worm',
        'instructions' => '',
        'tool' => [
            'type' => 'function',
            'function' => [
                'name' => 'book_summary',
                'description' => 'Get a full detailed insight of book provided by the user',
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
                                        'description' => 'Provide a title of each key aspect',
                                    ],
                                    'page' => [
                                        'type' => 'string',
                                        'description' => 'The page number where each key aspect was found',
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                        'description' => 'Provide a comprehensive analysis of each key aspect provided, text must be at least 100 words',
                                    ],
                                ],
                                'required' => [
                                    'aspect',
                                    'page',
                                    'description',
                                ],
                            ],
                            'description' => "List of five key aspects of the book avoiding the pages that may be or contains the following: cover, abstract, bibliography, table of contents, references, index and another information which is not part of the book's content itself",
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
        ],
    ],
];
