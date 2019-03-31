@extends('layouts.app')

@section('content')

    <section class="container">

        @include("inbox::messageNotificationHandling")

        <div class="row">

            <div class="col-sm-4 border-right">
                @include("drhd.inbox.conversations")
            </div>

            <div class="col-sm-8">
                @include("drhd.inbox.conversation")
            </div>
        </div>

    </section>

@endsection
