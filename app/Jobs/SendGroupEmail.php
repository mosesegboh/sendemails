<?php

namespace App\Jobs;

use App\Services\SendMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendGroupEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $group;
    protected $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($group, $template)
    {
        $this->group = $group;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $group = $this->group;
        $template = $this->template;

        foreach ($group->customers as $customer) {
            $subject = $template->subject;
            $body = SendMailService::replacePlaceholders($template->body_template, $customer);
            SendMailService::instance()->sendEmail($subject, $body, $customer->email);
        }
        //reviewer remember to run php artisan queue:work
    }
}
