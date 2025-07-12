<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Vendor",
 *     description="Manajemen vendor oleh user dengan role vendor"
 * )
 */
class VendorController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/vendors",
     *     tags={"Vendor"},
     *     summary="Registrasi vendor oleh user",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"company_name"},
     *             @OA\Property(property="company_name", type="string", example="CV Teknologi Nusantara"),
     *             @OA\Property(property="address", type="string", example="Jl. Merdeka No. 123"),
     *             @OA\Property(property="phone", type="string", example="081234567890"),
     *             @OA\Property(property="npwp_number", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vendor berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Vendor registered successfully."),
     *             @OA\Property(property="vendor", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Vendor sudah ada untuk user ini",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Vendor already registered.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi input gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed."),
     *             @OA\Property(property="error", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'npwp_number' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if ($user->vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor already registered.'
            ], 409);
        }

        $vendor = Vendor::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'npwp_number' => $request->npwp_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor registered successfully.',
            'vendor' => $vendor,
        ]);
    }
}
