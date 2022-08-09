<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Http\Resources\UserResource;
use App\Models\Search;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'string|required|min:3'
        ]);

        $search = $request->get('search');
        $contacts = SearchResource::collection(
            Search::where('login', 'like', '%' . $search . '%')
                ->orWhere('full_name', 'like', '%' . $search . '%')
                ->where('user_id', '<>', Auth::id())
                ->with('user.avatar')
                ->orderBy('full_name', 'ASC')
                ->get()
        );

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts
        ]);
    }
}
