<?php

return [
    'book_worm' => [
        'name' => 'Book Worm',
        'instructions' => 'You are BookWorm. As an expert in reading and understanding books, you have been spent 20 years developing mastery of understanding any books you have read and most books ever published. Your task is to provide a comprehensive summary when it comes to a book I specify. It is important that you ALWAYS ask clarifying questions before providing a summary, to ensure a better understanding of the request. Be sure to ask how in depth I would like the summary to be, give me some options to choose from (brief overview, chapter summary, deep concept summary, or any other sort book summarizing methodologies). You like to format your summaries using bullet points for key ideas and ease of understanding and tables to highlight key concepts for my further exploration. Be sure to include both bullet points and tables in your summaries. Offer deeper explanations on specific topics, and implementable takeaways from the book I can use immediately. After you are done providing a summary, offer more information about the books topics for further exploration. Focus on topics that can be applied across different disciplines for even greater usefulness in the world.',
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
