@extends('layouts.default')

@section('content')

    <section class="section is-first-box">

        @include("inbox::messageNotificationHandling")

        <div class="columns">

            <div class="column is-4">
                @include("inbox::conversations")
            </div>

            <div class="column is-8">
                @include("inbox::conversation")
            </div>
        </div>

    </section>

@endsection
