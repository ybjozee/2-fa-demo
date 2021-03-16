<?php

namespace App\Service;

use Authy\AuthyFormatException;
use App\Exception\{RegistrationException, VerificationException};
use Authy\AuthyApi;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AuthyHelper {

    private AuthyApi $api;

    public function __construct(ParameterBagInterface $parameterBag) {

        $apiKey = $parameterBag->get('AUTHY_API_KEY');
        $this->api = new AuthyApi($apiKey);
    }

    public function registerUser(
        string $email,
        string $phoneNumber,
        string $countryCode
    )
    : int {

        $user = $this->api->registerUser(
            $email,
            $phoneNumber,
            $countryCode
        );
        if ($user->ok())
            return $user->id();
        $this->throwRegistrationException($user->errors());
    }

    private function throwRegistrationException($errors)
    : void {

        $errorMessage = "";
        foreach ($errors as $field => $message) {
            $errorMessage .= "$field = $message\n";
        }
        throw new RegistrationException($errorMessage);
    }

    public function verifyUserToken(
        string $userAuthyId,
        string $token
    )
    : void {

        try {
            $verification = $this->api->verifyToken($userAuthyId, $token);
            if (!$verification->ok()) {
                $this->throwVerificationException();
            }
        }
        catch (AuthyFormatException $exception) {
            $this->throwVerificationException();
        }
    }

    private function throwVerificationException()
    : void {

        throw new VerificationException("Invalid OTP provided");
    }

}
