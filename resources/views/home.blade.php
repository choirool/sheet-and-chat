@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            <div class="text-center">
                                <a class="btn btn-lg btn-primary" href="{{ route('sheets.create') }}">Create new spreadsheet</a>
                            </div>

                            <div class="list-group">
                                @if($sheets = \Auth::user()->sheets)
                                    @foreach($sheets as $sheet)
                                        <a href="/sheets/{{ $sheet->id }}" class="list-group-item">
                                            {{ $sheet->name }}
                                        </a>
                                        <form action="{{ route('sheets.destroy', ['sheet' => $sheet->id]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection