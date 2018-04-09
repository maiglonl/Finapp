<?php

namespace Finapp\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Finapp\Models\Subscription;

class FirstSubscriptionPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->user = $subscription->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Sua assinatura está ativa')->view('emails.subscription_paid');
    }
}
