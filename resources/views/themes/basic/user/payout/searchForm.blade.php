<div class="row g-3">
    <div class="col-md-2">
        <div class="input-box">
            <input placeholder="@lang('E-mail')" name="email" value="{{ $search['email'] ?? '' }}" type="text"
                   class="form-control form-control-sm">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-box">
            <input placeholder="@lang('Transaction ID')" name="utr" value="{{ $search['utr'] ?? '' }}" type="text"
                   class="form-control form-control-sm">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-box">
            <input placeholder="@lang('Min Amount')" name="min" value="{{ $search['min'] ?? '' }}" type="text"
                   class="form-control form-control-sm">
        </div>
    </div>

    <div class="col-md-2">
        <div class="input-box">
            <input placeholder="@lang('Maximum Amount')" name="max" value="{{ $search['max'] ?? '' }}" type="text"
                   class="form-control form-control-sm">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-box">
            <input placeholder="@lang('Transaction Date')" name="created_at" id="created_at"
                   value="{{ $search['created_at'] ?? '' }}" type="date" class="form-control form-control-sm payout_date"
                   autocomplete="off">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-box">
            <button type="submit" class="btn btn-primary btn-sm w-100">@lang('Search')</button>
        </div>
    </div>
</div>

