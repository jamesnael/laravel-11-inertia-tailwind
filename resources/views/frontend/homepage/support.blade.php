<section class="support">
    <div class="container-lg">
      <div>
        <h4 class="text-center text-grey support-title">Supported by</h4>
        <div class="d-flex justify-content-center gap-5 align-items-center flex-wrap">
            @foreach($supported_by as $value)
                <div>
                    <img src="{{$value->image}}" class="img-partner" alt="{{$value->title}}">
                </div>
            @endforeach
        </div>
      </div>
      <div class="mt-5 ">
        <h4 class="text-center text-grey support-title">In partnership with</h4>
        <div class="d-flex justify-content-center gap-5 align-items-center flex-wrap">
            @foreach($partnership as $value)
                <div>
                    <img src="{{$value->image}}" class="img-partner" alt="{{$value->title}}">
                </div>
            @endforeach
        </div>
      </div>
    </div>
  </section>