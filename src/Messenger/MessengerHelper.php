<?php

namespace drhd\inbox\Messenger;

use drhd\inbox\models\Conversation;
use drhd\inbox\models\PrivateMessage;
use App\User;
use Illuminate\Support\Facades\DB;

class MessengerHelper {

    /**
     * Creates and returns a new private message object from the passed data.
     *
     * @param User $from sender of the private message
     * @param $message_subject
     * @param $message_text
     * @param Conversation $conversation the conversation to be linked to the message
     * @return PrivateMessage
     */
    public function createPrivateMessageObject(User $from, $message_text, $message_subject, Conversation $conversation): PrivateMessage {
        $privateMessage = new PrivateMessage();
        $privateMessage->private_message_text = $message_text;
        $privateMessage->private_message_subject = $message_subject;
        $privateMessage->conversation()->associate($conversation);
        $privateMessage->user()->associate($from);

        return $privateMessage;
    }

    /**
     * Checks if there is already a conversation between the sender and receiver of a private message. If that is a case
     * this method does nothing. Otherwise a new conversation is created and saved to the database.
     *
     * @param User $user_1
     * @param User $user_2
     */
    public function createConversationIfNecessary(User $user_1, User $user_2){
        if (!($this->conversationExists($user_1, $user_2))) {
            $this->createConversation($user_1, $user_2);
        }
    }

    /**
     * Creates a new conversation between the given users.
     * @param $user_1
     * @param $user_2
     */
    private function createConversation($user_1, $user_2) {
        $conversation = new Conversation();
        $conversation->save();
        $conversation->users()->attach($user_1);
        $conversation->users()->attach($user_2);
    }

    /**
     * Checks if there is an existing conversation between the passed users. Returns true or false.
     * @param $user_1
     * @param $user_2
     * @return bool
     */
    public function conversationExists($user_1, $user_2) {

        $exists = DB::select("SELECT EXISTS(SELECT 1
         FROM user_conversation AS a
                JOIN user_conversation AS b USING (fk_id_conversation)
         WHERE a.fk_id_user = (?)
           AND b.fk_id_user = (?)) as result;", [$user_1->id, $user_2->id]);

        $result = $exists[0]->result;

        if ($result === 1) return true;
        return false;
    }


    /**
     * Checks if there is a conversation that has this id as primary key. If that is the case the matching conversation is
     * returned. Otherwise MessengerException is thrown.
     * @param $id
     * @return Conversation
     * @throws MessengerException
     */
    public function conversationIdExists($id) : Conversation{

        $conversation = Conversation::find($id);
        if(is_null($conversation)) throw new MessengerException("This conversation does not exist.");
        return $conversation;

    }


}