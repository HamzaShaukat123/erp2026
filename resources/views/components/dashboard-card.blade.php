<div class="col-12 col-md-3 mb-2">
    <section class="card card-featured-left card-featured-{{ $color }}">
        <div class="card-body icon-container data-container"
             style="background-image: url('/assets/img/{{ $icon }}');">

            <h3 class="amount text-dark">
                <strong>{{ $title }}</strong>
            </h3>

            {{-- VALUE --}}
            <h2 class="amount m-0 text-{{ $color }} actual-data">
                <strong data-value="{{ $value ?? 0 }}">
                    {{ number_format($value ?? 0, 0) }}
                </strong>
                <span class="title text-end text-dark h6"> {{ $unit }}</span>
            </h2>

            {{-- MASK --}}
            <h2 class="amount m-0 text-{{ $color }} masked-data">
                <strong>******</strong>
            </h2>

            {{-- EXTRA VALUE (Optional like Weight / Second Amount) --}}
            @if(isset($value2))
                <h2 class="amount m-0 text-{{ $color }} actual-data">
                    <strong data-value="{{ $value2 ?? 0 }}">
                        {{ number_format($value2 ?? 0, 0) }}
                    </strong>
                    <span class="title text-end text-dark h6"> {{ $unit2 }}</span>
                </h2>

                <h2 class="amount m-0 text-{{ $color }} masked-data">
                    <strong>******</strong>
                </h2>
            @endif

            <div class="summary-footer">
                <a class="text-primary text-uppercase" href="{{ $link ?? '#' }}">
                    View Details
                </a>
            </div>

        </div>
    </section>
</div>