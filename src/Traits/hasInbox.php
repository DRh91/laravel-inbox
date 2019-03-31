<?php

namespace drhd\inbox\Traits;

use drhd\inbox\models\Conversation;
use drhd\inbox\models\PrivateMessage;

trait hasInbox {

    /**
     * Checks if this user has unread messages in any of his conversations.
     * @return bool
     */
    public function hasUnreadMessages() {
        /** @var Conversation $conversation */
        foreach ($this->conversations as $conversation) {
            if ($conversation->getNumberOfUnreadMessages() > 0) return true;
        }
        return false;
    }


    /** Get the private messages associated with the user.
     * one-to-many relationship between User and PrivateMessage
     */
    public function privateMessages() {
        return $this->hasMany(PrivateMessage::class, 'fk_id_user_sender');
    }

    /** Get the conversations associated with this user - many-to-many relationship between Conversation and User */
    public function conversations() {
        return $this->belongsToMany(Conversation::class, 'user_conversation', 'fk_id_user', 'fk_id_conversation')
                    ->withPivot('last_read')
                    ->orderBy('updated_at', 'desc');
    }




}