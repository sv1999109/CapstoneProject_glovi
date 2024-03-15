@php
    $user_lang = LaravelLocalization::getCurrentLocale();
    $customer = '<a href="' . route('dashboard.users.view', ['id' => $shipment->owner_id]) . '"> <span class="btn btn-sm btn-secondary m-1">' . get_user('username', $shipment->owner_id) . '</span> </a>';

    $sender_info = $shipment->sender_name . ': ';
    $sender_info .= $shipment->sender_address . ',';
    $sender_info .= '<br>';
    $sender_info .= get_name($shipment->from_area, 'areas') . ' ';
    $sender_info .= get_name($shipment->sender_city, 'cities');
    $sender_info .= ' - ';
    $sender_info .= get_name($shipment->sender_state, 'states') . ', ';
    $sender_info .= get_name($shipment->sender_country, 'countries');

    $receiver_info = $shipment->receiver_name . ': ';
    $receiver_info .= $shipment->receiver_address . ',';
    $receiver_info .= '<br>';
    $receiver_info .= get_name($shipment->from_area, 'areas') . ' ';
    $receiver_info .= get_name($shipment->receiver_city, 'cities');
    $receiver_info .= '- ';
    $receiver_info .= get_name($shipment->receiver_state, 'states') . ', ';
    $receiver_info .= get_name($shipment->receiver_country, 'countries');
                       
@endphp
{{-- Shipment Packages update modal --}}
@if (isset($packages))
    @foreach ($packages as $package)
        {{-- edit --}}
        <div class="modal fade text-left" id="package-edit-{{ $package->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ url('/dashboard/shipments/updatepackage/' . $package->id) }}" class="form"
                        method="post">
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel110">
                                @lang('messages.Edit') #{{ $package->id }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6 required">@lang('messages.Description')</label>
                                    <input placeholder="@lang('messages.Description')" type="text"
                                        value="{{ old('package_description', $package->description) }}"
                                        class="form-control @error('package_description') is-invalid @enderror"
                                        name="package_description" required />
                                    @error('package_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Length_CM')</label>
                                    <input placeholder="@lang('messages.Length')" type="number" {{-- min="0.5" --}}
                                        value="{{ old('length', $package->length) }}"
                                        class="form-control  @error('legth') is-invalid @enderror"
                                        name="length" required />
                                    @error('length')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Weight_Kg')</label>
                                    <input placeholder="@lang('messages.Width')" type="number" {{-- min="0.5" --}}
                                        value="{{ old('width', $package->width) }}"
                                        class="form-control width @error('width') is-invalid @enderror"
                                        name="width" required />
                                    @error('width')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Height_CM')</label>
                                    <input placeholder="@lang('messages.Height')" type="number" {{-- min="0.5" --}}
                                        value="{{ old('height', $package->weight) }}"
                                        class="form-control @error('height') is-invalid @enderror"
                                        name="height" required />
                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Weight_Kg')</label>
                                    <input placeholder="@lang('messages.Weight')" type="number" {{-- min="0.5" --}}
                                        value="{{ old('weight', $package->weight) }}"
                                        class="form-control weights @error('total_weight') is-invalid @enderror"
                                        name="weight" required />
                                    @error('weight')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Quantity')</label>
                                    <input placeholder="@lang('messages.Quantity')" type="number" min="1"
                                        value="{{ old('qty', $package->qty) }}"
                                        class="form-control @error('qty') is-invalid @enderror" name="qty"
                                        required />
                                    @error('qty')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Declared_Value')</label>
                                    <div class="input-group mb-3">
                                        <span
                                            class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                        <input placeholder="@lang('messages.Declared_Value')" type="number" 
                                            value="{{ old('value', get_money($package->value, $shipment->currency, 'input', 'localize')) }}"
                                            class="form-control @error('value') is-invalid @enderror"
                                            name="value" required />
                                        @error('value')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6">@lang('messages.Total')</label>
                                    <div class="input-group mb-3">
                                        <span
                                            class="input-group-text">{{ get_money('0', $shipment->currency, 'only_symbol', 'localize') }}</span>
                                        <input placeholder="@lang('messages.Total')" type="number" min="0.01"
                                            step="any"
                                            value="{{ old('price', get_money($package->price, $shipment->currency, 'input', 'localize')) }}"
                                            class="form-control @error('price') is-invalid @enderror" name="price"
                                            required />
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg align-baseline me-1 "></i>
                                <span class="d">@lang('messages.Close')</span>
                            </button>

                            <button type="submit" class="btn btn-primary ml-1" ddata-bs-dismiss="modal">
                                <i class="bx bx-check "></i>
                                <span class="d">@lang('messages.Save') </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- delete shipment log --}}
        <div class="modal fade text-left" id="package-delete-{{ $package->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            @lang('messages.Perform_Action')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('messages.Delete') {{ __($package->description) }}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg align-baseline me-1"></i>
                            <span class="">@lang('messages.Cancel') </span>
                        </button>


                        <a class="btn btn-primary ml-1"
                            href="{{ url('/dashboard/shipments/deletepackage/' . $package->id) }}">
                            @lang('messages.Yes')
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif

{{-- Shipment log update modal --}}
@if (isset($logs))
    @foreach ($logs as $log)
        {{-- edit --}}
        <div class="modal fade text-left" id="log-edit-{{ $log->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ url('/dashboard/shipments/updatelog/' . $log->id) }}" class="form"
                        method="post">
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel110">
                                @lang('messages.Edit')
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <label class="col-form-label fw-bold fs-6">{{ __('Note') }}</label>

                                <select class="form-select @error('status') is-invalid @enderror" id="edit_log"
                                    name="edit_log">
                                    @php
                                        $statuses = array_flip(note_helper());
                                    @endphp
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ $status == $log->note ? 'selected' : '' }}>
                                            {{ get_status('shipment-notes', $status) }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg align-baseline me-1 "></i>
                                <span class="d">@lang('messages.Close')</span>
                            </button>

                            <button type="submit" class="btn btn-primary ml-1" ddata-bs-dismiss="modal">
                                <i class="bx bx-check "></i>
                                <span class="d">@lang('messages.Save') </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- delete shipment log --}}
        <div class="modal fade text-left" id="log-delete-{{ $log->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            @lang('messages.Perform_Action')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('messages.Delete') {{ get_status('shipment-notes', $log->note) }}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg align-baseline me-1"></i>
                            <span class="">@lang('messages.Cancel') </span>
                        </button>


                        <a class="btn btn-primary ml-1"
                            href="{{ url('/dashboard/shipments/deletelog/' . $log->id) }}">
                            @lang('messages.Yes')
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif


@if (isset($id))
    {{-- Shipment Approval modal --}}
    <div class="modal fade text-left" id="approve-{{ $id }}" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="approvemodal">
                        @lang('messages.Approve') {{ trans_choice('messages.Shipment', 1) }}: {{ $code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                        @lang('messages.Shipping_Cost'):
                        <strong>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</strong>
                        <hr>
                        {{ trans_choice('messages.Payment_Method', 1) }}:
                        <strong>{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</strong>
                        <hr>
                        @lang('messages.Payment_Type'):
                        <strong>{{ $shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid') }}</strong>
                        <hr>
                        @lang('messages.Invoice_Status'):
                        <strong>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</strong>
                        <hr>
                    </p>
                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p>
                        {!! $sender_info !!} 
                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'approve']) }}">
                        @lang('messages.Yes')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment Mark As Paid modal --}}
    <div class="modal fade text-left" id="paid-{{ $id }}" tabindex="-1" aria-labelledby="approvemodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="paidmodal">
                        {{ trans_choice('messages.Invoice', 1) }}: #{{ $shipment->invoice_id }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                        @lang('messages.Shipping_Cost'):
                        <strong>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</strong>
                        <hr>
                        {{ trans_choice('messages.Payment_Method', 1) }}:
                        <strong>{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</strong>
                        <hr>
                        @lang('messages.Payment_Type'):
                        <strong>{{ $shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid') }}</strong>
                        <hr>
                        @lang('messages.Invoice_Status'):
                        <strong>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'paid']) }}">
                        @lang('messages.Mark_Paid')
                    </a>
                </div>

            </div>
        </div>
    </div>

     {{-- Shipment Mark As Shipped modal --}}
     <div class="modal fade text-left" id="ready-for-shipment-{{ $id }}" tabindex="-1"
     aria-labelledby="approvemodal" aria-modal="true" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title" id="ready-for-shipment-modal">
                     {{ trans_choice('messages.Mark_Ready_For_Shipment', 1) }}: #{{ $shipment->code }}
                 </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     
                 </button>
             </div>
             <div class="modal-body">
                 <p>
                     {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                     <hr>
                 </p>

                 <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                 <p>
                     {!! $sender_info !!} 
                 </p>
                 <hr>
                 <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                 <p>
                     {!! $receiver_info !!} 
                 </p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                     <i class="bi bi-x-lg align-baseline me-1"></i>
                     <span class="">@lang('messages.Cancel') </span>
                 </button>
                 <a class="btn btn-primary ml-1"
                     href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 3]) }}">
                     @lang('messages.Mark_Ready_For_Shipment')
                 </a>
             </div>

         </div>
     </div>
 </div>

    {{-- Shipment Mark As Shipped modal --}}
    <div class="modal fade text-left" id="shipped-{{ $id }}" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="shipped-modal">
                        {{ trans_choice('messages.Mark_Shipped', 1) }}: #{{ $shipment->code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                    </p>

                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p>
                        {!! $sender_info !!} 
                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 4]) }}">
                        @lang('messages.Mark_Shipped')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment Mark As Out For Delivery modal --}}
    <div class="modal fade text-left" id="out-for-delivery-{{ $id }}" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="out-for-delivery-modal">
                        {{ trans_choice('messages.Mark_Out_For_Delivery', 1) }}: #{{ $shipment->code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p> 

                        {!! $sender_info !!} 

                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 8]) }}">
                        @lang('messages.Mark_Out_For_Delivery')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment Mark As Deliveried modal --}}
    <div class="modal fade text-left" id="delivered-{{ $id }}" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="delivered-modal">
                        {{ trans_choice('messages.Mark_Delivered', 1) }}: #{{ $shipment->code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>

                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p>
                        {!! $sender_info !!} 

                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 13]) }}">
                        @lang('messages.Mark_Out_For_Delivery')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment Cancel modal --}}
    <div class="modal fade text-left" id="cancel-{{ $id }}" tabindex="-1" aria-labelledby="cancelmodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="cancel-modal">
                        {{ trans_choice('messages.Cancel_Shipment', 1) }}: #{{ $shipment->code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                        @lang('messages.Shipping_Cost'):
                        <strong>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</strong>
                        <hr>
                        {{ trans_choice('messages.Payment_Method', 1) }}:
                        <strong>{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</strong>
                        <hr>
                        @lang('messages.Payment_Type'):
                        <strong>{{ $shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid') }}</strong>
                        <hr>
                        @lang('messages.Invoice_Status'):
                        <strong>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</strong>
                        <hr>
                    </p>
                    <p>

                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p>
                        {!! $sender_info !!} 

                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 10]) }}">
                        @lang('messages.Cancel_Shipment')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment Rejection modal --}}

    <div class="modal fade text-left" id="reject-{{ $id }}" tabindex="-1" aria-labelledby="rejectmodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="rejectmodal">
                        @lang('messages.Reject') {{ trans_choice('messages.Shipment', 1) }}: {{ $code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ trans_choice('messages.Customer', 1) }}: {!! $customer !!}
                        <hr>
                        @lang('messages.Shipping_Cost'):
                        <strong>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</strong>
                        <hr>
                        {{ trans_choice('messages.Payment_Method', 1) }}:
                        <strong>{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</strong>
                        <hr>
                        @lang('messages.Payment_Type'):
                        <strong>{{ $shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid') }}</strong>
                        <hr>
                        @lang('messages.Invoice_Status'):
                        <strong>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</strong>
                        <hr>
                    </p>
                    <p>
    
                    <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                    <p>
                        {!! $sender_info !!} 
    
                    </p>
                    <hr>
                    <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                    <p>
                        {!! $receiver_info !!} 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'reject']) }}">
                        @lang('messages.Reject')
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Shipment delete modal --}}

    <div class="modal fade text-left" id="delete-{{ $id }}" tabindex="-1"
        aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel110">
                        @lang('messages.Perform_Action')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    @lang('messages.Delete') {{ trans_choice('messages.Shipment', 1) }}:
                    <strong>{{ $code }}</strong>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class="">@lang('messages.Cancel') </span>
                    </button>


                    <a class="btn btn-primary ml-1" href="{{ route('dashboard.shipments.delete', ['id' => $id]) }}">
                        @lang('messages.Yes')
                    </a>
                </div>

            </div>
        </div>
    </div>
@endif
