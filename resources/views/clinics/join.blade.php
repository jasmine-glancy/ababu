<form method="GET" action="{{route('clinics.join')}}">
    @csrf
    <div class="form-group">
        <button type="submit"
            class="btn btn-secondary btn-lg">{{__('translate.clinic_join')}}</button>
        <input type="text" name="token" id="token" value="{{old('token')}}"
            class="form-control form-control-lg"
            placeholder="{{__('help.clinic_token_example')}}" required maxlength="17"
            minlength="17" />
        <small id="help_clinic_join"
            class="form-text text-muted">{{__('help.clinic_join')}}</small>
    </div>
</form>