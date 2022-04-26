<?php

namespace App\Jobs;

use App\Contracts\Jwt\Audience;
use App\Entity\User;
use App\Service\Jwt\JwtBuilder;
use App\Service\Log;

class SendRecoveryEmail extends Job
{
	private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
		$this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(JwtBuilder $builder) //Mailer $mailer
    {
    	$user = $this->user;

		$token = $builder
			->setExpirationIn(100) //100 minutes
			->setOwner($user->owner_id)
			->setSubject($user->id)
			->setAudience(Audience::RECOVER)
			->getToken();

		Log::log($user, Log::RECOVER_REQUEST, $token);

		//$mailer->send($user->email, $token);
    }
}
