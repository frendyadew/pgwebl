@extends('layouts/template')

@section('content')
    <div class="container mt">
        <h3>Points</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Geom</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($points as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->geom_point }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>
                        <td>
                            <img src="{{ asset('storage/images/' . $p->image) }}"
                                alt="Photo of {{ $p->name }}. {{ $p->description }}" width="200">
                        </td>
                        <td>{{ $p->created_at }}</td>
                        <td>{{ $p->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Polylines</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Geom</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polylines as $pl)
                    <tr>
                        <td>{{ $pl->id }}</td>
                        <td>{{ $pl->geom_line }}</td>
                        <td>{{ $pl->name }}</td>
                        <td>{{ $pl->description }}</td>
                        <td>
                            <img src="{{ asset('storage/images/' . $pl->image) }}"
                                alt="Photo of {{ $pl->name }}. {{ $pl->description }}" width="200">
                        </td>
                        <td>{{ $pl->created_at }}</td>
                        <td>{{ $pl->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Polygons</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Geom</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polygons as $pg)
                    <tr>
                        <td>{{ $pg->id }}</td>
                        <td>{{ $pg->geom_polygon }}</td>
                        <td>{{ $pg->name }}</td>
                        <td>{{ $pg->description }}</td>
                        <td>
                            <img src="{{ asset('storage/images/' . $pg->image) }}"
                                alt="Photo of {{ $pg->name }}. {{ $pg->description }}" width="200">
                        </td>
                        <td>{{ $pg->created_at }}</td>
                        <td>{{ $pg->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
