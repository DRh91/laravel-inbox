<?php

namespace drhd\inbox\models;


use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fk_id_user_sender', 'private_message_text', 'fk_id_conversation',
    ];

    /**
     * Get the user that wrote this message.
     * one-to-many relationship between User and Message
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'fk_id_user_sender');
    }

    /** Get the conversation that this message was written in - one-to-many relationship between Message and Conversation */
    public function conversation(){
        return $this->belongsTo(Conversation::class, 'fk_id_conversation');
    }
}
