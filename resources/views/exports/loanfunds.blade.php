<table class="table user_table text-center">
    <thead class="table-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">المضاف بالشيكل</th>
        <th scope="col">الباقي بالشيكل</th>
        <th scope="col">تاريخ العملية</th>
    </tr>

    </thead>
    <tbody>
    @foreach($loans as $key => $loan)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$loan->loan_amount}}</td>
            <td class="table-active">{{$loan->amount}}</td>
            <td>{{$loan->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
