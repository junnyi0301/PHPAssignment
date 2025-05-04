<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Events\UserDeleted;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user(); // Store the user instance first!
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

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

        // Fire the event BEFORE deletion so listeners can access the user data
        event(new UserDeleted($user));

        // Logout before deletion to prevent any session issues
        Auth::logout();

        // Delete the user
        $user->delete();

        // Clear the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }

    public function generateUserXML()
    {
        $users = \App\Models\User::all(); // or whatever model you're using

        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $root = $xml->createElement('users');

        foreach ($users as $user) {
            $userElement = $xml->createElement('user');

            $id = $xml->createElement('id', $user->id);
            $name = $xml->createElement('name', htmlspecialchars($user->name));
            $email = $xml->createElement('email', htmlspecialchars($user->email));
            $role = $xml->createElement('role', htmlspecialchars($user->role));
            $created_at = $xml->createElement('created_at', htmlspecialchars($user->created_at));

            $userElement->appendChild($id);
            $userElement->appendChild($name);
            $userElement->appendChild($email);
            $userElement->appendChild($role);
            $userElement->appendChild($created_at);

            $root->appendChild($userElement);
        }

        $xml->appendChild($root);

        $filePath = storage_path('app/users.xml');
        $xml->save($filePath);
    }

    public function showUserList()
    {
        $this->generateUserXML(); // Generate fresh XML from DB

        $xmlPath = storage_path('app/users.xml');
        $xslPath = public_path('storage/xsl/users.xsl');

        if (!file_exists($xmlPath) || !file_exists($xslPath)) {
            return response("Missing XML or XSL file.", 500);
        }

        $xml = new \DOMDocument();
        $xml->load($xmlPath);

        $xsl = new \DOMDocument();
        $xsl->load($xslPath);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xsl);

        $html = $proc->transformToXML($xml);

        return response($html)->header('Content-Type', 'text/html');
    }

    public function showUserListAdmin()
    {
        $this->generateUserXML(); // Generate fresh XML

        $xmlPath = storage_path('app/users.xml');
        $xslPath = public_path('storage/xsl/users.xsl');

        if (!file_exists($xmlPath) || !file_exists($xslPath)) {
            return response("Missing XML or XSL file.", 500);
        }

        $xml = new \DOMDocument();
        $xml->load($xmlPath);

        $xsl = new \DOMDocument();
        $xsl->load($xslPath);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xsl);

        $html = $proc->transformToXML($xml);

        // Send the result to a Blade view
        return view('admin.user-list', ['transformed' => $html]);
    }
}
