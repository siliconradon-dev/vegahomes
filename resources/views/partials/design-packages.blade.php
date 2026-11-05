{{-- ===== Architectural Design Packages + Design Fee Estimator popup ===== --}}
@php
    $vdPackages = $designPackages ?? \App\Models\DesignPackage::active()->get();
    $vdAddons   = config('vega.design_addons');
    $vdAddonIcons = [
        'interior-design' => 'fa-couch', 'swimming-pool-design' => 'fa-water-ladder', 'landscape-design' => 'fa-tree',
        'boundary-wall-gate' => 'fa-archway', 'boq-preparation' => 'fa-clipboard-list', 'quantity-surveying' => 'fa-ruler-combined',
        'construction-supervision' => 'fa-helmet-safety', 'project-management' => 'fa-diagram-project',
    ];
    $showRates = (bool) config('vega.public_rates');
    $vdConfig = [
        'endpoint'      => route('design-estimate.store'),
        'quoteEndpoint' => route('design-estimate.quote'),
        'showEstimates' => \App\Support\EstimateRange::enabled(),
        'publicRates'   => $showRates,
        'packages'      => $vdPackages->map(function ($p) use ($showRates) {
            $row = ['slug' => $p->slug, 'name' => $p->name, 'tagline' => $p->tagline, 'features' => $p->features ?? []];
            if ($showRates) {
                $row['type']              = $p->pricing_type;
                $row['rate']              = $p->rate;
                $row['construction_rate'] = $p->construction_rate;
            }
            return $row;
        })->values()->all(),
    ];
@endphp

@if ($vdPackages->count())
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/design-packages.css') }}?v=1">
@endpush

<section class="vd" id="design-packages">
    <div class="container position-relative">
        <div class="row section-row align-items-center">
            <div class="col-lg-6">
                <div class="section-title">
                    <h3 class="wow fadeInUp">architectural design</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">Design your dream home <span>before the first brick</span></h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title-content">
                    <p class="wow fadeInUp" data-wow-delay="0.2s">
                        From essential planning to a bespoke design solution – choose your architectural design package, enter your proposed
                        floor area and view an indicative design fee instantly.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($vdPackages as $pkg)
                <div class="col-xl-4 col-md-6">
                    <article class="vd-card {{ $pkg->is_featured ? 'is-featured' : '' }}">
                        @if ($pkg->is_featured)
                            <span class="vd-card__ribbon"><i class="fa-solid fa-star"></i> Most popular</span>
                        @endif

                        <header class="vd-card__top">
                            <span class="vd-card__no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <h3>{{ $pkg->name }}</h3>
                                <p>{{ $pkg->tagline }}</p>
                            </div>
                        </header>

                        <div class="vd-card__body">
                            @if ($showRates)
                                <div class="vd-card__price">
                                    @if ($pkg->isPercent())
                                        <strong>{{ $pkg->rate_plain }}%</strong>
                                        <span>of construction estimate</span>
                                    @else
                                        <small>LKR</small>
                                        <strong>{{ number_format($pkg->rate, $pkg->rate == floor($pkg->rate) ? 0 : 2) }}</strong>
                                        <span>/ sq.ft.</span>
                                    @endif
                                </div>
                            @else
                                <div class="vd-card__tier">
                                    <i class="fa-solid fa-calculator"></i>
                                    <span>Instant design-fee estimate</span>
                                </div>
                            @endif

                            @if ($pkg->note)<p class="vd-card__note">{{ $pkg->note }}</p>@endif

                            @if (!empty($pkg->features))
                                <ul class="vd-card__list">
                                    @foreach ($pkg->features as $feature)
                                        <li><i class="fa-solid fa-check"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <button type="button" class="vd-card__cta" data-vd-open="{{ $pkg->slug }}">
                                Calculate my design fee <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        {{-- Optional add-ons --}}
        <div class="vd-addons-block">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">optional add-ons</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Extend your design with <span>add-on services</span></h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-content">
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Discussed and priced separately based on your project – not included in the package fee unless confirmed in your proposal.</p>
                    </div>
                </div>
            </div>
            <div class="vd-addon-grid">
                @foreach ($vdAddons as $slug => $addon)
                    <div class="vd-addon">
                        <i class="fa-solid {{ $vdAddonIcons[$slug] ?? 'fa-circle-plus' }}"></i>
                        <div><strong>{{ $addon[0] }}</strong><span>{{ $addon[1] }}</span></div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Why choose --}}
        <div class="vd-why">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title dark-section">
                        <h3 class="wow fadeInUp">why choose us</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Why choose <span>Vega Homes?</span></h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-content dark-section">
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Thoughtful design, honest costing and dependable support from the first sketch to the next steps.</p>
                    </div>
                </div>
            </div>
            <div class="vd-why__grid">
                <div><i class="fa-solid fa-lightbulb"></i><strong>Innovative Designs</strong><span>Thoughtful design solutions for your home.</span></div>
                <div><i class="fa-solid fa-handshake"></i><strong>Client Focused Approach</strong><span>Your needs and priorities guide the process.</span></div>
                <div><i class="fa-solid fa-coins"></i><strong>Cost Effective Solutions</strong><span>Planning with budget awareness.</span></div>
                <div><i class="fa-solid fa-medal"></i><strong>Quality &amp; Reliability</strong><span>Professional care throughout the design process.</span></div>
                <div><i class="fa-solid fa-route"></i><strong>End-to-End Support</strong><span>Support from early planning to the next steps.</span></div>
            </div>
        </div>

        <p class="vd__foot">
            <i class="fa-solid fa-circle-info"></i>
            Indicative design-fee estimates only – not a final quotation or a construction-cost estimate. Final fees depend on confirmed floor area,
            deliverables, complexity, revisions, structural and engineering scope and council submission requirements. Council approval is subject to the relevant authority.
        </p>
    </div>
</section>

{{-- ============ Design estimator popup ============ --}}
<div class="vh-modal" id="vhDesign" hidden aria-hidden="true" data-config="{{ json_encode($vdConfig) }}">
    <div class="vh-modal__backdrop" data-vh-close></div>

    <div class="vh-dialog" role="dialog" aria-modal="true" aria-labelledby="vdTitle">
        <aside class="vh-aside">
            <div class="vh-aside__brand"><img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes"></div>

            <div class="vh-aside__pkg">
                <span class="vh-aside__label">Design package</span>
                <strong data-bind="pkgName">—</strong>
                <em data-bind="pkgRate">—</em>
            </div>

            <dl class="vh-aside__stats">
                <div><dt>House type</dt><dd data-bind="houseType">Single-Storey</dd></div>
                <div><dt>Floor area</dt><dd><span data-bind="area">0</span> sq.ft.</dd></div>
                <div><dt>Construction est.</dt><dd data-bind="constEst">LKR 0</dd></div>
            </dl>

            <div class="vh-aside__total">
                <span class="vh-aside__label">Indicative design fee</span>
                <strong data-bind="fee">LKR 0</strong>
                <small data-bind="basis">Enter your floor area to see the fee.</small>
            </div>

            <p class="vh-aside__note"><i class="fa-solid fa-shield-halved"></i> A preliminary design-fee estimate only. Your final proposal follows after our team reviews your requirements.</p>
        </aside>

        <div class="vh-main">
            <header class="vh-head">
                <div>
                    <span class="vh-head__step" data-bind="stepCount">Step 1 of 5</span>
                    <h3 id="vdTitle" data-bind="stepTitle">Package &amp; house details</h3>
                </div>
                <button type="button" class="vh-close" data-vh-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </header>
            <div class="vh-bar"><span data-bind="bar"></span></div>

            <form class="vh-body" id="vdForm" novalidate autocomplete="on">
                <div class="vh-hp" aria-hidden="true"><input type="text" name="hp_extra" tabindex="-1" autocomplete="off" data-lpignore="true" data-form-type="other"></div>

                {{-- STEP 1 --}}
                <section class="vh-step" data-step="details">
                    <p class="vh-hint">Choose your architectural design package and enter the combined floor area of all storeys.</p>

                    <div class="vh-switch vd-switch" data-package-switch role="radiogroup" aria-label="Design package"></div>

                    <div class="vh-grid">
                        <label class="vh-field">
                            <span>Total proposed floor area (sq.ft.) *</span>
                            <input class="vh-in" name="area" type="number" min="1" step="1" inputmode="decimal" required placeholder="e.g. 2,500">
                            <small class="vd-help">Use total built-up area across all floors, not land area.</small>
                        </label>
                        <label class="vh-field">
                            <span>House type</span>
                            <select class="vh-in" name="house_type">
                                @foreach (config('vega.design_house_types') as $t)<option>{{ $t }}</option>@endforeach
                            </select>
                        </label>
                        <label class="vh-field">
                            <span>Proposed construction district</span>
                            <select class="vh-in" name="district">
                                <option value="">Select district</option>
                                @foreach (config('vega.districts') as $d)<option>{{ $d }}</option>@endforeach
                            </select>
                        </label>
                        <div class="vh-field">
                            <span>{{ $showRates ? 'Estimated construction cost' : 'Approx. construction cost' }}</span>
                            <div class="vd-readonly" data-bind="constEst">LKR 0</div>
                            <small class="vd-help" data-bind="constNote">{{ $showRates ? 'Calculated automatically from your floor area.' : 'An approximate range based on your floor area.' }}</small>
                        </div>
                    </div>


                    @if ($showRates)
                        <div class="vh-notice" data-luxury-note hidden>
                            This package is calculated as a percentage of the estimated total construction cost. If you do not have a construction estimate,
                            contact Vega Homes for an assessment before relying on this figure.
                        </div>
                    @endif
                </section>

                {{-- STEP 2 --}}
                <section class="vh-step" data-step="addons">
                    <p class="vh-hint">Optional add-on services can be discussed and priced separately based on your project. They are not included in the package fee unless confirmed in your proposal.</p>
                    <div class="vd-addon-pick">
                        @foreach ($vdAddons as $slug => $addon)
                            <label class="vd-pick">
                                <input type="checkbox" name="addons" value="{{ $slug }}">
                                <span class="vd-pick__box">
                                    <i class="fa-solid {{ $vdAddonIcons[$slug] ?? 'fa-circle-plus' }}"></i>
                                    <b>{{ $addon[0] }}</b>
                                    <small>{{ $addon[1] }}</small>
                                    <em class="vd-pick__tick"><i class="fa-solid fa-check"></i></em>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </section>

                {{-- STEP 3 --}}
                <section class="vh-step" data-step="estimate">
                    <p class="vh-hint">Your indicative design fee updates automatically. You can still switch package below.</p>

                    <div class="vh-switch vd-switch" data-package-switch role="radiogroup" aria-label="Design package"></div>

                    <div class="vh-sum">
                        <div><span>Selected package</span><b data-bind="pkgName">—</b></div>
                        @if ($showRates)
                            <div><span>Calculation basis</span><b data-bind="basis">—</b></div>
                        @endif
                        <div><span>Proposed floor area</span><b><span data-bind="area">0</span> sq.ft.</b></div>
                        <div class="is-strong"><span>{{ $showRates ? 'Estimated construction cost' : 'Approx. construction cost' }}</span><b data-bind="constEst">LKR 0</b></div>
                    </div>

                    <div class="vh-estimate">
                        <span>Estimated design fee</span>
                        <strong data-bind="fee">LKR 0</strong>
                        <small data-bind="basis"></small>
                    </div>

                    <div class="vd-included">
                        <h4>What's included in <span data-bind="pkgName">this package</span></h4>
                        <ul data-list="features"></ul>
                    </div>

                    <p class="vh-notice">
                        This is an indicative design-fee estimate, not a final quotation or a construction-cost estimate. The final fee depends on confirmed floor area,
                        deliverables, complexity, revisions, structural and engineering scope, council submission requirements and other agreed services.
                        Council approval is subject to the relevant authority.
                    </p>
                </section>

                {{-- STEP 4 --}}
                <section class="vh-step" data-step="contact">
                    <p class="vh-hint">Tell us how to reach you and our design team will contact you with a detailed proposal.</p>
                    <div class="vh-grid">
                        <label class="vh-field">
                            <span>Full name *</span>
                            <input class="vh-in" name="name" required maxlength="120" autocomplete="name" placeholder="Your full name">
                        </label>
                        <label class="vh-field">
                            <span>Contact number (WhatsApp) *</span>
                            <input class="vh-in" name="phone" type="tel" required maxlength="40" autocomplete="tel" placeholder="07X XXX XXXX">
                        </label>
                        <label class="vh-field">
                            <span>Email (optional)</span>
                            <input class="vh-in" name="email" type="email" maxlength="190" autocomplete="email" placeholder="you@example.com">
                        </label>
                        <label class="vh-field">
                            <span>Expected design start (optional)</span>
                            <input class="vh-in" name="start_date" type="date">
                        </label>
                    </div>
                    <label class="vh-field">
                        <span>Additional requirements (optional)</span>
                        <textarea class="vh-in" name="comments" rows="3" maxlength="3000" placeholder="Preferred design, rooms or other requirements"></textarea>
                    </label>
                    <label class="vh-consent">
                        <input type="checkbox" name="consent" value="1" required>
                        <span>I agree that Vega Homes (Pvt) Ltd may contact me regarding this design enquiry.</span>
                    </label>
                </section>

                {{-- STEP 5 --}}
                <section class="vh-step" data-step="review">
                    <div class="vh-print-head">
                        <img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes">
                        <div>
                            <b>Architectural Design Fee Enquiry</b>
                            <span>Ref: <span data-bind="printRef">Draft</span> · <span data-bind="printDate"></span></span>
                        </div>
                    </div>
                    <p class="vh-hint vh-noprint">Please check everything below, then submit your enquiry.</p>
                    <div class="vh-review" id="vdReview"></div>
                    <p class="vh-notice">
                        <strong>Package reference:</strong> Essential covers consultation, concept plans, architectural plans, elevations, basic 3D views and council submission drawings.
                        Premium adds detailed drawings, 3D visualisation, interior layout and service layouts. Signature Luxury adds bespoke concept development, photorealistic renders,
                        interior 3D, landscape concept, structural drawings, detailed BOQ and design revisions. Optional add-ons are priced separately.
                    </p>
                    <button type="button" class="vh-btn vh-btn--ghost vh-noprint vh-print-btn" data-vh-print>
                        <i class="fa-solid fa-print"></i> Print / Save PDF
                    </button>
                </section>

                {{-- SUCCESS --}}
                <section class="vh-step vh-success" data-step="success">
                    <div class="vh-success__check"><i class="fa-solid fa-check"></i></div>
                    <h4>Thank you! Your enquiry is in.</h4>
                    <p>Reference <b data-bind="reference">—</b></p>
                    <p class="vh-success__est">Indicative design fee <strong data-bind="doneFee">—</strong></p>
                    <p class="vh-hint">Send the summary to our team on WhatsApp for the fastest response. We will also contact you shortly.</p>
                    <a class="vh-btn vh-btn--wa" id="vdWhatsapp" href="#" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i> Send on WhatsApp
                    </a>
                    <button type="button" class="vh-btn vh-btn--ghost" data-vh-print><i class="fa-solid fa-print"></i> Print / Save PDF</button>
                    <button type="button" class="vh-btn vh-btn--ghost" data-vh-close>Close</button>
                </section>

                <p class="vh-error" id="vdError" role="alert" hidden></p>
            </form>

            <footer class="vh-foot" id="vdFoot">
                <button type="button" class="vh-btn vh-btn--ghost" id="vdBack"><i class="fa-solid fa-arrow-left"></i> Back</button>
                <button type="button" class="vh-btn vh-btn--gold" id="vdNext">Next <i class="fa-solid fa-arrow-right"></i></button>
            </footer>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/design-estimator.js') }}?v=1"></script>
@endpush
@endif
