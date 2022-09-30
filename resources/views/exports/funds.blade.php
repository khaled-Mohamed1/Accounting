<table class="table user_table text-center">
    <thead class="table-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">المضاف بالدولار</th>
        <th scope="col">الباقي بالدولار</th>
        <th scope="col">المضاف بالشيكل</th>
        <th scope="col">الباقي بالشيكل</th>
        <th scope="col">تاريخ العملية</th>
    </tr>
    </thead>
    <tbody>
    @foreach($funds->where('is_delete',0) as $key => $fund)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$fund->financial_USD}}</td>
            <td class="table-active">{{$fund->financial_amount_USD}}</td>
            <td>{{$fund->financial_ILS}}</td>
            <td class="table-active">{{$fund->financial_amount_ILS}}</td>
            <td>{{$fund->created_at}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
