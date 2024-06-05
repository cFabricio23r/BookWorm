<?php

return [
    'function_request' => 'Perform function requests for the user following the instructions',

    'initial_message' => 'Please provide the following information about the book in JSON string format do not add any other information on response, only the response in JSON format

    title: The title of the book.
    author: The author(s) of the book.
    year: The year the book was published.
    key_aspects: At least 10 key aspects of the entire book. For each aspect, include a small title and detailed description, also the page number where it was taken from.
    summary: A brief summary of the book.',

    'book_summary_function' => [
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

];
