<table class="table table-striped">
    <tr>
        @foreach($headings as $heading)
            <th>
                {{ ucwords($heading) }}
            </th>
        @endforeach
    </tr>

    @foreach($data as $dataItem)
        <tr>
            @foreach($headings as $heading)

                <td>
                    {{  $dataItem[$heading] }}

                </td>

            @endforeach
        </tr>
    @endforeach

</table>