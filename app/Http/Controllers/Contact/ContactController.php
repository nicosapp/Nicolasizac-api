<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Contact\ContactMeEmail;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
  public function __construct()
  {
    $this->middleware('throttle:5,5');
  }

  public function contactMe(Request $request)
  {

    $this->validate($request, [
      'email' => 'required|email',
      'message' => 'required|string',
      'name' => 'required|string',
      'enterprise' => 'string|nullable',
      'phone_number' => ['nullable', new PhoneNumber()]
    ]);

    Mail::to(config('mail.from.address'))->send(new ContactMeEmail(
      $request->only('email', 'message', 'name', 'enterprise', 'phone_number')
    ));
  }
}
