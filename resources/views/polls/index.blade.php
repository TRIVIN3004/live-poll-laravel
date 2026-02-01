@extends('layouts.app')

@section('content')
<h3 class="mb-4">Active Polls</h3>

<div class="row" id="polls"></div>

<script>
$.get('/api/active-polls', function (data) {
    let html = '';

    if (data.length === 0) {
        html = `<p class="text-muted">No active polls available</p>`;
    }

    data.forEach(p => {
        html += `
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card poll-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${p.question}</h5>
                    <a href="/poll/${p.id}" class="btn btn-primary btn-sm">
                        Vote Now
                    </a>
                </div>
            </div>
        </div>`;
    });

    $('#polls').html(html);
});
</script>
@endsection
