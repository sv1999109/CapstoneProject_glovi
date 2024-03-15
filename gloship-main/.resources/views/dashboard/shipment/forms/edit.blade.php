@php
    
    // branches
    $sending_branch = DB::table('branches')
        ->where('state', $shipment->sender_state)
        ->get();
    $receiving_branch = DB::table('branches')
        ->where('state', $shipment->receiver_state)
        ->get();
    
    //fetch shipment logs
    if (isset($shipment)) {
        $logs = App\Models\ShipmentLog::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    }
    
    //fetch packages
    if (isset($shipment)) {
        $packages = App\Models\Packages::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    }
    
    $user_lang = LaravelLocalization::getCurrentLocale();
    
@endphp
@csrf


{{-- .card --}}

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 100%">

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="address-tab-a" data-bs-toggle="tab" data-bs-target="#address-tab"
                    type="button" role="tab" aria-controls="address-tab"
                    aria-selected="true">@lang('messages.Contacts')</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="package-tab-a" data-bs-toggle="tab" data-bs-target="#package-tab"
                    type="button" role="tab" aria-controls="package-tab"
                    aria-selected="true">{{ trans_choice('messages.Package', 2) }}</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="shipment-tab-a" data-bs-toggle="tab" data-bs-target="#shipment-tab"
                    type="button" role="tab" aria-controls="shipment-tab"
                    aria-selected="false">@lang('messages.Shipment_Info')</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="status-tab-a" data-bs-toggle="tab" data-bs-target="#status-tab"
                    type="button" role="tab" aria-controls="status-tab"
                    aria-selected="false">@lang('messages.Status_Note')</button>
            </li>

        </ul>
        
        <div class="tab-content" id="myTabContent">

            <!-- Address Tab -->
            <div class="tab-pane fade show active" id="address-tab" role="tabpanel" aria-labelledby="address-tab"
                tabindex="0">
                {{-- Sender Info --}}
                <div class="card">
                    <div class="row card-body">
                        <h3 class="col-md-12 text-left">@lang('messages.Sender_Info')</h3>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Name') }}</label>
                                <input type="text"
                                    value="{{ old('sender_name', isset($shipment) ? $shipment->sender_name : '') }}"
                                    placeholder="{{ __('messages.Name') }}" name="sender_name"
                                    class="form-control @error('sender_name') is-invalid @enderror" />
                                @error('sender_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="sender_phone" class="form-label required">{{ __('messages.Phone') }}</label>

                                <input type="text"
                                    value="{{ old('sender_phone', isset($shipment) ? $shipment->sender_phone : '') }}"
                                    placeholder="{{ __('messages.Phone') }}" name="sender_phone"
                                    class="form-control @error('sender_phone') is-invalid @enderror"
                                    id="sender_phone" />


                                @error('sender_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Email') }}</label>
                                <input type="email"
                                    value="{{ old('sender_email', isset($shipment) ? $shipment->sender_email : '') }}"
                                    placeholder="{{ __('messages.Email') }}" name="sender_email"
                                    class="form-control @error('sender_email') is-invalid @enderror" />
                                @error('sender_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label required">{{ trans_choice('messages.Address', 1) }}</label>
                                <input type="text"
                                    value="{{ old('sender_address', isset($shipment) ? $shipment->sender_address : '') }}"
                                    placeholder="{{ trans_choice('messages.Address', 1) }}" name="sender_address"
                                    class="form-control @error('sender_address') is-invalid @enderror" />
                                @error('sender_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Origin') }}</label>
                                <input readonly type="text"
                                    value="{{ old('sender_origin', isset($shipment) ? get_dataBy_id($shipment->sender_state, 'states', 'name') . '-' . get_dataBy_id($shipment->sender_country, 'countries', 'name') : '') }}"
                                    name="sender_origin"
                                    class="form-control @error('sender_origin') is-invalid @enderror" disabled />
                                @error('sender_origin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Sending_Branch') }}</label>
                                <select name="from_branch" class="form-select" id="from_branch">
                                    <option value="">@lang('messages.Select')</option>
                                    @foreach ($sending_branch as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('from_branch') == $branch->id ? 'selected' : '' }}
                                            {{ $shipment->from_branch == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}</option>
                                        @php
                                            $branch_exist = 1;
                                        @endphp
                                    @endforeach
                                </select>
                                @if (!isset($branch_exist))
                                    <p class="mt-3">
                                        @lang('messages.No_Branch_Found_In_Region')
                                        <br>
                                        <a class="btn btn-primary m-1"
                                            href="{{ route('dashboard.branch.add.link', ['country' => urlencode($shipment->sender_country), 'state' => urlencode($shipment->sender_state)]) }}">
                                            <ion-icon name="add-outline"></ion-icon> @lang('messages.Add_Branch')
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Receiver Info --}}
                <div class="card">
                    <div class="row card-body">
                        <h2 class="col-md-12 text-left">@lang('messages.Receiver_Info')</h2>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Name') }}</label>
                                <input type="text"
                                    value="{{ old('receiver_name', isset($shipment) ? $shipment->receiver_name : '') }}"
                                    placeholder="{{ __('messages.Name') }}" name="receiver_name"
                                    class="form-control @error('receiver_name') is-invalid @enderror" />
                                @error('receiver_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Phone') }}</label>
                                <input type="text"
                                    value="{{ old('receiver_phone', isset($shipment) ? $shipment->receiver_phone : '') }}"
                                    placeholder="{{ __('messages.Phone') }}" name="receiver_phone"
                                    class="form-control @error('receiver_phone') is-invalid @enderror" />
                                @error('receiver_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ trans_choice('messages.Address', 1) }}</label>
                                <input type="text"
                                    value="{{ old('receiver_address', isset($shipment) ? $shipment->receiver_address : '') }}"
                                    placeholder="{{ __('messages.Address') }}" name="receiver_address"
                                    class="form-control @error('receiver_address') is-invalid @enderror" />
                                @error('receiver_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Email') }}</label>
                                <input type="email"
                                    value="{{ old('receiver_email', isset($shipment) ? $shipment->receiver_email : '') }}"
                                    placeholder="{{ __('messages.Email') }}" name="receiver_email"
                                    class="form-control @error('receiver_email') is-invalid @enderror" />
                                @error('receiver_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Destination') }}</label>
                                <input readonly type="text"
                                    value="{{ old('receiver_origin', isset($shipment) ? get_dataBy_id($shipment->receiver_state, 'states', 'name') . '-' . get_dataBy_id($shipment->receiver_country, 'countries', 'name') : '') }}"
                                    name="receiver_origin"
                                    class="form-control @error('receiver_origin') is-invalid @enderror" disabled />
                                @error('receiver_origin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Receiving_Branch') }}</label>

                                <select name="to_branch" class="form-select" id="to_branch">
                                    <option value="">@lang('messages.Select')</option>
                                    @foreach ($receiving_branch as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $shipment->to_branch == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}</option>
                                        @php
                                            $branch_exist2 = 1;
                                        @endphp
                                    @endforeach
                                </select>
                                @if (!isset($branch_exist2))
                                    <p class="mt-3">
                                        @lang('messages.No_Branch_Found_In_Region')
                                        <br>
                                        <a class="btn btn-primary m-1"
                                            href="{{ route('dashboard.branch.add.link', ['country' => urlencode($shipment->receiver_country), 'state' => urlencode($shipment->receiver_state)]) }}">
                                            <ion-icon name="add-outline"></ion-icon> @lang('messages.Add_Branch')
                                        </a>
                                    </p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// Address Tab -->

            <!-- Package Info -->
            <div class="tab-pane fade" id="package-tab" role="tabpanel" aria-labelledby="package-tab"
                tabindex="0">
                <div class="card">
                    <div class="row card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th style="width: 50%"
                                            class="pl-0 font-weight-bold text-muted text-uppercase">
                                            @lang('messages.Description')</th>
                                            <th class="text-right  text-muted text-uppercase">@lang('messages.Length_CM')</th>
                                            <th class="text-right  text-muted text-uppercase">@lang('messages.Width_CM')</th>
                                            <th class="text-right  text-muted text-uppercase">@lang('messages.Height_CM')</th>
                                        <th class="text-right  text-muted text-uppercase">@lang('messages.Weight_Kg')</th>
                                        <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Quantity')</th>
                                        <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Declared_Value')</th>
                                        <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr class="font-weight-boldest">
                                            <td style="width: 50%"><strong> {{ $package->description }}</strong></td>
                                            <td> {{ $package->length }}</td>
                                            <td> {{ $package->width }}</td>
                                            <td> {{ $package->height }}</td>
                                            <td> {{ $package->weight }}</td>
                                            <td> {{ $package->qty }}</td>
                                            <td> {{ get_money($package->value, $shipment->currency, 'symbol', 'localize') }}
                                            </td>
                                           
                                            <td>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#package-edit-{{ $package->id }}"
                                                    href="#{{ $package->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <span>-</span>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#package-delete-{{ $package->id }}"
                                                    href="#">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                       

                        <div class="col-md-4 ms-auto">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Subtotal') }}</label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                    <input min="0.00" step="any" placeholder="@lang('messages.Subtotal')"
                                        type="number"
                                        value="{{ old('subtotal', isset($shipment) ? get_money($shipment->subtotal, $shipment->currency, 'input', 'localize') : 0.0) }}"
                                        class="form-control @error('subtotal') is-invalid @enderror"
                                        name="subtotal" />
                                    @error('subtotal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Tax') }}</label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                    <input min="0.00" step="any" placeholder="@lang('messages.Tax')"
                                        type="number"
                                        value="{{ old('tax', isset($shipment) ? get_money($shipment->tax, $shipment->currency, 'input', 'localize') : 0.0) }}"
                                        class="form-control @error('tax') is-invalid @enderror" name="tax" />
                                    @error('tax')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Discount') }}</label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                    <input min="0.00" step="any" placeholder="@lang('messages.Discount')"
                                        type="number"
                                        value="{{ old('discount', isset($shipment) ? get_money($shipment->discount, $shipment->currency, 'input', 'localize') : 0.0) }}"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        name="discount" />
                                    @error('discount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.Total_Weight_Kg') }}</label>
                                <input placeholder="@lang('messages.Total_Weight')" type="number"
                                    value="{{ old('total_weight', isset($shipment) ? $shipment->total_weight : 0.5) }}"
                                    class="form-control @error('total_weight') is-invalid @enderror"
                                    name="total_weight" />
                                @error('total_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Quantity')</label>
                                <input placeholder="{{ __('Quantity') }}" type="number" min="1"
                                    value="{{ old('qty', isset($shipment) ? $shipment->qty : '1') }}"
                                    class="form-control  @error('qty') is-invalid @enderror" name="qty" />
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.Total_Cost') }}</label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                    <input type="number" min="0.00" step="any"
                                        class="form-control @error('shipping_cost') is-invalid @enderror"
                                        value="{{ old('shipping_cost', isset($shipment) ? get_money($shipment->shipping_cost, $shipment->currency, 'input', 'localize') : 0) }}"
                                        name="shipping_cost">
                                </div>
                                @error('shipping_cost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--// Package Info -->

            <!-- Shipment Info -->
            <div class="tab-pane fade" id="shipment-tab" role="tabpanel" aria-labelledby="shipment-tab"
                tabindex="0">
                <div class="card">
                    <div class="row card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    {{ __('messages.Shipped_On') }}
                                </label>
                                <input placeholder="{{ __('messages.Shipped_On') }}" type="datetime-local"
                                    value="{{ old('shipped_date', isset($shipment->shipped_date) ? date('Y-m-d H:i', strtotime(\Illuminate\Support\Carbon::parse($shipment->shipped_date)->setTimezone(\Helpers::getUserTimeZone()))) : '') }}"
                                    class="form-control   @error('shipped_date') is-invalid @enderror"
                                    name="shipped_date" />
                                @error('shipped_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    {{ __('messages.Delivery_Date') }}
                                    (<small>@lang('messages.Estimated')</small>)

                                </label>
                                <input placeholder="{{ __('messages.Delivery_Date') }}" type="datetime-local"
                                    value="{{ old('delivery_date', isset($shipment->delivery_date) ? date('Y-m-d H:i', strtotime(\Illuminate\Support\Carbon::parse($shipment->delivery_date)->setTimezone(\Helpers::getUserTimeZone()))) : '') }}"
                                    class="form-control   @error('delivery_date') is-invalid @enderror"
                                    name="delivery_date" />
                                @error('delivery_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    {{ __('messages.Current_Location') }}
                                </label>
                                <input placeholder="{{ __('messages.Current_Location') }}" type="text"
                                    value="{{ old('current_location', isset($shipment) ? $shipment->current_location : '') }}"
                                    class="form-control   @error('current_location') is-invalid @enderror"
                                    name="current_location" />
                                @error('current_location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Payment Types --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">@lang('messages.Payment_Type')</label>
                                <select class="form-select @error('payment_type') is-invalid @enderror"
                                    id="payment_type" name="payment_type">

                                    <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}
                                        {{ $shipment->payment_type == 1 ? 'selected' : '' }}>
                                        @lang('messages.PrePaid')</option>
                                    <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}
                                        {{ $shipment->payment_type == 2 ? 'selected' : '' }}>
                                        @lang('messages.PostPaid')</option>
                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- Payment Methods --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ trans_choice('messages.Payment_Method', 1) }}</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror"
                                    name="payment_method">
                                    {{-- Fetch Payment Methods --}}
                                    @foreach (DB::table('payment_methods')->orderBy('name', 'asc')->get() as $pay)
                                        <option value="{{ $pay->id }}"
                                            {{ $shipment->payment_method == $pay->id ? 'selected' : '' }}>
                                            {{ __('messages.' . get_data_db('payment_methods', 'id', $pay->id, 'name')) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- payment status --}}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Payment Status') }}</label>
                                <select class="form-select @error('payment_status') is-invalid @enderror"
                                    id="payment_status" name="payment_status">

                                    <option value="0" {{ old('payment_status') == '0' ? 'selected' : '' }}
                                        {{ $shipment->payment_status == 0 ? 'selected' : '' }}>
                                        @lang('messages.UnPaid')</option>
                                    <option value="1" {{ old('payment_status') == '1' ? 'selected' : '' }}
                                        {{ $shipment->payment_status == 1 ? 'selected' : '' }}>
                                        @lang('messages.Paid')</option>


                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--// Shipment Info -->

            {{-- Status & Logs --}}
            <div class="tab-pane fade" id="status-tab" role="tabpanel" aria-labelledby="status-tab" tabindex="0">
                <div class="card">
                    <div class="row card-body mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.Status') }}</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="statusx"
                                    name="status">
                                    @php
                                        $statuses = array_flip(get_status('shipments', 'status', 'all'));
                                    @endphp
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status') == $status ? 'selected' : '' }}
                                            {{ $shipment->status == $status ? 'selected' : '' }}>
                                            {{ get_status('shipments', $status) }}</option>
                                    @endforeach

                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row card-body" id="">
                        <label class="form-label"
                            style="font-weight: 600;">{{ __('messages.Shipment_Logs') }}</label>
                        <div class="col-md-12">

                            <table class="table table-condensed" id="shipmet_logs">
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->created_at->diffForHumans() }}</td>
                                        <td>{{ get_status('shipment-notes', $log->note) }}
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#log-edit-{{ $log->id }}"
                                                class='btn btn-sm btn-outline-primary m-1' href='#'><i
                                                    class='fa fa-edit'></i></a>

                                            <a data-bs-toggle="modal"
                                                data-bs-target="#log-delete-{{ $log->id }}"
                                                class='btn btn-sm btn-outline-primary m-1' href='#'><i
                                                    class='fa fa-trash'></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label class="form-label">{{ __('messages.Add_New') }}</label>
                                <select class="form-select" id="new_log" name="new_log">
                                    @php
                                        $statuses = array_flip(note_helper());
                                    @endphp
                                    <option value=""></option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}">
                                            {{ get_status('shipment-notes', $status) }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- // Status & Logs --}}

        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            //shipment store ajax request
            $('#shipment_edit_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                //show some response on the button
                $btn = $('button[id="save_shipment_btn"]');
                $btn.prop('orig_label', $btn.text());
                $btn.prop('disabled', true);
                $btn.html(
                    '<span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                );

                var total_qty = $('input[name="total_qty"]').val();
                var total_weight = $('input[name="total_weight"]').val();
                var sender_info = $('select[name="sender_info"]').val();
                var receiver_info = $('select[name="receiver_info"]').val();
                //validate input field
                if (total_qty != '' && total_weight != '' && sender_info != '' && receiver_info != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.shipments.edit', ['id' => $shipment->id]) }}",
                        data: $form.serialize(),
                        success: save_shipment,
                        dataType: 'json',
                        error: function() {
                            Toastify({
                                text: "{{ __('messages.Unable_To_Process') }}",
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();
                            //reverse the response on the button
                            $btn = $('button[id="save_shipment_btn"]');
                            label = $btn.prop('orig_label');
                            if (label) {
                                $btn.prop('type', 'submit');
                                $btn.text(label);
                                $btn.prop('orig_label', '');
                                $btn.prop('disabled', false);
                            }
                        }
                    });
                } else {
                    //some required fields are empty 
                    Toastify({
                        text: "{{ __('messages.Fill_Required_Field_First') }}",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    //reverse the response on the button
                    $btn = $('button[id="save_shipment_btn"]');
                    label = $btn.prop('orig_label');
                    if (label) {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                        $btn.prop('disabled', false);
                    }
                }
            });
        });

        /**
         * edit shipment.
         * 
         * @param data
         * @return data
         */
        function save_shipment(data) {

            if (data.result == 'success') {

                //success
                //append new log if exist
                if (data.newlog_message != '' && data.newlog_date != '') {
                    var new_log = "<tr><td>" + data.newlog_date + "</td><td>" + data.newlog_message + "</td></tr>";
                    $('#shipmet_logs').append(new_log);
                }
                //reset data
                $('#new_log').val("")
                Toastify({
                    text: '<span class="fa fa-check-circle"></span> ' + data.messages,
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#4fbe87",
                }).showToast();
                //reverse the response on the button
                $btn = $('button[id="save_shipment_btn"]');
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }

            } else if (data.result == 'errors') {

                $.each(data.messages, function(i, item) {
                    Toastify({
                        text: data.messages[i],
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                });


                //reverse the response on the button
                $btn = $('button[id="save_shipment_btn"]');
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            } else {

                Toastify({
                    text: data.messages,
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "red",
                }).showToast();


                //reverse the response on the button
                $btn = $('button[id="save_shipment_btn"]');
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            }
        }
    </script>
@endpush
