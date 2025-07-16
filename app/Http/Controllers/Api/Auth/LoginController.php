<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Get user roles
            $role = $user->roles->pluck('name')[0];

            if ($role == "client_user" && $user->status == 1) {
                $userCompany = Client::leftJoin('client_company', 'client_company.id', '=', 'clients.company_id')
                    ->where('clients.user_id', $user->id)
                    ->first();

                // Revoke all existing tokens for the user
                $user->tokens->each(function ($token) {
                    $token->revoke();
                });

                // Create new token
                $accessToken = $user->createToken('AuthToken')->accessToken;

                $token = $user->tokens->first();

                // Set last_login_at attribute
                $user->last_login_at = Carbon::now();

                // Save the user model to persist the changes to the database
                $user->save();

                return response()->json([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $role,
                        'company_id' => $userCompany->id,
                        'company_name' => $userCompany->name,
                        'company_address' => $userCompany->address,
                    ],
                    'access_token' => $accessToken,
                    'token_type' => 'Bearer',
                    'expires_in' => optional($token)->expires_at ? $token->expires_at->timestamp : null,
                ]);
            } else if (($role == "vendor_technician" && $user->status == 1) || ($role == "employee_technician" && $user->status == 1)) {
                if ($role == "vendor_technician") {
                    $userCompany = Vendor::leftJoin('vendor_company', 'vendor_company.id', '=', 'vendors.company_id')
                        ->where('vendors.user_id', $user->id)
                        ->first()
                    ;
                }

                // Revoke all existing tokens for the user
                $user->tokens->each(function ($token) {
                    $token->revoke();
                });

                // Create new token
                $accessToken = $user->createToken('AuthToken')->accessToken;

                $token = $user->tokens->first();

                // Set last_login_at attribute
                $user->last_login_at = Carbon::now();

                // Save the user model to persist the changes to the database
                $user->save();

                return response()->json([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $role,
                        'company_id' => ($role == "vendor_technician") ? $userCompany->id : 0,
                        'company_name' => ($role == "vendor_technician") ? $userCompany->name : 'Al Nabooda Chulia',
                        'company_address' => ($role == "vendor_technician") ? $userCompany->address : 'Al Nabooda Chulia',
                    ],
                    'access_token' => $accessToken,
                    'token_type' => 'Bearer',
                    'expires_in' => optional($token)->expires_at ? $token->expires_at->timestamp : null,
                ]);
            } else if (($role == "vendor_supervisor" && $user->status == 1) || ($role == "employee_supervisor" && $user->status == 1)) {
                if ($role == "vendor_supervisor") {
                    $userCompany = Vendor::leftJoin('vendor_company', 'vendor_company.id', '=', 'vendors.company_id')
                        ->where('vendors.user_id', $user->id)
                        ->first()
                    ;
                }

                // Revoke all existing tokens for the user
                $user->tokens->each(function ($token) {
                    $token->revoke();
                });

                // Create new token
                $accessToken = $user->createToken('AuthToken')->accessToken;

                $token = $user->tokens->first();

                // Set last_login_at attribute
                $user->last_login_at = Carbon::now();

                // Save the user model to persist the changes to the database
                $user->save();

                return response()->json([
                    'user' => [
                        'id'                => $user->id,
                        'name'              => $user->name,
                        'email'             => $user->email,
                        'role'              => $role,
                        'company_id'        => ($role == "vendor_supervisor") ? $userCompany->id : 0,
                        'company_name'      => ($role == "vendor_supervisor") ? $userCompany->name : 'Al Nabooda Chulia',
                        'company_address'   => ($role == "vendor_supervisor") ? $userCompany->address : 'Al Nabooda Chulia',
                    ],
                    'access_token'  => $accessToken,
                    'token_type'    => 'Bearer',
                    'expires_in'    => optional($token)->expires_at ? $token->expires_at->timestamp : null,
                ]);
            } else {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'The role of the user is not allowed to access the app.',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'The provided credentials are incorrect.',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
