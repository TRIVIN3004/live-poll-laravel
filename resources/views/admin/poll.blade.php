@extends('layouts.app')

@section('content')
<h3 class="mb-4">Admin – IP Management</h3>

<div class="card shadow-sm">
    <div class="card-body">
        @if(count($ips)==0)
            <p class="text-muted">No votes yet</p>
        @endif

        @foreach($ips as $v)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>{{ $v->ip_address }}</span>
                <button class="btn btn-danger btn-sm" onclick="rel('{{ $v->ip_address }}')">
                    Release
                </button>
            </div>
        @endforeach
    </div>
</div>

<script>
function rel(ip){
    $.post('/admin/release-ip',{
        _token:'{{csrf_token()}}',
        poll_id:{{$id}},
        ip:ip
    },()=>location.reload());
}
</script>
@endsection
