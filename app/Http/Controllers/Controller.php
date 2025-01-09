<?php

namespace App\Http\Controllers;
/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="API Documentation UAS PAM Management Buku Perpustakaan",
     *      description="This is the API documentation for app Book Management",
     *      @OA\Contact(
     *          email="admin@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Use a token to access the endpoints",
     *     name="Authorization",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="bearerAuth",
     * )
 */
abstract class Controller
{
    //
}
