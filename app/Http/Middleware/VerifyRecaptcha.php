<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $recaptchaToken = $request->input('recaptcha_token');
        if (!$recaptchaToken) {
            return redirect()->back()->withErrors(['recaptcha' => 'ReCAPTCHA verification failed.']);
        }

        $recaptchaKey = '6LeRfuwpAAAAAObmTOD9v_RilMP4yE7snTnd3npD';
        $project = 'sisettan-1717079509063';
        $action = 'login';

        $client = new RecaptchaEnterpriseServiceClient();
        $projectName = $client->projectName($project);

        $event = (new Event())
            ->setSiteKey($recaptchaKey)
            ->setToken($recaptchaToken);

        $assessment = (new \Google\Cloud\RecaptchaEnterprise\V1\Assessment())
            ->setEvent($event);

        try {
            $response = $client->createAssessment($projectName, $assessment);

            if ($response->getTokenProperties()->getValid() == false) {
                return redirect()->back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA token.']);
            }

            if ($response->getTokenProperties()->getAction() == $action) {
                $score = $response->getRiskAnalysis()->getScore();
                if ($score < 0.5) {
                    return redirect()->back()->withErrors(['recaptcha' => 'ReCAPTCHA verification failed.']);
                }
            } else {
                return redirect()->back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA action.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['recaptcha' => 'ReCAPTCHA verification failed: ' . $e->getMessage()]);
        }

        return $next($request);
    }
}
