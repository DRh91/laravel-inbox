{{--
There is one parameter passed to this view: $user (receiver). When $user is set this means, that a direct message is sent -
the input of a user name (name of the receiver) is no longer necessary. Additionally the user will NOT be redirected to /inbox
after submitting the message.
 --}}

@include("inbox::messageNotificationHandling")

<div class="box">

    {{ Form::open(array('route' => 'inbox.store')) }}


    {{--    Input of message subject    --}}

    <div class="field">
        <label class="label">{{ Form::label('private_message_subject', 'Betreff') }}</label>
        <div class="control">
            {{ Form::text('private_message_subject', '', ['id' => 'private_message_subject', 'class' => 'input is-medium', 'placeholder' => 'Betreff (optional)']) }}
        </div>
    </div>


    {{--    receiver name input    --}}

    {{-- When $user is set this means, that a direct message is sent - the input of a user name is no longer necessary --}}
    @if(isset($user))
        {{-- Nevertheless the user name needs to be passed as a post parameter. So the name is stored in a hidden input. --}}
        <input type="hidden" value="{{ $user->name }}" name="receiver_name">
    @else
        <div class="field">
            <label class="label">{{ Form::label('receiver_name', 'Benutzername des Empfängers') }}</label>
            <div class="control">
                {{ Form::text('receiver_name', '', ['id' => 'receiver_name', 'class' => 'input is-medium', 'placeholder' => 'Benutzername des Empfängers']) }}
                @include("inbox::alert", ['field' => "receiver_name"])
            </div>
        </div>
    @endif


    {{--    Input of message text    --}}

    <div class="field">
        <label class="label">{{ Form::label('private_message_text', 'Nachricht') }}</label>
        <div class="control">
            {{ Form::textarea('private_message_text', '', ['id' => 'private_message_text', 'class' => 'textarea is-medium', 'placeholder' => 'Nachricht', 'rows' => 5 ])}}
            @include("inbox::alert", ['field' => "private_message_text"])
        </div>
    </div>


    {{-- optional redirect to inbox --}}

    @if(isset($user_receiver))
        <input type="hidden" value="true" name="redirect-to-inbox">
    @endif


    {{--    Submit    --}}

    <div class="field is-grouped">
        <div class="control">
            {{ Form::submit('Absenden', ['class' => 'button is-primary']) }}
        </div>
    </div>

    {!! Form::close() !!}
</div>

