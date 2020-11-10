<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Contact;

class NewUserFeedback extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $from_name = config('constants.email.from_name');
        $id = $this->contact->id;
        $name = $this->contact->name;
        $user_phone = $this->contact->phone;
        $subject = $this->contact->subject;
        $message = $this->contact->message;
        $email = $this->contact->email;
        $company_name_title = $this->contact->company_name_title;
        $send_to_user = $this->contact->send_to_user;
        $send_to_admin = $this->contact->send_to_admin;

        if ($send_to_user){
            //send user email
            $subject = 'Dear ' . ucwords($name) . ', Your Message Was Sent To ' . $company_name_title;
        }

        if ($send_to_admin){
            //send admin email
            $subject = 'Dear ' . ucwords($company_name_title) . ', You Have Received A Message From ' . ucwords($name);
        }

        $email = $this->subject($subject)
                    ->markdown('emails.user.newuserfeedback');

        return $email;

    }

}
