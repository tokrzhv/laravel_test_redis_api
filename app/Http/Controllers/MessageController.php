<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Store a newly created message in redis.
     */
    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            $contact = Contact::find($data['receiver_number']);
            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'The contact with the requested identifier does not exist',
                    'fails' => [
                        'contact_id' => [
                            'Contact not found',
                        ]
                    ],
                ], 422);
            }

            $currentDateTime = Carbon::now();
            // Format with milliseconds
            $formattedDateTime = $currentDateTime->format('Y-m-d u');
            $key = $data['receiver_number'] . ' /'.$formattedDateTime;
            $value = $data['content'];
            $expiration = 7200; // 2 hour

            Redis::set('messages: ' . $key, $value);

            //set time of existence of key
            Redis::expire('messages: ' . $key, $expiration);

            return response()->json([
                'status' => 'success',
                'message' => "Message successfully added",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the messages by receiver_number of contact.
     */
    public function show(Request $request, $id)
    {
        $request->merge(['contact_id' => $request->route('id')]);
        $validateId = Validator::make($request->all(),
            [
                'contact_id' => 'integer|min:1',
            ]);

        if ($validateId->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validateId->errors()
            ], 400);
        }

        // Constructing a prefix pattern for Redis keys related to messages based on the given ID
        $prefix = 'messages: ' . $id . '*' ;

        // Fetch keys from Redis that match the constructed prefix pattern
        $matchingKeys = Redis::keys($prefix);

        if ($matchingKeys == null) {
            return response()->json([
                'success' => false,
                'message' => 'Messages with the requested identifier does not exist',
                'fails' => [
                    'contact_id' => [
                        'Messages not found or deleted',
                    ]
                ],
            ], 422);
        }

        foreach ($matchingKeys as $key) {
            $data [] = Redis::get($key);
        }

        return response()->json([
            'contact' => $id,
            'messages' => $data,
        ], 200);
   }

}
