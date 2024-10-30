<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class CreateElasticsearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:create-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Elasticsearch index for posts';


    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Khởi tạo Elasticsearch client
        $client = ClientBuilder::create()->setHosts(config('elasticsearch.hosts'))->build();

        // Định nghĩa cấu trúc index và mapping
        $params = [
            'index' => 'posts',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'fulltext',
                        ],
                        'content' => [
                            'type' => 'fulltext',
                        ],
                    ]
                ]
            ]
        ];

        // Tạo index trong Elasticsearch
        $response = $client->indices()->create($params);

        // In thông báo kết quả
        $this->info('Index created successfully');
        $this->info(print_r($response, true));
    }
}
