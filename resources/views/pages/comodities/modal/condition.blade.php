@if ($data->condition === 1)
<td>
    <span class="badge badge-pill badge-info" data-toggle="tooltip" data-placement="top" title="Baik">Baru</span>
</td>
@elseif ($data->condition === 2)
<td>
    <span class="badge badge-pill badge-success" data-toggle="tooltip" data-placement="top" title="Kurang Baik">Baik</span>
</td>
@elseif ($data->condition === 3)
<td>
    <span class="badge badge-pill badge-danger" data-toggle="tooltip" data-placement="top" title="Rusak">Rusak</span>
</td>
@else
<td>
    <span class="badge badge-pill badge-dark" data-toggle="tooltip" data-placement="top" title="Hilang">Hilang</span>
</td>
@endif