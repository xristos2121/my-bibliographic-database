<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <x-browse-sidebar/>
        </div>
        <div class="col-lg-9">
            <div class="generic-container-border browse-main-wrapper">
                <div class="browse-results-section">
                    <span class="browse-results-title">Publications for {{ $entityName }}: {{ $entityTitle }}</span>
                    <x-publications-browse :results="$results"/>
                </div>
            </div>
        </div>
    </div>
</div>
