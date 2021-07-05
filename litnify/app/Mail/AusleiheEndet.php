<?php

namespace App\Mail;

use App\Models\Ausleihe;
use App\Models\Medium;
use App\Models\User;
use App\View\Components\MediumCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Mixed_;

class AusleiheEndet extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ausleihen;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $ausleihen, User $user)
    {
        $this->user=$user;
//        $this->user=User::find($ausleihe->user_id);
//        $this->medium=Medium::find($ausleihe->medium_id);

        $this->ausleihen=$ausleihen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ausleiheendet')->subject('Benachrichtigung von Ihrer Meteorologiebibliothek');
    }
}
