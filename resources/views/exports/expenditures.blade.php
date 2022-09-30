<table class="table user_table ">
    <thead class="table-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">مبلغ بالشيكل</th>
        <th scope="col">مبلغ بالدولار</th>
        <th scope="col">وصف</th>
        <th scope="col">تاريخ العملية</th>
    </tr>

    </thead>
    <tbody>
    @foreach($expenditures->where('is_delete',0) as $key => $expenditure)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$expenditure->amount_spent_ILS}}</td>
            <td>{{$expenditure->amount_spent_USD}}</td>
            <td>{{$expenditure->description}}</td>
            <td>{{$expenditure->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
