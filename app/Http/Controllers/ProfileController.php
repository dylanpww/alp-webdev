<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\ReservationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $reservations = ReservationModel::where('user_id', $request->user()->id)
            ->with(['room.type', 'rental'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'reservations' => $reservations,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function usersIndex(Request $request): View
    {
        $users = User::latest();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $users->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $users->get();

        return view('admin_view.users', compact('users'));
    }

    public function usersEdit($id): View
    {
        $user = User::findOrFail($id);
        return view('admin_view.users_edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:manager,receptionist,user',
        ]);
        $user->update([
            'role' => $request->role,
        ]);

        return Redirect::route('users.index');
    }
}
