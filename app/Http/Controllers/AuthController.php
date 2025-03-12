<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\Auth\AuthRepositoryInterface;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @OA\Info(
     *      title="API Documentation",
     *      version="1.0.0"
     *  )
     * @OA\SecurityScheme(
     *      securityScheme="jwt_auth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT"
     * )
     * @OA\PathItem(
     *     path="/api/login"
     * )
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful login"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authRepository->login($credentials);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 401);
        }

        return response()->json($result, 200);
    }
}
