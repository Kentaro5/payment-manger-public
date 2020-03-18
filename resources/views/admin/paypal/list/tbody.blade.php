<tbody>
    @foreach( $paypal_plan_lists as $paypal_plan_list )
    <tr role="row" class="odd">
        <td class="sorting_1">{{ $paypal_plan_list->id }}</td>
        <td>{{ $paypal_plan_list->title }}</td>
        <td>{{ $paypal_plan_list->payment_amount }}</td>
        <td>{{ $paypal_plan_list->type }}</td>
        <td>{{ $paypal_plan_list->url_pass }}</td>
        <td>
            <a href="{{ $paypal->path() }}/edit/{{ $paypal_plan_list->id }}" title="">
                <button type="button" class="btn btn btn-block btn-success" style="margin-bottom: 10px;width: 50px;">編集</button>
            </a>
        </td>
        <td>
            <form action="{{ $paypal->path() }}/delete/{{ $paypal_plan_list->id }}" method="post" accept-charset="utf-8">
                @csrf
                <button type="submit" class="btn btn-block btn-danger" style="margin-bottom: 10px;width: 50px;">削除</button>
            </form>
        </td>
    </tr>
    @endforeach

</tbody>

