@extends('layouts.app')

@section('content')

<h3 class="mb-3">Cast Your Vote</h3>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <ul class="list-group" id="options"></ul>
        <div id="msg" class="mt-3 fw-bold"></div>
    </div>
</div>

<h4>Live Results</h4>
<ul class="list-group mb-5" id="results"></ul>

<script>
let voteToken = "{{ $voteToken }}";

$(document).ready(function () {

    // Load poll options
    $.get('/api/poll-options/{{$id}}', function (data) {
        let html = '';
        data.forEach(o => {
            html += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${o.option_text}
                <button
                    type="button"
                    class="btn btn-success btn-sm vote-btn"
                    data-option="${o.id}">
                    Vote
                </button>
            </li>`;
        });
        $('#options').html(html);
    });

    // Vote click (re-voting allowed)
    $(document).on('click', '.vote-btn', function () {

        $.post('/vote', {
            _token: '{{ csrf_token() }}',
            vote_token: voteToken,
            poll_id: {{$id}},
            option_id: $(this).data('option')
        }, function (res) {

            $('#msg')
                .text(res.msg)
                .removeClass()
                .addClass(res.status ? 'text-success fw-bold' : 'text-danger fw-bold');

            // 🔄 regenerate token for next vote
            voteToken = crypto.randomUUID();
        });
    });

    loadResults();
    setInterval(loadResults, 1000);
});

function loadResults() {
    $.get('/api/poll-results/{{$id}}', function (data) {
        let html = '';
        if (data.length === 0) {
            html = `<li class="list-group-item text-muted">No votes yet</li>`;
        } else {
            data.forEach(r => {
                html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Option ID ${r.option_id}
                    <span class="badge bg-primary">${r.total}</span>
                </li>`;
            });
        }
        $('#results').html(html);
    });
}
</script>

@endsection
