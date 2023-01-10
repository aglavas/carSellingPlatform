<?php

/**
 * @OA\Schema(
 *     schema="ErrorSchema",
 *     required={"error"},
 *     @OA\Property(
 *         property="error",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                property="type",
 *                type="string",
 *             ),
 *             @OA\Property(
 *                property="field",
 *                type="string",
 *             ),
 *             @OA\Property(
 *                property="message",
 *                type="string",
 *             ),
 *         )
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="ValidationSchema",
 *     required={"error_key", "error_message", "code", "errors"},
 *     @OA\Property(
 *         property="error",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                property="type",
 *                type="string",
 *             ),
 *             @OA\Property(
 *                property="field",
 *                type="string",
 *             ),
 *             @OA\Property(
 *                property="message",
 *                type="string",
 *             ),
 *         )
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="SuccessMessageSchema",
 *     required={"stauts", "message"},
 *     @OA\Property(
 *         property="status",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     ),
 * )
 */

/**
 * @OA\Schema(
 *     schema="ErrorMessageSchema",
 *     required={"stauts", "message"},
 *     @OA\Property(
 *         property="status",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     ),
 * )
 */
