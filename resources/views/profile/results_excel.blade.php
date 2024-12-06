<table>
    <thead>
        <tr>
            <th>Utilisateur</th>
            <th>Score</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $result->score }}</td>
                <td>{{ $result->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
        
        @if($results->isEmpty())
            <tr>
                <td colspan="3">Aucun score enregistré.</td>
            </tr>
        @endif
    </tbody>
</table>