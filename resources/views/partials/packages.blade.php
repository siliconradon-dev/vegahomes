{{-- ===== Our Packages + Dream Home Estimator popup ===== --}}
@php
    $vegaPackages = $packages ?? \App\Models\Package::active()->get();
    $vegaConfig = [
        'endpoint' => route('estimate.store'),
        'packages' => $vegaPackages->map(function ($p) {
            return [
                'slug'     => $p->slug,
                'name'     => $p->name,
                'rate'     => $p->rate,
                'starting' => (bool) $p->is_starting_rate,
                'tagline'  => $p->tagline,
            ];
        })->values()->all(),
    ];
@endphp

@if ($vegaPackages->count())
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}?v=2">
@endpush

<section class="vh-pk" id="packages">
    <div class="vh-pk__glow vh-pk__glow--a"></div>
    <div class="vh-pk__glow vh-pk__glow--b"></div>

    <div class="container position-relative">
        <div class="row section-row align-items-center">
            <div class="col-lg-6">
                <div class="section-title dark-section">
                    <h3 class="wow fadeInUp">our packages</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">Choose the package that fits your <span>dream home</span></h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title-content dark-section">
                    <p class="wow fadeInUp" data-wow-delay="0.2s">
                        Pick a construction package, enter your room sizes and get an indicative cost in minutes.
                        Our team will then contact you with a detailed quotation.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($vegaPackages as $pkg)
                <div class="col-xl-3 col-md-6">
                    <article class="vh-card {{ $pkg->is_featured ? 'is-featured' : '' }}">
                        @if ($pkg->is_featured)
                            <span class="vh-card__ribbon"><i class="fa-solid fa-star"></i> Most popular</span>
                        @endif

                        <div class="vh-card__icon" aria-hidden="true">
                            <i class="fa-solid {{ ['fa-house', 'fa-house-chimney', 'fa-gem', 'fa-crown'][$loop->index % 4] }}"></i>
                        </div>

                        <h3 class="vh-card__name">{{ $pkg->name }}</h3>
                        <p class="vh-card__tag">{{ $pkg->tagline }}</p>

                        <div class="vh-card__price">
                            @if ($pkg->is_starting_rate)<small>from</small>@endif
                            <span class="vh-card__cur">LKR</span>
                            <strong>{{ number_format($pkg->rate) }}</strong>
                            <small>/ sq.ft.</small>
                        </div>

                        @if (!empty($pkg->features))
                            <ul class="vh-card__list">
                                @foreach ($pkg->features as $feature)
                                    <li><i class="fa-solid fa-check"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <button type="button" class="vh-card__cta" data-vh-open="{{ $pkg->slug }}">
                            Get my estimate <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </article>
                </div>
            @endforeach
        </div>

        <p class="vh-pk__foot">
            <i class="fa-solid fa-circle-info"></i>
            Rates are indicative and in Sri Lankan Rupees. Final quotation depends on approved drawings, specifications and site conditions.
        </p>
    </div>
</section>

{{-- ============ Estimator popup ============ --}}
<div class="vh-modal" id="vhEstimator" hidden aria-hidden="true"
     data-config="{{ json_encode($vegaConfig) }}">
    <div class="vh-modal__backdrop" data-vh-close></div>

    <div class="vh-dialog" role="dialog" aria-modal="true" aria-labelledby="vhTitle">
        {{-- ---------- Left: live summary ---------- --}}
        <aside class="vh-aside">
            <div class="vh-aside__brand">
                <img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes">
            </div>

            <div class="vh-aside__pkg">
                <span class="vh-aside__label">Selected package</span>
                <strong data-bind="pkgName">—</strong>
                <em data-bind="pkgRate">—</em>
            </div>

            <dl class="vh-aside__stats">
                <div><dt>House type</dt><dd data-bind="houseType">Single-Storey</dd></div>
                <div><dt>Total area</dt><dd><span data-bind="totalArea">0</span> sq.ft.</dd></div>
            </dl>

            <div class="vh-aside__total">
                <span class="vh-aside__label">Indicative construction cost</span>
                <strong data-bind="totalCost">LKR 0</strong>
                <small data-bind="formula">Enter your room sizes to see the estimate.</small>
            </div>

            <p class="vh-aside__note">
                <i class="fa-solid fa-shield-halved"></i>
                A preliminary figure only. Your final quotation follows after our team reviews your plans.
            </p>
        </aside>

        {{-- ---------- Right: wizard ---------- --}}
        <div class="vh-main">
            <header class="vh-head">
                <div>
                    <span class="vh-head__step" data-bind="stepCount">Step 1 of 6</span>
                    <h3 id="vhTitle" data-bind="stepTitle">House configuration</h3>
                </div>
                <button type="button" class="vh-close" data-vh-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </header>
            <div class="vh-bar"><span data-bind="bar"></span></div>

            <form class="vh-body" id="vhForm" novalidate autocomplete="on">
                {{-- honeypot --}}
                <div class="vh-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

                {{-- STEP: config --}}
                <section class="vh-step" data-step="config">
                    <p class="vh-hint">Choose the number of floors and tell us where you plan to build.</p>

                    <div class="vh-storeys" role="radiogroup" aria-label="House type">
                        @foreach ([1 => 'Single-Storey', 2 => 'Two-Storey', 3 => 'Three-Storey'] as $n => $label)
                            <label class="vh-storey">
                                <input type="radio" name="floors" value="{{ $n }}" {{ $n === 1 ? 'checked' : '' }}>
                                <span class="vh-storey__box">
                                    <span class="vh-storey__art" aria-hidden="true">
                                        @for ($i = 0; $i < $n; $i++)<i></i>@endfor
                                    </span>
                                    <b>{{ $label }}</b>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <div class="vh-grid">
                        <label class="vh-field">
                            <span>Construction district *</span>
                            <select class="vh-in" name="district" required>
                                <option value="">Select a district</option>
                                @foreach (config('vega.districts') as $d)<option>{{ $d }}</option>@endforeach
                            </select>
                        </label>
                        <label class="vh-field">
                            <span>Town / area / nearest landmark *</span>
                            <input class="vh-in" name="town_area" required maxlength="160" placeholder="e.g. Kurunegala town">
                        </label>
                        <label class="vh-field">
                            <span>Design status *</span>
                            <select class="vh-in" name="design_status" required>
                                <option value="">Select design status</option>
                                @foreach (config('vega.design_statuses') as $d)<option>{{ $d }}</option>@endforeach
                            </select>
                        </label>
                        <label class="vh-field">
                            <span>Building plan approval status *</span>
                            <select class="vh-in" name="approval_status" required>
                                <option value="">Select approval status</option>
                                @foreach (config('vega.approval_statuses') as $d)<option>{{ $d }}</option>@endforeach
                            </select>
                        </label>
                    </div>
                </section>

                {{-- STEPS: floors --}}
                @foreach (['ground' => 'Ground Floor', 'first' => 'First Floor', 'second' => 'Second Floor'] as $key => $label)
                    <section class="vh-step" data-step="{{ $key }}">
                        <p class="vh-hint">
                            Enter each room's length and width in feet. Areas are calculated automatically –
                            add a row for every room with different dimensions.
                        </p>
                        <div class="vh-rooms" data-rows="{{ $key }}"></div>
                        <button type="button" class="vh-btn vh-btn--ghost" data-add-room="{{ $key }}">
                            <i class="fa-solid fa-plus"></i> Add room
                        </button>
                        <div class="vh-floor-total">
                            <span>{{ $label }} total area</span>
                            <strong><span data-floor-total="{{ $key }}">0</span> sq.ft.</strong>
                        </div>
                    </section>
                @endforeach

                {{-- STEP: estimate --}}
                <section class="vh-step" data-step="estimate">
                    <p class="vh-hint">Here is your preliminary area and indicative cost. You can still switch package below.</p>

                    <div class="vh-switch" data-package-switch role="radiogroup" aria-label="Package"></div>

                    <div class="vh-sum">
                        <div><span>Ground floor</span><b><span data-bind="gArea">0</span> sq.ft.</b></div>
                        <div data-only-floor="first"><span>First floor</span><b><span data-bind="fArea">0</span> sq.ft.</b></div>
                        <div data-only-floor="second"><span>Second floor</span><b><span data-bind="sArea">0</span> sq.ft.</b></div>
                        <div class="is-strong"><span>Total proposed area</span><b><span data-bind="totalArea">0</span> sq.ft.</b></div>
                    </div>

                    <div class="vh-estimate">
                        <span>Estimated construction cost</span>
                        <strong data-bind="totalCost">LKR 0</strong>
                        <small data-bind="formula"></small>
                    </div>

                    <p class="vh-notice">
                        The total is calculated from the room dimensions you entered – please make sure every room and space is included.
                        This is an indicative estimate, not a final quotation. Signature rates start from the stated figure; the final price may
                        vary with approved drawings, specifications, site conditions, structural requirements, external works, taxes and confirmed scope.
                    </p>
                </section>

                {{-- STEP: contact --}}
                <section class="vh-step" data-step="contact">
                    <p class="vh-hint">Tell us how to reach you and our team will discuss your requirements.</p>

                    <div class="vh-grid">
                        <label class="vh-field">
                            <span>Full name *</span>
                            <input class="vh-in" name="name" required maxlength="120" autocomplete="name" placeholder="Your name">
                        </label>
                        <label class="vh-field">
                            <span>Contact number (WhatsApp) *</span>
                            <input class="vh-in" name="phone" type="tel" required maxlength="40" autocomplete="tel" placeholder="07X XXX XXXX">
                        </label>
                        <label class="vh-field">
                            <span>Email address (optional)</span>
                            <input class="vh-in" name="email" type="email" maxlength="190" autocomplete="email" placeholder="you@example.com">
                        </label>
                        <label class="vh-field">
                            <span>Land ownership</span>
                            <select class="vh-in" name="land_ownership">
                                @foreach (config('vega.land_options') as $d)<option>{{ $d }}</option>@endforeach
                            </select>
                        </label>
                        <label class="vh-field">
                            <span>Expected construction start (optional)</span>
                            <input class="vh-in" name="start_date" type="date">
                        </label>
                    </div>

                    <label class="vh-field">
                        <span>Additional requirements or comments</span>
                        <textarea class="vh-in" name="comments" rows="3" maxlength="3000" placeholder="Special requirements, design ideas or features…"></textarea>
                    </label>

                    <div class="vh-field">
                        <span>Upload your plan or documents (optional)</span>
                        <label class="vh-drop">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <b>Tap to attach files</b>
                            <small>PDF, images, DWG/DXF, Word · up to 8 files · max 20 MB total</small>
                            <input type="file" id="vhFiles" multiple
                                   accept=".pdf,.png,.jpg,.jpeg,.webp,.gif,.bmp,.heic,.dwg,.dxf,.doc,.docx">
                        </label>
                        <ul class="vh-files" id="vhFileList"></ul>
                    </div>

                    <label class="vh-consent">
                        <input type="checkbox" name="consent" value="1" required>
                        <span>I agree that Vega Homes (Pvt) Ltd may contact me regarding this construction enquiry.</span>
                    </label>
                </section>

                {{-- STEP: review --}}
                <section class="vh-step" data-step="review">
                    <div class="vh-print-head">
                        <img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes">
                        <div>
                            <b>House Construction Enquiry</b>
                            <span>Ref: <span data-bind="printRef">Draft</span> · <span data-bind="printDate"></span></span>
                        </div>
                    </div>
                    <p class="vh-hint vh-noprint">Please check everything below, then submit your enquiry.</p>
                    <div class="vh-review" id="vhReview"></div>
                    <p class="vh-notice">Your enquiry is not a final quotation. Final pricing depends on the approved design, specifications, site conditions and confirmed project scope.</p>
                    <button type="button" class="vh-btn vh-btn--ghost vh-noprint vh-print-btn" data-vh-print>
                        <i class="fa-solid fa-print"></i> Print / Save PDF
                    </button>
                </section>

                {{-- SUCCESS --}}
                <section class="vh-step vh-success" data-step="success">
                    <div class="vh-success__check"><i class="fa-solid fa-check"></i></div>
                    <h4>Thank you! Your enquiry is in.</h4>
                    <p>Reference <b data-bind="reference">—</b></p>
                    <p class="vh-success__est">Indicative estimate <strong data-bind="doneCost">—</strong></p>
                    <p class="vh-hint">Send the summary to our team on WhatsApp for the fastest response. We will also call you shortly.</p>
                    <a class="vh-btn vh-btn--wa" id="vhWhatsapp" href="#" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i> Send on WhatsApp
                    </a>
                    <button type="button" class="vh-btn vh-btn--ghost" data-vh-print><i class="fa-solid fa-print"></i> Print / Save PDF</button>
                    <button type="button" class="vh-btn vh-btn--ghost" data-vh-close>Close</button>
                </section>

                <p class="vh-error" id="vhError" role="alert" hidden></p>
            </form>

            <footer class="vh-foot" id="vhFoot">
                <button type="button" class="vh-btn vh-btn--ghost" id="vhBack"><i class="fa-solid fa-arrow-left"></i> Back</button>
                <button type="button" class="vh-btn vh-btn--gold" id="vhNext">Next <i class="fa-solid fa-arrow-right"></i></button>
            </footer>
        </div>
    </div>

    <datalist id="vhRoomTypes">
        @foreach (config('vega.room_types') as $t)<option value="{{ $t }}">@endforeach
    </datalist>
</div>

@push('scripts')
    <script src="{{ asset('js/estimator.js') }}?v=1"></script>
@endpush
@endif
