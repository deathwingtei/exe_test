@extends('layout')

@section('content')
<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Log Table</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Table</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                            
                                    @php($i = $num)
                                
                                    @foreach($logs as $log)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$log->table}}</td>
                                        <td>{{$log->commend}}</td>
                                        <td>
                                            @if($log->created_at)
                                                {{Carbon\Carbon::parse($log->created_at)->diffForHumans()}}
                                            @else
                                            
                                            @endif
                                        </td>
                                    </tr>
                                    @php($i++)
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator )
                                {{ $logs->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection