<h1>
    Projetos do Workspace: {{ $workspace->name }}
</h1>

@forelse ($projects as $project)
    <article>
        <h2>
            {{ $project->name }}
        </h2>
    </article>

@empty
    <p>Não há projetos neste workspace.</p>
@endforelse

{{ $projects->links() }}
