@extends('layouts.app')

@section('content')

    <div class="container">
        <section>
            <div>
                <b-jumbotron header="Online Courses" lead="Bootstrap v4 Components for Vue.js 2">
                    <p>Online Courses</p>
                    <b-button variant="info" href="{{ route('series.index') }}">Browse</b-button>
                </b-jumbotron>
            </div>
        </section>

        <section class="mb-5">
            <div>
                <b-row>
                    @foreach ($featuredSeries as $series)

                            <b-col cols="4" style="padding-top:1rem">
                                <a href="{{ route('series.show', $series->id) }}" class="text-decoration-none" style="color:black"><b-card title="{{ $series->title }}"
                                    img-src="{{ $series->image ? asset('storage/' . $series->image) : asset('vuef.jpg') }}"
                                    img-alt="Image" img-top>
                                    <b-card-text>
                                        {{ Str::limit($series->description, 60) }}
                                    </b-card-text>
                                    <template v-slot:footer>
                                        <b-button href="{{ route('series.show', $series->id) }}" variant="primary">Play
                                        </b-button>
                                    </template>
                                </b-card></a>
                            </b-col>

                    @endforeach
                </b-row>
            </div>
        </section>

        <section>
            <pricing></pricing>
        </section>
    </div>

@endsection
