<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
        'facebook' => [
		'client_id' => '1562205014036534',
		'client_secret' => '3b9807e0d826bfd66fb3fbdc627fd015',
	],
	'mailgun' => [
		'domain' => 'sandboxea186e697ec54f9c89e531ee537ad9ea.mailgun.org',
		'secret' => 'key-fec1781270b2c95736762571e05eaec8',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

];
