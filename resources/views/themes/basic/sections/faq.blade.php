<!-- FAQ -->
@if(isset($contentDetails['faq']))
@if(0 < count($contentDetails['faq']))
    <section class="faq-section faq-page">
        <div class="container">
        <div class="row g-4 gy-5 justify-content-center align-items-center">
            <div class="col-lg-12">
                <div class="accordion" id="accordionExample">
                    @foreach($contentDetails['faq'] as $key => $data)
                        <div class="accordion-item">
                            <h5 class="accordion-header" id="heading{{$key}}">
                                <button
                                    class="accordion-button @if( $key != 0 ) collapsed @endif"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$key}}"
                                    aria-expanded="true"
                                    aria-controls="collapse{{$key}}"
                                >
                                    @lang(optional($data->description)->title)
                                </button>
                            </h5>
                            <div
                                id="collapse{{$key}}"
                                class="accordion-collapse collapse @if( $key == 0 ) show @endif"
                                aria-labelledby="heading{{$key}}"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    {!! trans(optional($data->description)->description) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>
@endif
@endif
<!-- /FAQ -->
