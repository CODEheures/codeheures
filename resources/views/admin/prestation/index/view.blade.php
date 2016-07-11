<div class="prestation">
    @if(count($prestations)>0)
        <table>
            <tbody>
            @foreach($prestations as $prestation)
                <tr>
                    <td class="admin">
                        <i class="ion-minus-round"></i>
                        <a href="{{ route('admin.prestation.edit', ['id' => $prestation->id]) }}">
                            {{ $prestation->name }}
                        </a>
                        <span class="prestation-duration">{{ $prestation->duration }} h</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune prestation standard créée...</p>
    @endif
</div>