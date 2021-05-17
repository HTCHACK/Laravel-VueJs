@extends('layouts.app')

@section('content')
    <b-container>
        <section class="mb-5">
            <div>
                {{$series->links()}}
                <b-row>
                    @foreach ($series as $se)
                        <b-col cols="4" style="padding-top:1rem">
                            <a href="{{route('series.show',$se->id)}}" class="text-decoration-none" style="color:black"><b-card title="{{ $se->title }}" img-src="{{$se->image? asset('storage/'.$se->image) : asset('vuef.jpg')}}" img-alt="Image" img-top >
                                <b-card-text>
                                    {{ Str::limit($se->description, 60) }}
                                </b-card-text>
                                <template v-slot:footer>
                                    <b-button href="{{route('series.show',$se->id)}}" variant="primary">Play</b-button>
                                </template>
                            </b-card></a>
                        </b-col>
                    @endforeach
                </b-row>
            </div>
        </section>
    </b-container>

@endsection

