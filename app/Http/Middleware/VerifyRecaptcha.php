<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $recaptchaToken = $request->input('g-recaptcha-response');
        if (!$recaptchaToken) {
            return redirect()->back()->withErrors(['recaptcha' => 'ReCAPTCHA verification failed.']);
        }

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => '6LeRfuwpAAAAAObmTOD9v_RilMP4yE7snTnd3npD',
                'response' => $recaptchaToken,
                'remoteip' => $request->ip(),
            ],
        ]);

        $body = json_decode((string) $response->getBody());

        if (!$body->success) {
            return redirect()->back()->withErrors(['recaptcha' => 'ReCAPTCHA verification failed.']);
        }

        return $next($request);
    }
}
