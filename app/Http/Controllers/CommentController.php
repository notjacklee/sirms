<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Incident;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Incident $incident)
    {
        $user = auth()->user();

        // Only allow:
        // - admin
        // - assigned officer
        // - reporter who owns the incident
        if (
            $user->role !== 'admin' &&
            !($user->role === 'officer' && $incident->assigned_to == $user->id) &&
            !($user->role === 'reporter' && $incident->reporter_id == $user->id)
        ) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        Comment::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'message' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}