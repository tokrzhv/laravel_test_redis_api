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

            //Check for an existing recipient in the contacts table
            $contact = Contact::find($data['receiver_id']);
            if (!$contact) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Receiver with the requested identifier does not exist',
                ], 404);
            }

            //Set time-mark for key in Redis
            $currentDateTime = Carbon::now();
            $formattedDateTime = $currentDateTime->format('Y-m-d u');

            $receiver_id = $data['receiver_id'];
            $key = $receiver_id . ' /'.$formattedDateTime;
            $value = $data['content'];
            $expiration = 7200; // ttl 2 hour

            Redis::set('messages: ' . $key, $value);
            Redis::expire('messages: ' . $key, $expiration);

            return response()->json([
                'status' => 'success',
                'message' => "Message successfully sent",
                'data' => [
                    'receiver_id' => $receiver_id,
                    'message' => $value
                ],
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the messages by receiver_number of contact.
     */
    public function show(Request $request, $receiver_id)
    {
        try {
            //Validation of route param {receiver_id}
            $request->merge(['receiver_id' => $request->route('receiver_id')]);
            $validateId = Validator::make($request->all(),
                [
                    'receiver_id' => 'required|integer',
                ]);
            if ($validateId->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The given data was invalid.',
                    'error' => $validateId->errors()
                ], 422);
            }

            // Constructing a prefix pattern for Redis keys related to messages based on the given ID
            $prefix = 'messages: ' . $receiver_id . ' /' . '*' ;

            // Fetch keys from Redis that match the constructed prefix pattern
            $matchingKeys = Redis::keys($prefix);

            if ($matchingKeys == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Messages with the requested identifier does not exist',
                    'error' => [
                        'receiver_id' => [
                            'Messages not found or deleted',
                        ]
                    ],
                ], 404);
            }

            //Push given data in array
            foreach ($matchingKeys as $key) {
                $data [] = Redis::get($key);
            }

            return response()->json([
                'status' => 'success',
                'message' => "Message successfully received",
                'data' => [
                    'receiver_id' => $receiver_id,
                    'messages' => $data,
                ]
            ], 200);
        }catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
   }

}
