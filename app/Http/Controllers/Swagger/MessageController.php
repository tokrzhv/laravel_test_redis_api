<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Example for response examples value",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * )
 * @OA\Post(
 *     path="/api/messages/send",
 *     summary="Send a new message to the receiver",
 *     description="Endpoint to add a new message to the redis store",
 *     operationId="createMessage",
 *     tags={"Messages"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Message data",
 *         @OA\JsonContent(
 *             required={"receiver_number", "content"},
 *             @OA\Property(property="receiver_id", type="integer", description="id of the receiver", example="1"),
 *             @OA\Property(property="content", type="string", description="message content", minimum=2, maximum=255, example="Some content")
 *         )
 *     ),
 *     @OA\Response(
 *         response="201",
 *         description="Message sent successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Message successfully sent"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="receiver_id", type="integer", example="1"),
 *                 @OA\Property(property="content", type="string", example="Some content"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="receiver_id", type="object",example={"The receiver id field is required.", "The receiver id must be an integer."}),
 *                 @OA\Property(property="content", type="object", example={"The content field is required.", "The content must be at least 2 characters.", "The content may not be greater than 255 characters."}),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Receiver id does not exist",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Receiver with the requested identifier does not exist")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error, unable to create the item",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Server error occurred"),
 *             @OA\Property(property="details", type="string", example="An unexpected error occurred while processing the request.")
 *         )
 *     ),
 * ),
 *
 * @OA\Get(
 *     path="/api/messages/{receiver_id}",
 *     summary="Retrieve a specific messages by receiver_id",
 *     description="Endpoint to fetch a specific message by receiver_id",
 *     operationId="getMessageByReceiver_Id",
 *     tags={"Messages"},
 *     @OA\Parameter(
 *         name="receiver_id",
 *         in="path",
 *         required=true,
 *         description="ID of the receiver",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *             example="1"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Message successfully received"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="receiver_id", type="integer", example="1"),
 *                 @OA\Property(property="messages", type="object",
 *                     @OA\Property(property="content", type="string", example="Some content"),
 *                 ),
 *             ),
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="receiver_id", type="object",example={"The receiver id must be an integer."}),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Message for the receiver does not exist",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Messages with the receiver identifier does not exist'"),
 *             @OA\Property(
 *                 property="error",
 *                 type="object",
 *                 @OA\Property(property="receiver_id", type="object",example={"Messages not found or deleted"}),
 *             ),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error, unable to create the item",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Server error occurred"),
 *             @OA\Property(property="details", type="string", example="An unexpected error occurred while processing the request.")
 *         )
 *     ),
 * )
 *
 */
class MessageController extends Controller
{
    //
}
