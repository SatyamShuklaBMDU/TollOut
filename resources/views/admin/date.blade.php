<div class="col-sm-1">
    <p class="text-dark">
        <b style="font-size: 15px;">
            Filters:
        </b>
    </p>
</div>
<div class="col-sm-3 end-date">
    <div class="d-inline-flex">
        {{-- <p class="text-dark px-1">
            <strong>Date From:</strong>
        </p> --}}
        <div class="input-group date d-flex">
            <p class="text-dark me-2 pt-1">
                <strong>From:</strong>
            </p>
            <input type="date" class="form-control @error('start') is-invalid @enderror" name="start" id="datepickerFrom" style="font-size: 15px;"
                value="{{ old('start', $start ?? '') }}" placeholder="dd-mm-yyyy">
            @error('start')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>  
    </div>                                  
</div>
<div class="col-sm-3 end-date">
    <div class="d-inline-flex">
        
        <div class="input-group date d-flex">
            <p class="text-dark me-2 pt-1">
                <strong>To:</strong>
            </p>
            <input type="date" class="form-control @error('end') is-invalid @enderror" name="end" id="datepickerTo" style="font-size: 15px;"
                value="{{ old('end', $end ?? '') }}" placeholder="dd-mm-yyyy">
            @error('end')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="col-sm-1" style="margin-top: 0px;">
    <button class="btn text-white shadow-lg" type="submit"
        style="background-color:#033496;font-size:15px;">Filter</button>
</div>