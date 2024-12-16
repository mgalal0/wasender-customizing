<?php

namespace App\Jobs;

use App\Models\Smstransaction;
use App\Traits\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Whatsapp;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $data, public string $type, public Smstransaction $log, public bool $withoutFilter = false)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = $this->messageSend($this->data, $this->data['device'], $this->data['phone'], $this->type, $this->withoutFilter);

        $this->log->status = $response['status'] == 200 ? 'sent' : 'failed';
        $this->log->save();
    }

    public function fail()
    {
        $this->log->status = 'failed';
        $this->log->save();
    }
}
