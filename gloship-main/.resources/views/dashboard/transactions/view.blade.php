@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card mt-3 mb-3">
        <div class="card-body">
            <div class="row">
                <h4 class="col-md-12 text-left text-uppercase">
                    <b class="text-success">{{ trans_choice('messages.Transaction_Detail', 1) }}

                    </b>
                </h4>
                <hr>
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
                            <tr>
                                <th style="vertical-align: top;padding: 10px;">
                                    {{ trans_choice('messages.Payment_Method', 1) }}</th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>
                                        {{ $transaction->gateway }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Reference', 1) }}
                                </th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>
                                        {{ $transaction->payment_id }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Invoice', 1) }}
                                </th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>{{ $transaction->invoice_id }}</b>
                                </td>
                            </tr>

                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Description', 1) }}
                                </th>
                                <td style="vertical-align: top;padding: 10px;">
                                    @lang('messages.Payment_For_Shipment') :
                                    @php
                                        $code = \App\Models\Shipment::where('invoice_id', $transaction->invoice_id)->value('code');
                                    @endphp
                                    <a href="{{ route('dashboard.shipments.view', ['id' =>  $code]) }}"> <b>{{ $code }}</b></a>
                                   
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ __('messages.Status') }}</th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>{{ $transaction->payment_status }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top; padding: 10px;">{{ trans_choice('messages.Customer', 1) }}
                                </th>
                                <td style="vertical-align: top; padding: 10px;">
                                    @php
                                        $user = \App\Models\User::where('id', $transaction->owner_id)->first();
                                        $url = route('dashboard.users.view', ['id' => $transaction->owner_id]);
                                        
                                        if ($user) {
                                            echo '<div class="team"> <a href="' . $url . '" class="team-member"> <b>' . $user->firstname . ' ' . $user->lastname . '</b> (' . $user->username . ') </a> </div>';
                                        }
                                    @endphp

                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Currency', 1) }}
                                </th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>{{ $transaction->currency }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top; padding: 10px;">{{ trans_choice('messages.Amount', 1) }}
                                </th>
                                <td style="vertical-align: top; padding: 10px;">
                                    <b>{{ $transaction->amount }}</b>
                                </td>
                            </tr>

                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Email', 1) }}</th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>{{ $transaction->payer_email }}</b>
                                </td>
                            </tr>

                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Branch', 1) }}
                                </th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b>{{ \App\Models\Branches::where('id', $transaction->branch)->value('name') }}</b>
                                   
                                </td>
                            </tr>

                            <tr>
                                <th style="vertical-align: top;padding: 10px;">{{ trans_choice('messages.Date', 1) }}</th>
                                <td style="vertical-align: top;padding: 10px;">
                                    <b> <x-date-time-zone :date="\Carbon\Carbon::parse($transaction->created_at)" format="Y-m-d H:i:s"/> </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
