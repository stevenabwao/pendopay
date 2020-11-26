<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\EmailQueue;

class ReminderMessageEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailqueue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailQueue $emailqueue)
    {
        $this->emailqueue = $emailqueue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //set statuses
        $status_open = config('constants.status.open');
        $status_active = config('constants.status.active');

        //set attributes
        $subject = html_entity_decode($this->emailqueue->subject);
        $company_id = $this->emailqueue->company_id;

        $attach_record = [];

        $has_attachments = $this->emailqueue->has_attachments;
        $event_type_id = $this->emailqueue->event_type_id;

        if ($has_attachments == $status_active) {

            //registration event == 1
            //$event_type_id = 1;
            $company_assets = getCompanyAssets($company_id, $event_type_id);
            //dd($company_assets);
            $site_url = config('constants.site.url');

            foreach ($company_assets as $company_asset) {
                $asset_url = $site_url . $company_asset->asset_url;
                //get file extension
                $ext = pathinfo($asset_url, PATHINFO_EXTENSION);
                $attach_record_prop = [];
                $attach_title_slug = getStrSlug($company_asset->name) . '.' . $ext;
                $attach_record_prop['as'] = $attach_title_slug;
                $attach_record_prop['mime'] = $company_asset->mime;
                //array_push($attach_record, $attach_record_prop);
                $attach_record[] = [$asset_url => $attach_record_prop];
            }

        }


        //dd($subject, $attach_record);

        $email = $this->subject($subject)
                    ->markdown('emails.reminder.remindermessage');

        //if attachments exist, attach
        if (count($attach_record)) {
            foreach($attach_record as $attach_data){
                foreach($attach_data as $filePath => $fileParameters){
                    $email->attach($filePath, $fileParameters);
                }
            }
        }

        //update sent_at time
        $current_date = getCurrentDate(1);
        $sent_at_update = $this->emailqueue
                        ->update([
                            'sent_at' => $current_date
                        ]);

        return $email;

    }

}
