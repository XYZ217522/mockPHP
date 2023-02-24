@extends('layouts.app')

@section('content')

<title>Game Records</title>
<a href="/addRecord" role="button" style="position:absolute; top:0; right:0;margin: 20px">
    <span>add a record</span>
</a>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="display:flex">
            <table>
                <thead>
                <tr>
                    <th class="first_th">編號</th>
                    <th>活動ID</th>
                    <th>獲得獎金</th>
                    <th>資料建立時間</th>
                    <th>資料更新時間</th>
                </tr>
                </thead>

                @foreach ($gameRecords as $records)
                    <tr>
                        <td class="first_td">{{$records['id']}}</td>
                        <td>{{$records['event_id']}}</td>
                        <td>{{$records['got_money']}}</td>
                        <td>{{$records['create_date']}}</td>
                        <td>{{$records['update_date']}}</td>
{{--                        刪除區塊only admin--}}
{{--                        route('admin.record.delete', $records['id'])--}}
                        <td>
                            <form action="{{route('admin.record.delete', $records['id'])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

</div>

</body>

</html>
