<?php

namespace drhd\inbox\models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //id is the only attribute
    ];

    /** Get the private messages associated with this conversation  - one-to-many relationship between Conversation and PrivateMessage */
    public function privateMessages() {
//        return $this->hasMany('App\PrivateMessage', 'fk_id_conversation')
//                    ->orderBy('created_at', 'desc');

        return $this->hasMany(PrivateMessage::class, 'fk_id_conversation')
                    ->orderBy('created_at', 'desc');
    }

    /** Get the users associated with this conversation - many-to-many relationship between Conversation and User */
    public function users() {
        return $this->belongsToMany(User::class, 'user_conversation', 'fk_id_conversation', 'fk_id_user')
                    ->withPivot('last_read');
    }

    /**
     * Returns all unread messages of this conversation of the currently logged in user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadMessages() {
        $last_read = $this->pivot->last_read;
        $id_user = Auth::id();

        $messages = $this->privateMessages()
                         ->where('created_at', '>', $last_read)
                         ->where('fk_id_conversation', $this->id)
                         ->where('fk_id_user_sender', '!=', $id_user)
                         ->get();

        return $messages;
    }

    /**
     * Returns the number of unread messages of this conversation of the currently logged in user
     * @return int
     */
    public function getNumberOfUnreadMessages() {
        return sizeof($this->getUnreadMessages());
    }


    /**
     * Returns the last PrivateMessage that was added to this conversation
     * @return PrivateMessage
     */
    public function getLastMessage() {
        return $this->privateMessages->sortBy('created_at')->last();
    }


    /**
     * Returns the user-object of the conversation partner depending on the logged in user
     * Example:
     * <li>User "A" has a conversation with User "B"</li>
     * <li>Case 1: currently logged in user is "A". This method returns user "B"</li>
     * <li>Case 2: currently logged in user is "B". This method returns user "A"</li>
     * @return User
     */
    public function getConversationPartner() {

        $user = Auth::user();

        $users = $this->users;

        $index = 0;
        foreach ($users as $participant) {
            if ($participant->name === $user->name) break;
            $index++;
        }

        if ($index === 1) return $users[0];
        return $users[1];
    }

    /**
     * Marks this conversation as read by the currently logged in user. Resets the counter of unread messages concerning
     * this conversation.
     */
    public function markAsRead(){
        $user = Auth::user();
        $this->users()->updateExistingPivot($user->id, ['last_read' => now()]);
    }

}
