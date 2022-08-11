<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchResource;
use App\Http\Resources\UserResource;
use App\Models\Search;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

        $old_contacts =  Auth::user()->contacts()->pluck('contact_id');

        $contacts = SearchResource::collection(
            Search::where(function (Builder $query) use ($search) {
                $query->where('login', 'like', '%' . $search . '%');
                $query->orWhere('full_name', 'like', '%' . $search . '%');
            })
                ->where('user_id', '<>', Auth::id())
                ->whereNotIn('user_id', $old_contacts)
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
