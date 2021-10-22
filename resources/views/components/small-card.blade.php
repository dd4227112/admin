<div>
        <div class="card {{ $cardcolor }}">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">{{$title}}</p>
                        <h4 class="m-b-0">{{ number_format($value) }}</h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
            </div>
        </div>
</div>