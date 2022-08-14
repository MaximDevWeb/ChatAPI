<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\ContactCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResourse;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contacts = Auth::user()
            ->contacts()
            ->with('contact_user')
            ->with('contact_user.avatar')
            ->get();

        return response()->json([
            'status' => 'success',
            'contacts' => ContactResourse::collection($contacts)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'contact_id' => 'integer'
        ]);

        Auth::user()->contacts()->create($request->all());

        broadcast(
            new ContactCreated(
                Auth::user()->login,
                $request->get('contact_id')
            )
        )->toOthers();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function destroy(int $id): JsonResponse
    {
        $contact = Contact::find($id);

        if ($contact->user_id === Auth::id()) {
            $contact->delete();

            return response()->json([
                'status' => 'success',
            ]);
        }

        throw ValidationException::withMessages([
            'delete' => ['Это не ваш контакт'],
        ]);
    }
}
