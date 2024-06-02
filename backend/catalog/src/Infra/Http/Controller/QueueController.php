<?php 
namespace Catalog\Infra\Http\Controller;

use Catalog\Infra\Queue\Queue;

class QueueController
{
    public function __construct(
        private readonly Queue $queue
        // caso de uso necessário
    ) {
        $queue->on("useCaseQueueName", function($input) {
            // $useCase->execute($input)
        });
    }
}