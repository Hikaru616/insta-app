<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user) {

        $this->user = $user;
    }

    public function show($id) {

        $user = $this->user->findOrFail($id);

        return view('users.profile.show')
                ->with('user', $user);
    }

    public function edit() {

        $user = $this->user->findOrFail(Auth::user()->id);

        return view('users.profile.edit')
                ->with('user', $user);
    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpg,jpeg,gif,png|max:1048',
            'introoduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if($request->avatar) {
            $user->avatar = 'data:avatar/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('profile.show', $user->id);
    }

    public function followers($id) {

        $user = $this->user->findOrFail($id);

        return view('users.profile.followers')
                ->with('user',$user);
    }

    public function following($id) {

        $user = $this->user->findOrFail($id);

        return view('users.profile.following')
                ->with('user',$user);
    }

    private function getSuggestedUsers() {

        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if(!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return $suggested_users;
    }

    public function suggestion($id) {

        $suggested_users = $this->getSuggestedUsers();
        $user = $this->user->findOrFail($id);

        return view('users.profile.suggestions')
                ->with('suggested_users', $suggested_users)
                ->with('user', $user);
    }

    public function pass($id) {

        $user = $this->user->findOrFail($id);

        return view('users.profile.pass')
                ->with('user',$user);
    }

    public function editpass(Request $request) {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'con_password' => 'required|same:new_password'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        // 現在のパスワードが正しいかチェック
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'incorrect current pass']);
        }

        // 新しいパスワードをハッシュ化して保存
        if (Hash::check($request->current_password, $user->password)) {
        if($request->new_password === $request->con_password) {

            $user->password = Hash::make($request->new_password);
            $user->save();
        }}

        $details = [
            'name' => $user->name,
            'app_url' =>config('app.url')
        ];

        //Send an email to the user.
        Mail::send('users.emails.changepass',$details, function($message) use ($user) {
            $message->from(config('mail.from.address'), config('app.name'))
                    ->to($user->email, $user->name)
                    ->subject('Changed password');
        });

        return redirect()->route('index')->with('success', 'changed Pass successfully');

    }
}
