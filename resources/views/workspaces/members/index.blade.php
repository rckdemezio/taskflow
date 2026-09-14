<h1>
    Membros de {{ $workspace->name }}
</h1>

@foreach ($members as $member)
    <div>
        <strong>
            {{ $member->name }}
        </strong>

        <span>
            {{ $member->pivot->role }}
        </span>
    </div>
@endforeach
