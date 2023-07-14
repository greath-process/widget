<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswersRequest;
use App\Mail\Answers;
use Illuminate\Support\Facades\Mail;

class SendAnswersController extends Controller
{
    public function __invoke(
        AnswersRequest $request,
        string $text = '',
    ): void
    {
        $string = base64_decode($request->questions);
        $array = json_decode($string);
        $regex = "/[^AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0-9@+.()_\-\s,]/";

        if (is_array($array)) {
            foreach($array as $row) {
                $question = preg_replace($regex, "", current($row));
                $answer = preg_replace($regex, "", is_array($row[1]) ? implode(', ', $row[1]) : $row[1]);
                if ($question == 'First name and last name') $question = '<br>'.$question;
                if ($answer) {
                    $text .=  $question.': '. $answer . '; <br>';
                }
            }

            $recipients = explode(';', env('MAIL_TO_ADDRESS'));
            foreach ($recipients as $recipient) {
                Mail::to($recipient)->send(new Answers($text));
            }
        }
    }
}
