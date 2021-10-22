<div>
    <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green f-w-700">{{ $name == 'NPS' ? number_format($value,2).'%' : number_format($value)}} </h4>
                        <h6 class="text-muted m-b-0">{{$name}}</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="{{$topicon}}"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer {{$color}}">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">{{$subtitle}}</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="{{$icon}}"></i>
                    </div>
                </div>

            </div>
        </div>
</div>