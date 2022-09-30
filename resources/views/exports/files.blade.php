<table class="table user_table">
    <thead class="table-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">اسم الموظف</th>
        <th scope="col">تاريخ العملية</th>
        <th scope="col">رقم الملف</th>
        <th scope="col">اسم الزبون</th>
        <th scope="col">الصادر</th>
        <th scope="col">الوارد</th>
        @foreach($files->where('is_delete',0) as $key => $file)

        @if($file->updated_by == null)
        @else
            <th scope="col">تعديل بواسطة</th>
        @endif
        @endforeach

    </tr>

    </thead>
    <tbody>
    @foreach($files->where('is_delete',0) as $key => $file)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$file->UserFile->name}}</td>
            <td>{{$file->created_at}}</td>
            <td>{{$file->file_NO}}</td>
            <td>{{$file->client_name}}</td>
            <td>{{$file->outgoing}}</td>
            <td>{{$file->incoming}}</td>
            @if($file->updated_by == null)
            @else
                <td >{{$file->UserUpdateFile->name}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
