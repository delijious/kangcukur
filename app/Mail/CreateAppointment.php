<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateAppointment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$detail,$subject)
    {
        $this->content = $content;
        $this->detail = $detail;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->replaceContent();

        if( env('MAIL_MAILER') == "mailgun")
        {
            return $this->from($address = 'hello@example.com', $name = $this->detail['AppName'])
                ->subject($this->subject)->view('admin/mail/userVerificationMail')
                ->with([
                'content' => $this->content,
            ]);
        }
        return $this->from($address = env('MAIL_FROM_ADDRESS'), $name = $this->detail['AppName'])
        ->subject($this->subject)->view('admin/mail/userVerificationMail')
        ->with([
        'content' => $this->content,
        ]);
      
    }
    public function replaceContent()
    {        
        $data = ["{{UserName}}", "{{Date}}","{{Time}}","{{BookingId}}","{{SalonName}}","{{BookingAt}}","{{EmployeeName}}","{{AppName}}"];
        $this->content = str_replace($data, $this->detail, $this->content);
    }
}