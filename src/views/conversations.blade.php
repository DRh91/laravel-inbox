<div class="">

    <h3 class="">Deine Unterhaltungen</h3>

    @if(sizeof($user->conversations) == 0)
        <span>Noch keine Unterhaltungen vorhanden.</span>
    @endif

    @foreach($user->conversations as $conversation)

        <a href="/inbox/{{$conversation->id}}">

            <div class="card">
                <div class="card-body">

                    {{-- communication partner and unread messages --}}

                    <div class="">
                        @if($conversation->getNumberOfUnreadMessages() > 0)
                            <strong>{{$conversation->getConversationPartner()->name}}</strong>
                        @else
                            <span>{{$conversation->getConversationPartner()->name}}</span>
                        @endif

                        {{--number of unread mesages--}}
                        <div class="">
                            @if($conversation->getNumberOfUnreadMessages($user) > 0)
                                <i class=""></i>
                                <strong> {{$conversation->getNumberOfUnreadMessages($user)}}</strong>
                            @else
                                <i class=""></i>
                            @endif
                        </div>


                    </div>

                    <small class="">Letzte
                        Nachricht: {{$conversation->getLastMessage()->created_at->format('d.m.y H:i')}}
                        von {{$conversation->getLastMessage()->user->name}}</small>
                </div>
            </div>
        </a>

    @endforeach

    <hr class="">

    <div id="button-new-message-container" class="has-text-centered">
        <a href="/inbox/create" class="btn-success p-2 ">Nachricht schreiben</a>
    </div>


</div>
