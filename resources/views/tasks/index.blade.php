<h1>
    Tasks do Projeto: {{ $project->name }}
</h1>

@forelse ($tasks as $task)
    <article>
        <h2>
            {{ $task->name }}
        </h2>
    </article>
@empty
    <p>Não há tasks neste projeto.</p>
@endforelse
