<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
        'model' => env('GROQ_MODEL', 'llama-3.1-8b-instant'),
        'enabled' => env('GROQ_ENABLED', true),
    ],

    

    'openai' => [
    'key' => env('OPENAI_API_KEY'),
    'vision_model' => env('OPENAI_VISION_MODEL', 'gpt-4o'),
    'text_model' => env('OPENAI_TEXT_MODEL', 'gpt-4o'),
    'transcribe_model' => env('OPENAI_TRANSCRIBE_MODEL', 'gpt-4o-mini-transcribe'),
    'tts_model' => env('OPENAI_TTS_MODEL', 'gpt-4o-mini-tts'),
    'enabled' => env('AI_ENABLED', false),
],



];
