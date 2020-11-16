<?php

namespace App\Mail\Contact;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMeEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $theme = 'email';

  public $email;
  public $message;
  public $name;
  public $enterprise;
  public $phoneNumber;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($payload)
  {
    extract($payload);
    $this->email = $email;
    $this->message = $message;
    $this->name = $name;
    $this->enterprise = isset($enterprise) ? $enterprise : '';
    $this->phoneNumber = isset($phone_number) ? $phone_number : '';
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject("NicolasIzacPro **Contact request** from {$this->email}")
      ->with([
        'introLines' => [
          "__Firstname:__ {$this->name}",
          "__Enterprise:__ {$this->enterprise}",
          "__Email:__ {$this->email}",
          "__Phone Number:__ {$this->phoneNumber}",
          "__Message:__",
          $this->message
        ]
      ])
      ->markdown('email.mail');
  }
}
