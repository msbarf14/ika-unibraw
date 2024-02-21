<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kedeka\Whatsapp\Enums\MessageType;
use Kedeka\Whatsapp\SendContact;
use Kedeka\Whatsapp\SendMessage as SendMessageAction;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $number;

    protected $message;

    protected $type;

    protected $contact_params;

    /**
     * Create a new job instance.
     */
    public function __construct($number, $message, $type = MessageType::Text, $contact_params = [[]])
    {
        $this->number = $number;
        $this->message = $message;
        $this->type = $type;
        $this->contact_params = null;

        if (array_key_exists('phone', $contact_params) && array_key_exists('contact', $contact_params) && array_key_exists('name', $contact_params)) {
            $this->contact_params = array_values([...$contact_params]);
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(SendMessageAction::class)->to($this->number, $this->message, $this->type);
        if ($this->contact_params) {
            app(SendContact::class)->to(...$this->contact_params);
        }
    }
}
